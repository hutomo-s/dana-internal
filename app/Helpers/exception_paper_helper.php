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

function build_ep_approval_data($ep_id, $current_status, $currency, $amout)
{
    $db = \Config\Database::connect();
    $session = service('session');
    
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

    $ep_approval_data = [
        'exception_paper_id' => $ep_id,
        'current_status' => $current_status,
        'next_status' => $next_status,
        'department_id_approver' => $department_id_approver,
        'role_id_approver' => $role_id_approver,
        'user_id_approver' => $user_id_approver ?? null,
        'is_pending' => true,
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

function is_need_my_approval($ep_id, $my_user_id)
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
        return false;
    }

    $user_id_approver = $ep_approval_data->user_id_approver;

    // no need approval if user_id_appover is not match with current user
    // and user_id_approver is specified
    if(!empty($user_id_approver) && $user_id_approver != $my_user_id)
    {
        return false;
    }

    return true;
}