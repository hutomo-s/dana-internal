<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Users extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('users');
        $builder->select('users.id as user_id, users.*, departments.*, roles.*');
        $builder->join('roles', 'roles.id = users.role_id');
        $builder->join('departments', 'departments.id = users.department_id');
        $builder->orderBy('users.is_active DESC, departments.department_code ASC');

        $query = $builder->get();

        $users = $query->getResult();

        $data = [
            'users' => $users,
        ];

        return view('dashboard/users_index', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();

        $departments = $db->table('departments')->get()->getResult();
        
        $roles = $db->table('roles')->get()->getResult();
        
        $data = [
            'departments' => $departments,
            'roles' => $roles,
            'api_user_store' => base_url('api/users/store'),
            'api_get_line_managers' => base_url('api/users/get_line_manager'),
        ];

        return view('dashboard/users_create', $data);
    }

    /**
     * AJAX Call
     * Method: GET
     * URL: /api/user/get_line_manager/[role_id]/[department_id]
     */
    public function get_line_managers($role_id, $department_id) 
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('roles');
        $builder->where('id', $role_id);
        $query = $builder->get();
        $role = $query->getRowObject();
        
        if($role->role_code !== 'STAFF')
        {
            $response = [
                'success' => true,
                'message' => 'No Line Manager Available for Role Code Outside STAFF',
                'error_messages' => [],
                'show_select_line_manager' => false,
            ];
    
            return $this->respond($response, 200);
        }
        
        $builder = $db->table('users');
        $builder->select('users.id, users.display_name, roles.role_code, departments.department_code');
        $builder->join('roles', 'roles.id = users.role_id');
        $builder->join('departments', 'users.department_id = departments.id');
        $builder->where('roles.role_code', 'LINE_MANAGER');
        $builder->where('users.department_id', $department_id);

        $query = $builder->get();

        $result = $query->getResult();

        $response = [
            'success' => true,
            'message' => 'Please Select Line Manager. '. count($result) .' Line Manager(s) available.',
            'error_messages' => [],
            'enable_select_line_manager' => true,
            'result' => $result,
        ];

        return $this->respond($response, 200);
    }

    /**
     * AJAX Call
     * Method: POST
     * URL: /api/users/store
     */
    public function store()
    {
        $user_model = new \App\Models\User();
        $request = request();
        $validation = service('validation');
        helper('upload_file');

        $post_data = $request->getPost();

        $rules = [
            'user_email' => 'required|max_length[120]|valid_email|is_unique[users.user_email]',
            'display_name' => 'required|max_length[255]|alpha_space',
            'role_id' => 'required|integer',
            'department_id' => 'required|integer',
            'line_manager_id' => 'permit_empty|integer',
            'is_active' => 'required|integer|in_list[0,1]',
            'signature_image' => [
                'label' => 'Signature',
                'rules' => [
                    'permit_empty',
                    'uploaded[signature_image]',
                    'is_image[signature_image]',
                    'mime_in[signature_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    'max_size[signature_image,2048]',
                ]
            ],
        ];

        $validation->setRules($rules);

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

        $signature_image = $this->request->getFile('signature_image');
        
        // upload signature image
        $signature_image_fullpath = upload_single_file($signature_image);

        $created_at = Time::now()->toDateTimeString();

        $user_data = [
            'user_email' => $post_data['user_email'],
            'display_name' => $post_data['display_name'],
            'role_id' => $post_data['role_id'],
            'department_id' => $post_data['department_id'],
            'line_manager_id' => $post_data['line_manager_id'] ?? null,
            'signature_image_fullpath' => $signature_image_fullpath,
            'is_active' => $post_data['is_active'],
            'created_at' => $created_at,
        ];

        $user_model->insert($user_data);

        // redirect to /dashboard/users
        $response = [
            'success' => true,
            'message' => 'User Created Successfully',
            'redirect_url' => base_url('dashboard/users'),
            'error_messages' => [],
        ];

        return $this->respond($response, 200);
    }
}