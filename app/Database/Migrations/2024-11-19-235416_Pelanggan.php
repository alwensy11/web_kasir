<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pelanggan'      => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'nama_pelanggan'  => [
                'type' => 'VARCHAR', 
                'constraint' => 255
            ],
            'alamat'        => [
                'type' => 'VARCHAR', 
                'constraint' => 255
            ],
            'nomer_telepon'   => [
                'type' => 'INT',
                'constraint' => 35,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ]
        ]);

        $this->forge->addKey('id_pelanggan', true);
        $this->forge->createTable('tb_pelanggan');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pelanggan');
    }
}
