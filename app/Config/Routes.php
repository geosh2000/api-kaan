<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Registro::index');
$routes->get('logout', 'Registro::logout');

$routes->group('third', function($routes){
    $routes->get('industrias', 'Third\Industrias::index');
});

$routes->group('reports', function($routes){
    $routes->get('uk', 'Reports\Promos::promoUk');
    $routes->post('uk', 'Reports\Promos::promoUk');
});

// DBTest
$routes->group('db', function($routes){
    $routes->get('test', 'Dbtest::index');
    $routes->get('wh/(:any)', 'Warehouse\Reservations::show/$1');
    $routes->get('rsv/(:any)', 'Zd\Tickets::getReservation/$1');
});

// CallitOnce
$routes->group('cio', function($routes){
    $routes->get('llamadas', 'Cio\UploadCalls::mostrarFormulario');
    $routes->post('llamadas/cargar', 'Cio\UploadCalls::cargarCSV');
    $routes->get('load', 'Cio\UploadCalls::loadCSV');
    
    $routes->group('query', function($routes){
        $routes->get('todayCalls', 'Cio\QueryCalls::llamadasDia');
    });
    
    $routes->group('dashboard', function($routes){
        $routes->get('', 'Cio\QueryCalls::test');
        $routes->get('disposicion', 'Cio\QueryCalls::types');
        $routes->get('disposicion/(:any)', 'Cio\QueryCalls::types/$1');
        $routes->get('disposicion/(:any)/(:any)', 'Cio\QueryCalls::types/$1/$2');
        $routes->get('disposicion/(:any)/(:any)/(:any)', 'Cio\QueryCalls::types/$1/$2/$3');
        $routes->get('queues', 'Cio\QueryCalls::queues');
        $routes->get('langs', 'Cio\QueryCalls::langs');
        $routes->get('hotels', 'Cio\QueryCalls::hotels');
        $routes->get('callJourney', 'Cio\QueryCalls::callJourney');
        $routes->get('calls', 'Cio\QueryCalls::calls');
        $routes->get('calls/(:any)', 'Cio\QueryCalls::calls/$1/');
        $routes->get('calls/(:any)/(:any)/(:any)', 'Cio\QueryCalls::calls/$1/$2/$3');
    });
});

$routes->group('public', function($routes){
    $routes->post('addTransfer', 'Transpo\TransportacionController::storeForm');
    $routes->get('transfer-reg', 'Transpo\TransportacionController::showForm');
    $routes->get('invalid_form', 'Transpo\TransportacionController::invalid');
});

// Transportacion
$routes->group('transpo', ['filter' => 'authFilter'], function($routes){
    $routes->get('/', 'Transpo\TransportacionController::index');
    $routes->get('create', 'Transpo\TransportacionController::create');
    $routes->post('store', 'Transpo\TransportacionController::store');
    $routes->get('edit/(:num)', 'Transpo\TransportacionController::edit/$1');
    $routes->get('editStatus/(:num)/(:any)', 'Transpo\TransportacionController::editStatus/$1/$2');
    $routes->get('confirmDelete/(:num)', 'Transpo\TransportacionController::confirmDelete/$1');
    $routes->post('update/(:num)', 'Transpo\TransportacionController::update/$1');
    $routes->delete('delete/(:num)', 'Transpo\TransportacionController::delete/$1');
    $routes->get('db/get', 'Transpo\DatabaseController::getIncluded/3');
    $routes->get('db/get/(:num)', 'Transpo\DatabaseController::getIncluded/$1');
    $routes->get('history/(:num)', 'Transpo\TransportacionController::getHistory/$1');
});

// Zendesk
$routes->group('zd', function($routes){
    $routes->group('mailing', function($routes){
        $routes->get('conf', 'Zd\Mailing::index');
        $routes->get('confHtml', 'Zd\Mailing::getConf');
    });
    $routes->group('object', function($routes){
        $routes->get('show', 'Zd\Objects::index');
    });
    $routes->group('user', function($routes){
        $routes->get('get/(:any)', 'Zd\Users::showUser/$1');
    });
    $routes->group('ticket', function($routes){
        $routes->get('show', 'Zd\Tickets::index');
        $routes->get('show/(:any)', 'Zd\Tickets::index/$1');
        $routes->get('adhForm/(:any)', 'Zd\Tickets::adhFormToClient/$1');
        $routes->get('audits/(:any)', 'Zd\Tickets::audits/$1');
        $routes->get('fields', 'Zd\Tickets::showFields');
        $routes->delete('closeTicket/(:any)', 'Zd\Tickets::closeTicket/$1');
    });
    $routes->post('webhook', 'Zd\Tickets::webhook');
});

$routes->group('view', function($routes){
    $routes->group('reports', function($routes){
        $routes->get('uk', 'Reports\Promos::promoUk/true');
        $routes->post('uk', 'Reports\Promos::promoUk/true');
    });
});


// Upload CSV
$routes->group('rsv', function($routes){
    $routes->get('search', 'Rsv\Manager::index');
    $routes->post('search', 'Rsv\Manager::search');
    $routes->post('quote', 'Rsv\Quote::index');
    $routes->get('discountcodes', 'Rsv\DiscountCodes::index');
    $routes->get('dbtest', 'Dbtest::index');
    $routes->get('viewConf', 'Dbtest::conf');

});

// Upload CSV
$routes->group('csv', function($routes){
    $routes->get('upload', 'CsvUpload::upload');
    $routes->post('upload', 'CsvUpload::upload');
});

// Rutas de logueo
$routes->group('login', function($routes){
    $routes->get('/', 'Log\Login::showLogin');
    $routes->post('/', 'Log\Login::login', ['as' => 'login.login']);
    $routes->get('out', 'Log\Login::logout', ['as' => 'login.logout']);
    $routes->get('show', 'Log\Login::show', ['as' => 'login.show']);
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

// Rutas sin proteccion por BearerToken
$routes->group('test', function($routes){
    $routes->post('db', 'Test::dbs', ['as' => 'test.test.dbs']);
    $routes->get('test', 'Test::index', ['as' => 'test.test.index']);
    $routes->get('jwt', 'Test::jwt', ['as' => 'test.test.jwt']);
    $routes->get('show', 'Log\Login::show', ['as' => 'test.auth.show']);
});

// $routes->group('dashboard', ['filter' => 'DashboardFilter'], function($routes){
//     $routes->get('usuario/crear', '\App\Controllers\Web\Usuario::create_user', ['as' => 'usuario.create_user']);
//     $routes->get('usuario/test_password/(:num)', '\App\Controllers\Web\Usuario::test_password/$1', ['as' => 'usuario.test_pw']);
//     $routes->get('peliculas', 'Pelicula::index', ['as' => 'pelicula.index']);
// });
