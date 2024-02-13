<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::post('register', 'Api\AuthController@register');
// Route::post('login', 'Api\AuthController@login');


// Route::get('pengaduan', 'PengaduanController@index');
// Route::get('pengaduan/{id}', 'PengaduanController@show');
// Route::post('pengaduan', 'PengaduanController@store');
// Route::post('pengaduan/{id}', 'PengaduanController@update');
// Route::delete('pengaduan/{id}', 'PengaduanController@destroy');

// Route::get('verifikasi', 'Api\VerifikasiController@index');
// Route::get('verifikasi/{id}', 'Api\VerifikasiController@show');
// Route::post('verifikasi', 'Api\VerifikasiController@store');
// Route::post('verifikasi/{id}', 'Api\VerifikasiController@update');
// Route::delete('verifikasi/{id}', 'Api\VerifikasiController@destroy');

// Route::post('logout', 'Api\AuthController@logout');
