<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'General\WelcomeController::index');

$routes->get('logout', 'Registro::logout');

// Rutas de logueo
$routes->group('login', function($routes){
    $routes->get('/', 'Log\Login::showLogin');
    $routes->post('/', 'Log\Login::login', ['as' => 'login.login']);
    $routes->get('out', 'Log\Login::logout', ['as' => 'login.logout']);
    $routes->get('show', 'Log\Login::show', ['as' => 'login.show']);
    $routes->get('perm', 'Log\Login::showSessionData');
});

// Rutas protegidas por BearerToken
$routes->group('auth', function($routes){
    $routes->group('log', ['filter' => 'verificarPermiso:dash_logs'], function($routes){
        $routes->get('test', 'Test::index', ['as' => 'log.test.index']);
        $routes->get('show', 'Log\Login::show', ['as' => 'log.auth.show']);
    });
    $routes->get('test', 'Test::index', ['as' => 'test.index']);
    $routes->get('show', 'Log\Login::show', ['as' => 'auth.show']);
});




