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
        $data = [];

        return view('dashboard/ep_index', $data);
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
        helper('exception_paper');
        
        $request = request();
        $validation = service('validation');
        $session = service('session');

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

        $requestor_id = $session->get('user_id');
        $created_at = Time::now()->toDateTimeString();

        // from exception_paper_helper
        $exception_status = get_ep_status('CREATED_BY_REQUESTOR');

        $exception_paper_data = [
            'requestor_id' => $requestor_id,
            'created_at' => $created_at,
            'exception_status' => $exception_status,
        ];

        // upload file
        $files = $this->request->getFiles();
        $attachments = $this->upload_attachments($files);

        $user_id_approver = $session->get('line_manager_id');
    }

    private function validation_rules()
    {
        $rules = [
            'purchase_title' => [
                'label' => 'Purchase Title',
                'rules' => 'required|max_length[255]|min_length[5]',
            ],
            'pr_number' => [
                'label' => 'PR Number',
                'rules' => 'permit_empty|max_length[255]|min_length[5]',
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

    private function upload_attachments($files)
    {
        helper('upload_file');

        $attachments = [];

        foreach($files['reason_file'] as $reason_file)
        {
            $fullpath = upload_single_file($reason_file);

            if($fullpath)
            {
                $attachment = [
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
                    'attachment_category' => 'impact',
                    'attachment_fullpath' => $fullpath,
                ];

                array_push($attachments, $attachment);
            }
        }

        return $attachments;
    }
}
