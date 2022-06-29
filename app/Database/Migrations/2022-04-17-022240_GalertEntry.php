<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GalertEntry extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'entry_id' => [
                'type'       => 'varchar',
                'constraint' => 300,      
                'null'       => false,
            ],
            'entry_title' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'entry_link' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'entry_published' => [
                'type'       => 'tinytext',
                'null'       => true,
                'default'    => null
            ],
            'entry_updated' => [
                'type'       => 'tinytext',
                'null'       => true,
                'default'    => null
            ],
            'entry_content' => [
                'type'       => 'text',
                'null'       => true,
                'default'    => null
            ],
            'entry_author' => [
                'type'       => 'tinytext',
                'null'       => true,
                'default'    => null
            ],
            'feed_id' => [
                'type'       => 'varchar',
                'constraint' => 300,      
                'null'       => false,
                'default'    => ''
            ],
            'clean' => [
                'type'       => 'boolean',
                'default'    => false
            ],
        ]);

        $this->forge->addPrimaryKey('entry_id');
        $this->forge->addForeignKey('feed_id','galert_data','galert_id','CASCADE','CASCADE');
        $this->forge->createTable('galert_entry');
    }

    public function down()
    {
        $this->forge->dropTable('galert_entry');
    }
}
