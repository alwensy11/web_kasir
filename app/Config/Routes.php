<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Tabel Produk
$routes->get('/produk', 'Produk::index');
$routes->post('/produk/simpan', 'Produk::simpan_produk');
$routes->get('/produk/tampil', 'Produk::tampil_produk');
$routes->get('/produk/tampil/(:num)', 'Produk::tampil_by_id/$1');  // Route for fetching product by ID
$routes->post('/produk/update', 'Produk::update');  // Route for updating product
$routes->delete('/produk/hapus/(:num)', 'Produk::hapus_produk/$1');

// Tabel Pelanggan
$routes->get('/pelanggan', 'Pelanggan::index');
$routes->post('/pelanggan/simpan', 'Pelanggan::simpan_pelanggan');
$routes->get('/pelanggan/tampil', 'Pelanggan::tampil_pelanggan');
$routes->get('/pelanggan/tampil/(:num)', 'Pelanggan::tampil_by_id/$1');  // Route for fetching product by ID
$routes->post('/pelanggan/update', 'Pelanggan::update_pelanggan');  // Route for updating product
$routes->post('/pelanggan/hapus/(:num)', 'Pelanggan::hapus_pelanggan/$1');