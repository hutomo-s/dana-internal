<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CreateSuperuser extends Seeder
{
    public function run()
    {
        $now = \CodeIgniter\I18n\Time::now();

        $role_data = [
            'role_code' => 'SUPERUSER',
            'role_name' => 'Super User',
        ];

        $department_data = [
            'department_code' => 'TECHNOLOGY',
            'department_name' => 'Technology',
        ];

        $this->db->query('INSERT INTO roles (role_code, role_name) VALUES(:role_code:, :role_name:)', $role_data);
        
        $role_id = $this->db->insertID(); 

        $this->db->query('INSERT INTO departments (department_code, department_name) VALUES(:department_code:, :department_name:)', $department_data);
        
        $department_id = $this->db->insertID();

        $user_data = [
            'user_email' => 'hutomo@sandbox.dana.id',
            'display_name' => 'Hutomo',
            'role_id' => $role_id,
            'department_id' => $department_id,
            'line_manager_id' => null,
            'signature_image_fullpath' => null,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => null,
            'is_active' => true,
        ];

        $this->db->table('users')->insert($user_data);
    }
}
