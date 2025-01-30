<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterExceptionPapers extends Migration
{
    public function up()
    {
        $fields = [
            'generated_pdf_fullpath' => [
                'type' => 'varchar',
                'constraint' => 512,
                'null' => true,
            ],
        ];
        
        $this->forge->addColumn('exception_papers', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('exception_papers', 'generated_pdf_fullpath');
    }
}