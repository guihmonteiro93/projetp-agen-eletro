<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Não estamos usando exclusão suave
    protected $protectFields    = true;

    // Campos permitidos para inserção e atualização: login e password
    protected $allowedFields = ['login', 'password'];

    // Dates (Timestamps)
    // Definimos como true para que o CI gerencie created_at e updated_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Mesmo que useSoftDeletes seja false, mantemos a definição

    // Callbacks: Garante que a senha seja hasheada antes de salvar ou atualizar
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Funções de Callback

    /**
     * Função Callback para criar o hash da senha antes de salvar no banco.
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            // Usa password_hash do PHP para criptografar a senha, fundamental para a segurança.
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
