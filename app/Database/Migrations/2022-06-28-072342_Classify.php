<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Classify extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'data_bersih' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'id_predicted' => [
                'type'           => 'int',
                'constraint'     => 11,    
                'null'           => false,  
            ],
            'id_actual' => [
                'type'           => 'int',
                'constraint'     => 11,    
                'null'           => false,  
            ],
        ]);

        $this->forge->addForeignKey('id_predicted','kategori','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_actual','kategori','id','CASCADE','CASCADE');
        $this->forge->createTable('classify');
    }

    public function down()
    {
        $this->forge->dropTable('classify');
    }
}
