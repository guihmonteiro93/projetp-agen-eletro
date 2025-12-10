<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'login' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true, // Garante que o login não se repita
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', // Suficiente para armazenar o hash da senha
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Define 'id' como chave primária
        $this->forge->createTable('users'); // Cria a tabela 'users'
    }

    public function down()
    {
        $this->forge->dropTable('users'); // Comando para reverter a migration
    }
}
