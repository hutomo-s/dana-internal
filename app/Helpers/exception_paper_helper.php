<?php
use CodeIgniter\I18n\Time;

function authorize_ep_create()
{
    $db = \Config\Database::connect();
    $session = service('session');

    $user_id = $session->get('user_id');

    $builder = $db->table('users');
    $builder->select('users.id as user_id, users.*, departments.*, roles.*');
    $builder->join('roles', 'roles.id = users.role_id');
    $builder->join('departments', 'departments.id = users.department_id');
    $builder->where('users.id', $user_id);

    $query = $builder->get(1);

    $user_data = $query->getRow();

    if($user_data->role_code !== 'STAFF')
    {
        $return_obj = new stdClass;
        $return_obj->is_eligible = false;
        $return_obj->message = 'Your Role: '. $user_data->role_name .' is not eligible to Create an Exception Paper';
        return $return_obj;
    }

    if(empty($user_data->line_manager_id))
    {
        $return_obj = new stdClass;
        $return_obj->is_eligible = false;
        $return_obj->message = 'You are not eligible to Create An Exception Paper. Please Contact Administrator to Assign A Line Manager for Your Account';
        return $return_obj;
    }        
    
    $return_obj = new stdClass;
    $return_obj->is_eligible = true;
    $return_obj->message = '';
    return $return_obj;
}

function get_ep_status($status_code)
{   
    $all_ep_status = all_ep_status();

    if(!empty($all_ep_status[$status_code]))
    {
        return $all_ep_status[$status_code];
    }

    return '';
}

function all_ep_status()
{
    $data = [
        'CREATED_BY_REQUESTOR' => 1,
        'APPROVED_BY_LINE_MANAGER' => 2,
        'APPROVED_BY_EXCOM_1' => 3,
        'APPROVED_BY_EXCOM_2' => 4,
        'APPROVED_BY_CEO' => 5,
        'SUBMITTED_TO_PROCUREMENT' => 6,
    ];

    return $data;
}

function build_ep_approval_data($ep_id, $current_status, $currency, $amount)
{
    $db = \Config\Database::connect();
    $session = service('session');

    // default value for is_pending
    $is_pending = true;
    
    // current status 1: CREATED_BY_REQUESTOR
    if($current_status == 1)
    {
        // from exception_paper_helper
        $next_status = get_ep_status('APPROVED_BY_LINE_MANAGER');
    
        // same as users.department_id
        $department_id_approver = $session->get('department_id');
        
        // role id for line manager
        $role_id_approver = get_role_id('LINE_MANAGER');

        // line_manager_id for current user
        $user_id_approver = $session->get('line_manager_id');
    }
    // current status 2: APPROVED_BY_LINE_MANAGER
    else if($current_status == 2)
    {
        // from exception_paper_helper
        $next_status = get_ep_status('APPROVED_BY_EXCOM_1');

        $ep_data = $db->table('exception_papers')
                      ->select('exception_papers.requestor_id, users.department_id as department_id')
                      ->join('users', 'users.id = exception_papers.requestor_id')
                      ->where('exception_papers.id', $ep_id)
                      ->get()
                      ->getRow();
        
        // same as users.department_id
        $department_id_approver = $ep_data->department_id;
    
        // approver role is C_LEVEL
        $role_id_approver = get_role_id('C_LEVEL');
    }
    // current status 3: APPROVED_BY_EXCOM_1
    else if($current_status == 3)
    {
        // from exception_paper_helper
        $next_status = get_ep_status('APPROVED_BY_EXCOM_2');

        // department id should be FINANCIAL
        $department_id_approver = get_department_id('FINANCIAL');

        // approver role is C_LEVEL
        $role_id_approver = get_role_id('C_LEVEL');
    }
    // current status 4: APPROVED_BY_EXCOM_2
    else if($current_status == 4)
    {
        // if the cost proceed the order > IDR 200 000 000
        // need approval from CEO
        if($currency == 'IDR' && $amount > 200000000)
        {
            $next_status = get_ep_status('APPROVED_BY_CEO');
            
            // department id should be EXECUTIVE
            $department_id_approver = get_department_id('EXECUTIVE');

            // approver role is C_LEVEL
            $role_id_approver = get_role_id('C_LEVEL');
        }
        else
        {
            $next_status = get_ep_status('SUBMITTED_TO_PROCUREMENT');
            
            // department id should be PROCUREMENT
            $department_id_approver = get_department_id('PROCUREMENT');

            // role_id can be any role
            $role_id_approver = 0;

            $is_pending = false;
        }
    }

    $ep_approval_data = [
        'exception_paper_id' => $ep_id,
        'current_status' => $current_status,
        'next_status' => $next_status,
        'department_id_approver' => $department_id_approver,
        'role_id_approver' => $role_id_approver,
        'user_id_approver' => $user_id_approver ?? null,
        'is_pending' => $is_pending,
    ];

    return $ep_approval_data;
}

function build_ep_history_data($ep_id, $previous_status, $current_status)
{
    $session = service('session');

    $updated_at = Time::now()->toDateTimeString();

    $updated_by = $session->get('user_id');

    $ep_history_data = [
        'exception_paper_id' => $ep_id,
        'previous_status' => $previous_status,
        'current_status' => $current_status,
        'updated_by' => $updated_by,
        'updated_at' => $updated_at,
    ];

    return $ep_history_data;
}

function get_role_code($my_user_id)
{
    $db = \Config\Database::connect();

    $user = $db->table('users')
               ->select('users.*, roles.role_code')
               ->join('roles', 'roles.id = users.role_id')
               ->where('users.id', $my_user_id)
               ->get(1)
               ->getRow();

    return $user->role_code;
}

function get_role_id($role_code)
{
    $db = \Config\Database::connect();

    $role_data = $db->table('roles')
               ->select('id')
               ->where('role_code', $role_code)
               ->get(1)
               ->getRow();

    return $role_data->id;
}

function get_department_id($department_code)
{
    $db = \Config\Database::connect();

    $department_data = $db->table('departments')
                          ->select('id')
                          ->where('department_code', $department_code)
                          ->get(1)
                          ->getRow();

    return $department_data->id;
}

function check_ep_approval($ep_id, $my_user_id)
{
    $db = \Config\Database::connect();

    $user_model = new \App\Models\User();

    $user = $user_model->find($my_user_id);

    $department_id_approver = $user['department_id'];
    $role_id_approver = $user['role_id'];

    $ep_approval_data = $db->table('exception_paper_approval')
                            ->select('*')
                            ->where('exception_paper_id', $ep_id)
                            ->where('department_id_approver', $department_id_approver)
                            ->where('role_id_approver', $role_id_approver)
                            ->where('is_pending', true)
                            ->get(1)
                            ->getRow();
    
    // no need approval if no data found in `exception_paper_approval`
    if(empty($ep_approval_data))
    {
        return [
            'is_need_my_approval' => false,
            'ep_approval_id' => null,
            'previous_status' => null,
            'next_status' => null,
        ];
    }

    $user_id_approver = $ep_approval_data->user_id_approver;

    // no need approval if user_id_appover is not match with current user
    // and user_id_approver is specified
    if(!empty($user_id_approver) && $user_id_approver != $my_user_id)
    {
        return [
            'is_need_my_approval' => false,
            'ep_approval_id' => null,
            'previous_status' => null,
            'next_status' => null,
        ];
    }

    $ep_approval_id = $ep_approval_data->id;
    
    $next_status = $ep_approval_data->next_status;
    
    $previous_status = $ep_approval_data->current_status;

    return [
        'is_need_my_approval' => true,
        'ep_approval_id' => $ep_approval_id,
        'previous_status' => $previous_status,
        'next_status' => $next_status,
    ];
}

function rewrite_img_src($fullpath, $is_html_preview = false)
{
    if(empty($fullpath))
    {
        return null;
    }

    if($is_html_preview)
    {
        return $fullpath;
    }

    $os_fullpath = ROOTPATH.'public'.$fullpath;

    return $os_fullpath;
}

function generate_pdf_ep($ep_id, $is_html_preview = false)
{
    $db = \Config\Database::connect();

    $ep_data = $db->table('exception_papers')
                  ->select('*')
                  ->where('exception_papers.id', $ep_id)
                  ->get(1)
                  ->getRow();

    $ep_attachments = $db->table('exception_paper_attachments')
                         ->select('*')
                         ->where('exception_paper_id', $ep_id)
                         ->get()
                         ->getResult();

    $ep_attachments_reason = array_filter($ep_attachments, function($epa) {
        return $epa->attachment_category === 'reason';
    });
        
    $ep_attachments_impact = array_filter($ep_attachments, function($epa) {
        return $epa->attachment_category === 'impact';
    });

    $ep_history_db = $db->table('exception_paper_history')
                        ->select('exception_paper_history.*, users.display_name, users.signature_image_fullpath')
                        ->join('users', 'users.id = exception_paper_history.updated_by', 'left')
                        ->where('exception_paper_history.exception_paper_id', $ep_id)
                        ->get()
                        ->getResult();

    $ep_history_list = [
        'requestor' => [
            'name' => '',
            'signature' => '',
        ],
        'line_manager' => [
            'name' => '',
            'signature' => '',
        ],
        'excom_1' => [
            'name' => '',
            'signature' => '',
        ],
        'excom_2' => [
            'name' => '',
            'signature' => '',
        ],
        'ceo' => [
            'name' => '',
            'signature' => '',
        ],
    ];

    $default_signature_html = base_url('assets/image/automatic_signature.png');
    
    $default_signature_os = ROOTPATH.'public/assets/image/automatic_signature.png';

    if($is_html_preview)
    {
        $default_signature = $default_signature_html;
    }
    else
    {
        $default_signature = $default_signature_os;
    }

    foreach($ep_history_db as $ephdb)
    {
        $current_status = $ephdb->current_status;

        switch($current_status)
        {
            case 1:
                $ep_history_list['requestor']['name'] = $ephdb->display_name;
                $ep_history_list['requestor']['signature'] = rewrite_img_src($ephdb->signature_image_fullpath, $is_html_preview) ?? $default_signature;
            break;

            case 2:
                $ep_history_list['line_manager']['name'] = $ephdb->display_name;
                $ep_history_list['line_manager']['signature'] = rewrite_img_src($ephdb->signature_image_fullpath, $is_html_preview) ?? $default_signature;
            break;

            case 3:
                $ep_history_list['excom_1']['name'] = $ephdb->display_name;
                $ep_history_list['excom_1']['signature'] = rewrite_img_src($ephdb->signature_image_fullpath, $is_html_preview) ?? $default_signature;
            break;

            case 4:
                $ep_history_list['excom_2']['name'] = $ephdb->display_name;
                $ep_history_list['excom_2']['signature'] = rewrite_img_src($ephdb->signature_image_fullpath, $is_html_preview) ?? $default_signature;
            break;

            case 5:
                $ep_history_list['ceo']['name'] = $ephdb->display_name;
                $ep_history_list['ceo']['signature'] = rewrite_img_src($ephdb->signature_image_fullpath, $is_html_preview) ?? $default_signature;
            break;
        }
    }

    $data = [
        'ep_data' => $ep_data,
        'ep_attachments_reason' => $ep_attachments_reason,
        'ep_attachments_impact' => $ep_attachments_impact,
        'ep_history_list' => $ep_history_list,
    ];
    
    if($is_html_preview)
    {
        return [
            'html_content' => view('pdf/exception_paper_pdf', $data)
        ];
    }

    $mpdf = new \Mpdf\Mpdf();

    $html_content = view('pdf/exception_paper_pdf', $data);
    
    $mpdf->WriteHTML($html_content);

    $target_folder_os = ROOTPATH.'public/uploads/'.date('Y').'/'.date('m');

    $filename = 'epform_'. $ep_id .'.pdf';

    $fullpath_os = $target_folder_os.'/'.$filename;

    $target_folder_path = '/uploads/'.date('Y').'/'.date('m');
 
    $fullpath = $target_folder_path.'/'.$filename;

    $mpdf->Output($fullpath_os, \Mpdf\Output\Destination::FILE);

    return [
        'url' => base_url($fullpath),
        'os_fullpath' => $fullpath_os,
    ];
}