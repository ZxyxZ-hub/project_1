
#<?php

#namespace App\Database\Migrations;

# use CodeIgniter\Database\Migration;

##class AddMissingFieldsToForms extends Migration
#{
#    public function up()
 #   {
  #      // Check if columns already exist before adding them
  #      if ($this->db && ! $this->db->fieldExists('date_issued', 'forms')) {
  #          $this->forge->addColumn('forms', [
  #              'date_issued' => ['type' => 'DATETIME', 'null' => true],
  #          ]);
  #      }

  #      if ($this->db && ! $this->db->fieldExists('target_date', 'forms')) {
  #          $this->forge->addColumn('forms', [
  #              'target_date' => ['type' => 'DATETIME', 'null' => true],
 #           ]);
 #       }
 #   }
#
 #   public function down()
 #   {
 #       if ($this->db && $this->db->fieldExists('date_issued', 'forms')) {
 #           $this->forge->dropColumn('forms', 'date_issued');
 #       }
#
 #       if ($this->db && $this->db->fieldExists('target_date', 'forms')) {
  #          $this->forge->dropColumn('forms', 'target_date');
 #       }
#    }
#}
