<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SlangWord extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'int',
                'constraint' => 11,      
                'auto_increment' => true,
            ],
            'kata_baku' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
                'default'    => null
            ],
            'kata_nonbaku' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
                'default'    => null
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('slang_word');
    }

    public function down()
    {
        $this->forge->dropTable('slang_word');
    }
}
