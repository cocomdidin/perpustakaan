<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::middleware('auth')->group(function(){

    Route::middleware('privilege:admin')->group(function () {
        Route::resource('/anggota','AnggotaController');
        Route::get('/anggota-search','AnggotaController@search')->name('anggota.search');
    });

    Route::middleware('privilege:petugas')->group(function () {
        Route::resource('/petugas','PetugasController');

        Route::get('/kunjungan','KunjunganController@index')->name('kunjungan.index');
        Route::post('/kunjungan','KunjunganController@store')->name('kunjungan.store');
        Route::get('/kunjungan-search-anggota','KunjunganController@searchAnggota')->name('kunjungan.search.anggota');

        Route::get('/transaksi/{id}/kembali','TransaksiController@kembali')->name('transaksi.kembali');
        Route::put('/transaksi/{id}/kembalikan','TransaksiController@kembalikan')->name('transaksi.kembalikan');
        Route::resource('/transaksi','TransaksiController');
        Route::get('/transaksi-search','TransaksiController@search')->name('transaksi.search');

        Route::resource('/riwayat','HistoryController');
        Route::get('/all','HistoryController@showAll')->name('riwayat.all');

        Route::get('/laporan','LaporanController@index')->name('laporan.index');
        Route::get('/buku-pdf','LaporanController@bukuPdf')->name('buku.pdf');
        Route::get('/buku-excel','LaporanController@bukuExcel')->name('buku.excel');
        Route::get('/transaksi-pdf','LaporanController@transaksiPdf')->name('transaksi.pdf');
        Route::get('/transaksi-excel','LaporanController@transaksiExcel')->name('transaksi.excel');
    });

    Route::middleware('privilege:anggota')->group(function () {
        Route::resource('/buku','BukuController');
        Route::get('/buku-search','BukuController@search')->name('buku.search');
    });
});
