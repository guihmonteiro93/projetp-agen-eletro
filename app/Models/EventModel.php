<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    // Define o nome da tabela no banco de dados
    protected $table = 'events';

    // Define a chave primária da tabela
    protected $primaryKey = 'id';

    // Define que o campo id é auto-incremento
    protected $useAutoIncrement = true;

    // Define o tipo de retorno padrão
    protected $returnType = 'array';

    // Desabilitamos o Soft Deletes
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        // Manter o construtor customizado para evitar problemas de conexão
        $this->db = \Config\Database::connect();
    }

    // Campos que podem ser manipulados (inseridos/atualizados)
    protected $allowedFields = [
        'user_id',    // Chave estrangeira (relacionamento)
        'title',      // Campo do formulário (que renomeamos para 'name' no Controller)
        'description',
        'start_time',
        'end_time',
        'status'      // <--- CORRIGIDO: Necessário para salvar o status padrão
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // ... (O restante das propriedades de validação e callbacks) ...

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
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
