<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GalertData extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'galert_id' => [
                'type'       => 'varchar',
                'constraint' => 300,      
                'null'       => false,
                'default'    => ''
            ],
            'galert_title' => [
                'type'       => 'text',
                'unique'     => true,
                'null'       => true,
                'default'    => null
            ],
            'galert_link' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'galert_update' => [
                'type'       => 'tinytext',
                'null'       => true,
                'default'    => null
            ],
        ]);

        $this->forge->addPrimaryKey('galert_id');
        $this->forge->createTable('galert_data');
    }

    public function down()
    {
        $this->forge->dropTable('galert_data');
    }
}
