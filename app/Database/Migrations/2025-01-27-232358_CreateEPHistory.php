<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEPHistory extends Migration
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
            'previous_status' => [
                'type' => 'smallint',
                'unsigned' => true,
                'null' => false,
            ],
            'current_status' => [
                'type' => 'smallint',
                'unsigned' => true,
                'null' => false,
            ],
            'updated_by' => [
                'type' => 'bigint',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('exception_paper_id', 'exception_papers', 'id', 'RESTRICT', 'RESTRICT');
        
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'RESTRICT', 'RESTRICT');
    
        $this->forge->createTable('exception_paper_history');
    }

    public function down()
    {
        $this->forge->dropTable('exception_paper_history');
    }
}
