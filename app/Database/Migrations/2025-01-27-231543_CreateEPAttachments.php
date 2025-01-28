<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEPAttachments extends Migration
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
            'attachment_category' => [
                'type' => 'ENUM',
                'constraint' => ['reason', 'impact'],
                'null' => false,
            ],
            'attachment_fullpath' => [
                'type' => 'varchar',
                'constraint' => 512,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('exception_paper_id', 'exception_papers', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('exception_paper_attachments');
    }

    public function down()
    {
        $this->forge->dropTable('exception_paper_attachments');
    }
}
