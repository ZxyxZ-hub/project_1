<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateForms extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'from_name'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'date_received' => ['type' => 'DATETIME', 'null' => true],
            'origin'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'reference_no'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'subject'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'instructions'  => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('reference_no');
        $this->forge->addKey('date_received');
        $this->forge->addKey('from_name');

        $this->forge->createTable('forms');
    }

    public function down()
    {
        $this->forge->dropTable('forms');
    }
}
