<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,      
                'auto_increment' => true,
            ],
            'galert_id' => [
                'type'       => 'varchar',
                'constraint' => 300,      
                'null'       => false,
            ],
            'name' => [
                'type'       => 'varchar',
                'constraint' => 50,      
                'null'       => false,
                'unique'     => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('galert_id','galert_data','galert_id','CASCADE','CASCADE');
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
