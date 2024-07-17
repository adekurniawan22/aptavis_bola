<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFootballTables extends Migration
{
    public function up()
    {
        // Tabel klub
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama_klub' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'asal_klub' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('klub');

        // Tabel pertandingan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'klub_home' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'klub_away' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'skor_home' => [
                'type' => 'INT',
            ],
            'skor_away' => [
                'type' => 'INT',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('klub_home', 'klub', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('klub_away', 'klub', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertandingan');
    }

    public function down()
    {
        $this->forge->dropTable('pertandingan');
        $this->forge->dropTable('klub');
    }
}
