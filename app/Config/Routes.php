<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// --------------------------------------------------------------------
// ROTAS PARA A AGENDA (EVENTS)
// --------------------------------------------------------------------

// Define todas as rotas CRUD (RESTful) para o controlador Events.
// Isso gera automaticamente:
// GET /events (Lista de eventos -> Events::index)
// GET /events/new (Formulário de criação -> Events::new)
// POST /events (Salvar novo evento -> Events::create)
// GET /events/(:num) (Detalhes do evento -> Events::show)
// GET /events/(:num)/edit (Formulário de edição -> Events::edit)
// POST/PUT /events/(:num) (Atualizar evento -> Events::update)
// DELETE /events/(:num) (Excluir evento -> Events::delete)
$routes->resource('events', ['controller' => 'Events']);