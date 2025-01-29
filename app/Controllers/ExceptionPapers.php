<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class ExceptionPapers extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $db = \Config\Database::connect();

        $ep_list = $db->table('exception_papers')
                      ->select('*')
                      ->get()
                      ->getResult();

        $data = [
            'ep_list' => $ep_list,
        ];

        return view('dashboard/ep_index', $data);
    }

    public function waiting_my_approval()
    {
        $db = \Config\Database::connect();
        $session = service('session');
        $data = [];

        $my_user_id = $session->get('user_id');

        $user = $db->table('users')
                ->select('users.*, roles.role_code')
                ->join('roles', 'roles.id = users.role_id')
                ->where('users.id', $my_user_id)
                ->get(1)
                ->getRow();

        $my_role_code = $user->role_code;

        if($my_role_code === 'LINE_MANAGER')
        {
            $ep_list = $db->table('exception_paper_approval')
                          ->select('*')
                          ->join('exception_papers', 'exception_papers.id = exception_paper_approval.exception_paper_id')
                          ->where('exception_paper_approval.user_id_approver', $my_user_id)
                          ->get()
                          ->getResult();

            $data['ep_list'] = $ep_list;

            return view('dashboard/ep_waiting_my_approval', $data);
        }

        return view('dashboard/ep_waiting_my_approval', $data);
    }

    public function create()
    {
        helper('exception_paper');

        $authorize_ep_create = authorize_ep_create();

        $date = Time::now()->toDateString();;

        $data = [
            'warning_message' => $authorize_ep_create->message,
            'is_eligible_submit' => $authorize_ep_create->is_eligible,
            'api_ep_store' => base_url('api/exception-papers/store'),
            'date' => $date,
        ];

        return view('dashboard/ep_create', $data);
    }

    /**
     * AJAX Call
     * Method: POST
     * URL: /api/exception-papers/store
     */
    public function store()
    {
        $db = \Config\Database::connect();
        $ep_model = new \App\Models\ExceptionPaper();
        $ep_approval_model = new \App\Models\EPApproval();
        $request = request();
        $validation = service('validation');
        helper('exception_paper');

        // from exception_paper_helper
        $authorize_ep_create = authorize_ep_create();

        if($authorize_ep_create->is_eligible === false)
        {
            $response = [
                'success' => false,
                'message' => $authorize_ep_create->message,
                'redirect_url' => null,
            ];
    
            return $this->respond($response, 400);
        }

        $rules = $this->validation_rules();

        $validation->setRules($rules);
        
        $post_data = $request->getPost();

        if(!$validation->run($post_data)) {
            $errors = $validation->getErrors();
            
            $response = [
                'success' => false,
                'message' => 'Error',
                'redirect_url' => null,
                'error_messages' => array_values($errors),
            ];
    
            return $this->respond($response, 400);
        }

        $ep_data = $this->build_ep_data($post_data);

        $db->transStart();
        
        // insert to table `exception_papers`
        $ep_model->insert($ep_data);

        $ep_id = $ep_model->getInsertID();

        // upload file
        $files = $this->request->getFiles();
        $ep_attachments = $this->upload_attachments($files, $ep_id);

        // insert to table `exception_paper_attachments`
        if(count($ep_attachments) > 0)
        {
            $db->table('exception_paper_attachments')
               ->insertBatch($ep_attachments);
        }

        // from exception_paper_helper
        $ep_approval_data = build_ep_approval_data(
            $ep_id,
            $ep_data['exception_status'],
            $ep_data['request_cost_currency'],
            $ep_data['request_cost_amount']
        );
        
        // insert to table `exception_paper_approval`
        $ep_approval_model->insert($ep_approval_data);

        $current_status = $ep_data['exception_status'];

        // from exception_paper_helper
        $ep_history_data = build_ep_history_data($ep_id, 0, $current_status);

        // insert to table `exception_paper_history`
        $db->table('exception_paper_history')
           ->insert($ep_history_data);

        $db->transComplete();

        // redirect to /dashboard/exception-papers
        $response = [
            'success' => true,
            'message' => 'Exception Paper Created Successfully',
            'redirect_url' => base_url('dashboard/exception-papers'),
            'error_messages' => [],
        ];

        return $this->respond($response, 200);
    }

    private function validation_rules()
    {
        $rules = [
            'purchase_title' => [
                'label' => 'Purchase Title',
                'rules' => 'required|max_length[255]|min_length[1]',
            ],
            'pr_number' => [
                'label' => 'PR Number',
                'rules' => 'permit_empty|max_length[255]|min_length[1]',
            ],
            'exception_reason' => [
                'label' => 'Exception Reason',
                'rules' => 'required',
            ],
            'exception_impact' => [
                'label' => 'Exception Impact',
                'rules' => 'required',
            ],
            'request_cost_currency' => [
                'label' => 'Currency',
                'rules' => 'required|in_list[IDR]',
            ],
            'request_cost_amount' => [
                'label' => 'Cost to Process',
                'rules' => 'required|integer'
            ],
            'request_due_date' => [
                'label' => 'Due Date',
                'rules' => 'valid_date[Y-m-d]',
            ],
            'requestor_statement_check' => [
                'label' => 'Requestor Statement',
                'rules' => 'required|in_list[on]',
                'errors' => [
                    'required' => 'Please tick the {field} to continue.',
                ],
            ],
            'reason_file' => [
                'label' => 'The reason attachment',
                'rules' => 'permit_empty|uploaded[reason_file]',
            ],
            'impact_file' => [
                'label' => 'The impact attachment',
                'rules' => 'permit_empty|uploaded[impact_file]',
            ],
        ];

        return $rules;
    }

    private function build_ep_data($post_data)
    {
        $session = service('session');
        helper('exception_paper');

        $requestor_id = $session->get('user_id');
        $created_at = Time::now()->toDateTimeString();
        $exception_status = get_ep_status('CREATED_BY_REQUESTOR');

        $ep_data = [
            'requestor_id' => $requestor_id,
            'created_at' => $created_at,
            'request_due_date' => $post_data['request_due_date'],
            'purchase_title' => $post_data['purchase_title'],
            'pr_number' => $post_data['pr_number'],
            'exception_reason' => $post_data['exception_reason'],
            'exception_impact' => $post_data['exception_impact'],
            'request_cost_currency' => $post_data['request_cost_currency'],
            'request_cost_amount' => $post_data['request_cost_amount'],
            'exception_status' => $exception_status,
            'is_complete' => false,
        ];

        return $ep_data;
    }

    private function upload_attachments($files, $ep_id)
    {
        helper('upload_file');

        $attachments = [];

        foreach($files['reason_file'] as $reason_file)
        {
            $fullpath = upload_single_file($reason_file);

            if($fullpath)
            {
                $attachment = [
                    'exception_paper_id' => $ep_id,
                    'attachment_category' => 'reason',
                    'attachment_fullpath' => $fullpath,
                ];

                array_push($attachments, $attachment);
            }
        }

        foreach($files['impact_file'] as $impact_file)
        {
            $fullpath = upload_single_file($impact_file);

            if($fullpath)
            {
                $attachment = [
                    'exception_paper_id' => $ep_id,
                    'attachment_category' => 'impact',
                    'attachment_fullpath' => $fullpath,
                ];

                array_push($attachments, $attachment);
            }
        }

        return $attachments;
    }

}