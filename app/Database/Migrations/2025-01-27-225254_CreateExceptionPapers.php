<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExceptionPaper extends Migration
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
            'requestor_id' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'request_due_date' => [
                'type' => 'date',
                'null' => false,
            ],
            'purchase_title' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => false,
            ],
            'pr_number' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
            ],
            'exception_reason' => [
                'type' => 'mediumtext',
                'null' => false,
            ],
            'exception_impact' => [
                'type' => 'mediumtext',
                'null' => false,
            ],
            'request_cost_currency' => [
                'type' => 'ENUM',
                'constraint' => ['IDR'],
                'default' => 'IDR',
            ],
            'request_cost_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '16,2',
                'null' => false,
                'default' => 0,
            ],
            'exception_status' => [
                'type' => 'smallint',
                'unsigned' => true,
                'null' => false,
            ],
            'is_complete' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
                'default' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('requestor_id', 'users', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('exception_papers');
    }

    public function down()
    {
        $this->forge->dropTable('exception_papers');
    }
}
