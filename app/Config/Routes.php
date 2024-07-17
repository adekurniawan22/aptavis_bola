<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Football::index');
$routes->get('/input-klub', 'Football::createKlub');
$routes->post('/input-klub', 'Football::storeKLub');
$routes->get('/input-skor', 'Football::createPertandingan');
$routes->post('/input-skor', 'Football::storePertandingan');
$routes->get('/klasemen', 'Football::viewKlasemen');
