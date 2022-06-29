<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('GalertEntry');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('preprocessing/dirtyentry', 'Preprocessing::getDirtyEntries');
$routes->get('labelisasi/nullkategori',  'Labelisasi::getNullKategori');

$routes->group("klasifikasi", function ($routes) {
    $routes->get('/',                     'Klasifikasi::index');
    $routes->get('probabilitas_kategori', 'Klasifikasi::getCategoriesProb');
    $routes->get('count_dataprob',        'Klasifikasi::countDataProb');
    $routes->get('get_dataprob',          'Klasifikasi::getDataProb');
});

$routes->group("classify", function ($routes) {
    $routes->get('/',        'Classify::index');
    $routes->get('akurasi',  'Classify::getAkurasi');
    $routes->get('kategori', 'Classify::getKategori');
    $routes->post('predict', 'Classify::create');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
