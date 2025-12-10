<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel; // Importa o UserModel que criamos

class Auth extends BaseController
{
    protected $userModel;

    // Inicializa o Model no construtor
    public function __construct()
    {
        // Instancia o modelo de usuário para interagir com a tabela 'users'
        $this->userModel = new UserModel();
    }

    // ----------------------
    // 1. Cadastro de Usuário (Tela e Processamento)
    // ----------------------

    /**
     * Exibe o formulário de cadastro. Mapeado para GET /register
     */
    public function register()
    {
        // Se o usuário já estiver logado, redireciona
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/events');
        }

        return view('auth/register');
    }

    /**
     * Processa a submissão do formulário de cadastro. Mapeado para POST /register
     */
    public function attemptRegister()
    {
        // Regras de validação (Garantindo que o login é único e senhas conferem)
        if (!$this->validate([
            'login' => 'required|min_length[3]|is_unique[users.login]',
            'password' => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]',
        ], [
            'login' => [
                'is_unique' => 'Este nome de usuário já está em uso.',
            ],
            'pass_confirm' => [
                'matches' => 'A confirmação de senha não confere.',
            ],
        ])) {
            // Se a validação falhar, retorna ao formulário com erros
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Dados para inserção (o UserModel irá hashear a senha automaticamente)
        $data = [
            'login' => $this->request->getPost('login'),
            'password' => $this->request->getPost('password'),
        ];

        if ($this->userModel->insert($data)) {
            // Sucesso no cadastro
            return redirect()->to('/login')->with('success', 'Cadastro realizado com sucesso! Faça login.');
        } else {
            return redirect()->back()->with('error', 'Erro ao processar o cadastro.');
        }
    }

    // ----------------------
    // 2. Login de Usuário (Tela e Processamento)
    // ----------------------

    /**
     * Exibe o formulário de login. Mapeado para GET /login
     */
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/events');
        }
        return view('auth/login');
    }

    /**
     * Processa a submissão do formulário de login. Mapeado para POST /login
     */
    public function attemptLogin()
    {
        // Regras de validação simples
        if (!$this->validate(['login' => 'required', 'password' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // Busca o usuário no banco
        $user = $this->userModel->where('login', $login)->first();

        // Verifica se o usuário existe E se a senha confere (password_verify)
        if (!$user || !password_verify($password, $user['password'])) {
            // Usuário ou senha incorretos
            return redirect()->back()->withInput()->with('error', 'Login ou senha incorretos.');
        }

        // LOGIN BEM-SUCEDIDO: Cria a sessão e loga o usuário
        $this->setUserSession($user);

        return redirect()->to('/events')->with('success', 'Login realizado com sucesso!');
    }

    /**
     * Cria a sessão de usuário.
     */
    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'login' => $user['login'],
            'isLoggedIn' => true, // Flag principal para o AuthFilter
        ];
        session()->set($data);
    }

    // ----------------------
    // 3. Logout
    // ----------------------

    /**
     * Destrói a sessão e faz o logout. Mapeado para GET /logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('info', 'Você saiu da sua conta.');
    }
}
