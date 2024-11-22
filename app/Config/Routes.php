<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'PlaceController::index'); // Route utama untuk halaman
$routes->get('place/loadHeader', 'PlaceController::loadHeader'); // Route untuk memuat header
$routes->get('place/loadFirstContent', 'PlaceController::loadFirstContent'); // Route untuk memuat konten awal
$routes->get('place/loadFooter', 'PlaceController::loadFooter'); // Route untuk memuat footer
$routes->get('place/loadSection', 'PlaceController::loadSection'); // Route untuk memuat konten tambahan (section lain)

