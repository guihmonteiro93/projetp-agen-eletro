<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Função executada ANTES da rota ser acessada.
     * Verifica se o usuário está logado. Se não estiver, redireciona para a tela de login.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Se a variável de sessão 'isLoggedIn' for falsa (usuário não logado)...
        if (! session()->get('isLoggedIn')) {
            // ...redireciona para a página de login
            return redirect()->to(url_to('login'))
                ->with('info', 'Você precisa estar logado para acessar esta área.');
        }
    }

    /**
     * Função executada DEPOIS da rota ser acessada.
     * Não é necessário implementar lógica aqui para um filtro de autenticação simples.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer
    }
}
