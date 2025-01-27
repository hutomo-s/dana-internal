<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedDepartments extends Seeder
{
    public function run()
    {
        $multiple_rows = [
            [
                'department_code' => 'EXECUTIVE',
                'department_name' => 'Executive',
            ],
            [
                'department_code' => 'FINANCIAL',
                'department_name' => 'Financial',
            ],
            [
                'department_code' => 'OPERATIONS',
                'department_name' => 'Operations',
            ],
            [
                'department_code' => 'PROCUREMENT',
                'department_name' => 'Procurement',
            ],
        ];

        $this->db->table('departments')->upsertBatch($multiple_rows);
    }
}
