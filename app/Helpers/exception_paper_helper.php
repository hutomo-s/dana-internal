<?php

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
        $return_obj->message = 'Your Role '. $user_data->role_name .' is not eligible to Create an Exception Paper';
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