<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedRoles extends Seeder
{
    public function run()
    {
        $multiple_rows = [
            [
                'role_code' => 'STAFF',
                'role_name' => 'Staff',
            ],
            [
                'role_code' => 'LINE_MANAGER',
                'role_name' => 'Line Manager',
            ],
            [
                'role_code' => 'C_LEVEL',
                'role_name' => 'C Level',
            ],
        ];

        $this->db->table('roles')->upsertBatch($multiple_rows);
    }
}