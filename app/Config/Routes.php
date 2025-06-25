<?php

use App\Controllers\Anggota;
use App\Controllers\Peminjaman;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  Utama
$routes->get('/', 'Home::index');
$routes->get('buku', 'Home::buku');
$routes->get('profil', 'Home::profil');
$routes->post('/pinjam', 'Home::pinjamBuku');
$routes->post('/kembali', 'Home::kembalikanBuku');
$routes->post('/profil/updateFoto', 'Home::updateFotoProfil');

// Admin
$routes->get('/dashboard', 'Admin::index');

// Buku
$routes->get('buku-buku', 'Buku::index');
$routes->get('buku-buku/detail/(:segment)', 'Buku::detail/$1');
$routes->get('buku-buku/edit/(:segment)', 'Buku::edit/$1');
$routes->post('buku-buku/save', 'Buku::save');
$routes->get('buku-buku/create', 'Buku::create');
$routes->post('buku-buku/update', 'Buku::update');
$routes->delete('buku-buku/delete/(:num)', 'Buku::delete/$1');

// Anggota
$routes->get('/anggota', 'Anggota::index');
$routes->post('anggota/save', 'Anggota::save');
$routes->get('anggota/create', 'Anggota::create');
$routes->post('anggota/update', 'Anggota::update');
$routes->delete('anggota/delete/(:num)', 'Anggota::delete/$1');

// Peminjaman
$routes->get('/peminjaman', 'Peminjaman::index');
$routes->delete('/peminjaman/delete/(:num)', 'Peminjaman::delete/$1');
$routes->post('/peminjaman/update', 'Peminjaman::update');

// Login
$routes->get('login', 'Login::index');
$routes->post('/login/cek', 'Login::cek');
$routes->get('/logout', 'Login::logout');
$routes->get('masuk', 'Login::masuk');
$routes->get('daftar', 'Login::daftar');
$routes->post('/daftar', 'Login::prosesDaftar');
