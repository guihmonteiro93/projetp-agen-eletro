<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
    public function up()
    {
        // Define os campos da tabela 'events'
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'title'          => ['type' => 'VARCHAR', 'constraint' => '255'],
            'description'    => ['type' => 'TEXT', 'null' => true],
            'start_time'     => ['type' => 'DATETIME'], // Data e hora de início do evento
            'end_time'       => ['type' => 'DATETIME'],   // Data e hora de fim do evento
            // Campos de Timestamps nativos do CI4 (created_at e updated_at)
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Define a chave primária
        $this->forge->addKey('id', true);

        // Cria a tabela
        $this->forge->createTable('events');
    }

    public function down()
    {
        // Exclui a tabela se a migration for revertida
        $this->forge->dropTable('events');
    }
}
