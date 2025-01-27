<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // redirect to dashboard if logged in
        $session = service('session');

        if($session->get('dashboard_logged_in') === true)
        {
            return redirect()->to(site_url('dashboard'));
        }

        $data = [
            'api_login_submit' => base_url('api/login/submit'),
        ];

        return view('dashboard/login_index', $data);
    }

    /**
     * AJAX Call
     * Method: POST
     * URL: /api/login/submit
     */
    public function submit()
    { 
        $userModel = new \App\Models\User();
        $request = request();
        $post_data = $request->getPost();

        $validation = service('validation');

        // validate email format
        $rules = [
            'email' => 'required|max_length[120]|valid_email',
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
        
        $user = $userModel->where('user_email', $post_data['email'])
                          ->first();

        // check if email is registered
        if(empty($user)) {
            $response = [
                'success' => false,
                'message' => 'Error: The email '. $post_data['email']  .' is not registered on this site.',
                'redirect_url' => null,
                'error_messages' => '',
            ];

            return $this->respond($response, 400);
        }

        // check if email is inactive
        if($user['is_active'] == '0') {
            $response = [
                'success' => false,
                'message' => 'Error: The email '. $post_data['email']  .' has been deactivated.',
                'redirect_url' => null,
                'error_messages' => '',
            ];

            return $this->respond($response, 400);
        }

        // set session
        $user_id = $user['id'];

        $this->set_dashboard_session($user_id);

        // redirect to dashboard
        $response = [
            'success' => true,
            'message' => 'Login Success',
            'redirect_url' => base_url('dashboard'),
            'error_messages' => [],
        ];

        return $this->respond($response, 200);
    }

    /**
     * Set Login Session
     */
    private function set_dashboard_session($user_id)
    {
        $db = \Config\Database::connect();
        $session = service('session');

        $builder = $db->table('users');
        $builder->select('users.*, departments.department_code, roles.role_code');
        $builder->join('roles', 'roles.id = users.role_id');
        $builder->join('departments', 'departments.id = users.department_id');
        $builder->where('users.id', $user_id);
        
        $query = $builder->get(1);
        
        $result = $query->getResult();

        $user_data = end($result);

        $session_data = [
            'user_id' => $user_data->id,
            'user_email' => $user_data->user_email,
            'display_name' => $user_data->display_name,
            'department_code' => $user_data->department_code,
            'role_code' => $user_data->role_code,
            'line_manager_id' => $user_data->line_manager_id,
            'dashboard_logged_in' => true,
        ];

        $session->set($session_data);

        return true;
    }
}
