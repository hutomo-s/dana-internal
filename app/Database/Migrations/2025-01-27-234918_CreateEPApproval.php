<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEPApproval extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'exception_paper_id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'current_status' => [
                'type' => 'smallint',
                'unsigned' => true,
                'null' => false,
            ],
            'next_status' => [
                'type' => 'smallint',
                'unsigned' => true,
                'null' => false,
            ],
            'department_id_approver' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'role_id_approver' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'user_id_approver' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'is_pending' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
                'default' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('exception_paper_id', 'exception_papers', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('exception_paper_approval');
    }

    public function down()
    {
        $this->forge->dropTable('exception_paper_approval');
    }
}