<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Preprocessing extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'no' => [
                'type'           => 'int',
                'constraint'     => 100,      
                'auto_increment' => true,
            ],
            'feed_id' => [
                'type'       => 'varchar',
                'constraint' => 300,      
                'null'       => false,
                'default'    => ''
            ],
            'entry_id' => [
                'type'       => 'varchar',
                'constraint' => 300,      
                'null'       => false,
            ],
            'p_cf' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'p_simbol' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'p_sword' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'p_stopword' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'p_stemming' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'p_tokenisasi' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'data_bersih' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'id_kategori' => [
                'type'       => 'int',
                'constraint' => 11,
                'null'       => true,
                'default'    => null
            ],
            'classify' => [
                'type'       => 'boolean',
                'default'    => false
            ],
        ]);

        $this->forge->addKey('no');
        $this->forge->addPrimaryKey('entry_id');
        $this->forge->addForeignKey('feed_id','galert_data','galert_id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_kategori','kategori','id','CASCADE','CASCADE');
        $this->forge->createTable('preprocessing');
    }

    public function down()
    {
        $this->forge->dropTable('preprocessing');
    }
}
