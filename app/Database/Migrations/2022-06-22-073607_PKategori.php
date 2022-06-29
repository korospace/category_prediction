<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PKategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori' => [
                'type'           => 'int',
                'constraint'     => 11,      
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
            'tmp_nilai' => [
                'type'       => 'float',
                'constraint' => '10,10',  
                'default'    => 0,
            ],
        ]);

        $this->forge->addPrimaryKey('id_kategori');
        $this->forge->addForeignKey('id_kategori','kategori','id','CASCADE','CASCADE');
        $this->forge->createTable('p_kategori');
    }

    public function down()
    {
        $this->forge->dropTable('p_kategori');
    }
}
