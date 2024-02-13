<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('pengaduan', 'Api\PengaduanController@index'); //isi api ambil data keterangan
    Route::get('pengaduan/{id}', 'Api\PengaduanController@show');
    Route::post('pengaduan', 'Api\PengaduanController@store');

    Route::post('pengaduan/verifikasi/{id}', 'Api\PengaduanController@updateVerifikasi');
    Route::post('pengaduan/{id}', 'Api\PengaduanController@updatePengaduan');

    Route::delete('pengaduan/{id}', 'Api\PengaduanController@destroy');

    //Route::post('updatestatus/{id}', 'Api\PengaduanController@updateStatus');

    Route::get('jenisaduan', 'Api\MasterController@readJenisAduan');
    
    Route::post('jenisaduan', 'Api\JenisAduanController@store');

    Route::get('kecamatan', 'Api\MasterController@readKecamatan');

    Route::post('kecamatan', 'Api\KecamatanController@store');
    //Route::get('kecamatan', 'Api\MasterController@store');

    // Route::get('verifikasi', 'Api\VerifikasiController@index');
    // Route::get('verifikasi/{id}', 'Api\VerifikasiController@show');
    // Route::post('verifikasi', 'Api\VerifikasiController@store');
    // Route::post('verifikasi/{id}', 'Api\VerifikasiController@update');
    // Route::delete('verifikasi/{id}', 'Api\VerifikasiController@destroy');

    Route::get('laporanharian/{date1},{date2}', 'Api\PengaduanController@laporanHarian');
    Route::get('laporanbulanan/{month},{year}', 'Api\PengaduanController@laporanBulanan');

    Route::post('logout', 'Api\AuthController@logout');
});
