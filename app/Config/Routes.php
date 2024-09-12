<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'General\WelcomeController::index');

// $routes->group('zd|app', function($routes){
$routes->group('zdapp', ['filter' => 'zendeskFilter'], function($routes){
    // $routes->post('/', 'Zdapp\ZendeskAppController::index');
    $routes->post('/', 'Zdapp\ZendeskAppController::index');
    
    $routes->group('conf', function($routes){
        $routes->post('/', 'Zdapp\ZendeskAppController::confirms');
    });
    $routes->group('transpo', function($routes){
        $routes->post('/', 'Zdapp\ZendeskAppController::transpo');
    });
    $routes->group('quote', function($routes){
        $routes->post('/', 'Zdapp\ZendeskAppController::quote');
    });
});


$routes->group('zdappC', function($routes){
    $routes->group('transpo',  function($routes){
        $routes->get('/', 'Zdapp\ZendeskAppController::transpo');
        $routes->post('/', 'Cio\QueryCalls::calls');
        $routes->get('searchFolios/(:any)', 'Transpo\TransportacionController::search/$1');
        $routes->get('searchFolio/(:any)', 'Transpo\TransportacionController::findByFolio/$1');
        $routes->get('searchIds/(:num)/(:num)', 'Transpo\TransportacionController::findById/$1/$2');
        $routes->post('requestTemplate', 'Transpo\TransportacionController::mailRequest');
        $routes->post('requestLink', 'Transpo\TransportacionController::linkRequest');
        $routes->post('conf', 'Transpo\TransportacionController::confirmTranspoMail');

        $routes->get('create', 'Transpo\TransportacionController::create');
        $routes->post('store', 'Transpo\TransportacionController::store');
        $routes->post('removeTicket/(:num)/(:num)', 'Transpo\TransportacionController::removeTicket/$1/$2');
        $routes->post('setPayment', 'Transpo\TransportacionController::setPaymentTicket');
        $routes->get('edit/(:num)', 'Transpo\TransportacionController::edit/$1');
        $routes->get('editStatus/(:num)/(:any)', 'Transpo\TransportacionController::editStatus/$1/$2');
        $routes->get('confirmDelete/(:num)', 'Transpo\TransportacionController::confirmDelete/$1');
        $routes->post('update/(:num)', 'Transpo\TransportacionController::update/$1');
        $routes->delete('delete/(:num)', 'Transpo\TransportacionController::delete/$1');
        $routes->get('db/get', 'Transpo\DatabaseController::getIncluded/3');
        $routes->get('db/get/(:num)', 'Transpo\DatabaseController::getIncluded/$1');
        $routes->get('history/(:num)', 'Transpo\TransportacionController::getHistory/$1');
        
        // DBController
        $routes->get('getRsv/(:any)', 'Transpo\DatabaseController::getRsva/$1');
        // $routes->get('getRsvHtml/(:any)', 'Transpo\DatabaseController::getRsva/$1/1'); // $2 es boolean para vista html
        $routes->get('getRsvHtml/(:any)', 'Transpo\DatabaseController::getRsva/$1/today/1'); // $2 es boolean para vista html
        
        // CREATE NEW ROUND TRIP
        $routes->post('saveNewRound', 'Transpo\TransportacionController::storeRound'); 
        
    });

});

// Zendesk
$routes->group('zd', function($routes){
    $routes->group('mailing', function($routes){
        $routes->get('conf', 'Zd\Mailing::index');
        $routes->get('confHtml', 'Zd\Mailing::getConf');
        $routes->post('confPreview', 'Zd\Tickets::previewConf');
        $routes->get('confPdf', 'Zd\Mailing::pdfConf2');
    });
    $routes->group('object', function($routes){
        $routes->get('show', 'Zd\Objects::index');
    });
    $routes->group('user', function($routes){
        $routes->get('get/(:any)', 'Zd\Users::showUser/$1');
    });
    $routes->group('whats', function($routes){
        $routes->get('slaJob', 'Zd\Tickets::whatsVipSlaJob');
        $routes->get('listConv/(:any)', 'Zd\Tickets::whatsConv/$1');
        $routes->post('send/(:any)', 'Zd\Tickets::sendMsgToConv/$1');
        $routes->get('listConvs/(:any)', 'Zd\Whatsapp::listConversations/$1');
        $routes->get('getConversation/(:any)', 'Zd\Whatsapp::getConversation/$1');
        $routes->post('notify', 'Zd\Whatsapp::sendNotification');
        $routes->post('test', 'Zd\Whatsapp::test');
    });
    $routes->group('ticket', function($routes){
        $routes->get('search/(:any)', 'Zd\Tickets::searchQuery/$1');
        $routes->get('show', 'Zd\Tickets::index');
        $routes->get('show/(:any)', 'Zd\Tickets::index/$1');
        $routes->get('metrics/(:any)', 'Zd\Tickets::metrics/$1');
        $routes->get('adhForm/(:any)', 'Zd\Tickets::adhFormToClient/$1');
        $routes->get('audits/(:any)', 'Zd\Tickets::audits/$1');
        $routes->get('fields', 'Zd\Tickets::showFields');
        $routes->delete('closeTicket/(:any)', 'Zd\Tickets::closeTicket/$1');
    });
    $routes->post('webhook', 'Zd\Tickets::webhook');
    $routes->group('apps', function($routes){
        $routes->post('key', 'Zd\Tickets::getPublicKey');
        $routes->post('installations', 'Zd\Tickets::installations');
        $routes->post('aud', 'Zd\Tickets::appAud');
    });
    $routes->group('config', function($routes){
        $routes->get('showForm/(:num)', 'Zd\Tickets::showForm/$1');
    });
    $routes->group('forms', function($routes){
        $routes->post('post-msg', 'Zd\Tickets::fromContactForm');
    });
});

