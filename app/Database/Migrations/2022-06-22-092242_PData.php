<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PData extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori' => [
                'type'           => 'int',
                'constraint'     => 11,    
                'null'           => false,  
            ],
            'kata' => [
                'type'       => 'varchar',
                'constraint' => '100',  
                'null'       => false,
            ],
            'jml_data' => [
                'type'           => 'int',
                'constraint'     => 11,
                'default'        => 0
            ],
            'nilai' => [
                'type'       => 'float',
                'constraint' => '10,10',  
                'default'    => 0,
            ],
        ]);

        $this->forge->addForeignKey('id_kategori','kategori','id','CASCADE','CASCADE');
        $this->forge->createTable('p_data');
    }

    public function down()
    {
        $this->forge->dropTable('p_data');
    }
}
