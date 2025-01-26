<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'user_email' => [
                'type' => 'varchar',
                'constraint' => 120,
                'null' => false,
                'unique' => true,
            ],
            'display_name' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => false,
            ],
            'role_id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'department_id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'line_manager_id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'signature_image_fullpath' => [
                'type' => 'varchar',
                'constraint' => 512,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('role_id', 'roles', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->addForeignKey('department_id', 'departments', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->addForeignKey('line_manager_id', 'users', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}