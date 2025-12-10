<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// --------------------------------------------------------------------
// ROTAS DE AUTENTICAÇÃO (LIVRES)
// --------------------------------------------------------------------

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');

$routes->get('logout', 'Auth::logout');

// --------------------------------------------------------------------
// ROTAS PROTEGIDAS DA AGENDA
// --------------------------------------------------------------------
$routes->group('events', ['filter' => 'auth'], static function ($routes) {

    // 1. Rota para o JSON do FullCalendar
    $routes->get('json', 'Events::getEventsJson');

    // 2. Rotas CRUD EXPLÍCITAS (Focadas nas que dão problema e suas dependências)

    // Rota GET para o formulário de criação (GET /events/new)
    $routes->get('new', 'Events::new', ['as' => 'events_new']);

    // Rota POST para salvar (POST /events)
    $routes->post('/', 'Events::create');

    // Rota GET para a listagem (GET /events)
    $routes->get('/', 'Events::index', ['as' => 'events_index']);

    // As rotas que usam o ID (show, edit, delete, update)
    $routes->get('(:num)', 'Events::show/$1', ['as' => 'events_show']);
    $routes->get('(:num)/edit', 'Events::edit/$1', ['as' => 'events_edit']);
    $routes->put('(:num)', 'Events::update/$1');
    $routes->delete('(:num)', 'Events::delete/$1');
});
// --------------------------------------------------------------------
// FIM: ROTAS PROTEGIDAS
// --------------------------------------------------------------------