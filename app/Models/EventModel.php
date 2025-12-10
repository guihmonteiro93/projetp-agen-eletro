<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    // Define o nome da tabela no banco de dados
    protected $table = 'events';

    // Define a chave primária da tabela
    protected $primaryKey = 'id';

    // Define que o campo id é auto-incremento (já configurado na migration)
    protected $useAutoIncrement = true;

    // Define o tipo de retorno padrão para métodos find (array é o padrão)
    protected $returnType = 'array';

    // Desabilitamos o Soft Deletes pois não criamos a coluna deleted_at na migration
    protected $useSoftDeletes = false;

    // Campos que podem ser manipulados (inseridos/atualizados)
    // Corresponde às colunas da sua tabela 'events', exceto 'id' e timestamps
    protected $allowedFields = [
        'title',
        'description',
        'start_time',
        'end_time',
    ];

    // Dates
    // Ativa os timestamps, pois a tabela possui as colunas created_at e updated_at
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at'; // Mantemos, mas useSoftDeletes é false

    // Validation (Você pode adicionar regras de validação aqui mais tarde)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Outras configurações (mantidas como padrão ou desabilitadas)
    protected $protectFields = true;
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected array $casts = [];
    protected array $castHandlers = [];
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
