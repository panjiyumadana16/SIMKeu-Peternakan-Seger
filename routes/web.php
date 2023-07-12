<?php

use App\Http\Controllers\AgenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TempPesananController;
use App\Http\Controllers\TransaksiController;
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
    return redirect()->route('loginpage');
});

Route::get('login', [LoginController::class, 'index'])->name('loginpage');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {

    Route::group(['roles' => 'Admin', 'prefix' => 'admin'], function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

        Route::group(['prefix' => 'kandang'], function () {
            Route::get('', [KandangController::class, 'index'])->name('kandang');
            Route::get('data', [KandangController::class, 'indexData'])->name('kandang.data');
            Route::post('', [KandangController::class, 'addData'])->name('kandang.add');
            Route::get('{id}', [KandangController::class, 'detailData'])->name('kandang.detail');
            Route::put('{id}', [KandangController::class, 'updateData'])->name('kandang.update');
            Route::delete('{id}', [KandangController::class, 'deleteData'])->name('kandang.delete');
        });

        Route::group(['prefix' => 'stok'], function () {
            Route::get('', [StokController::class, 'index'])->name('stok');
            Route::get('data', [StokController::class, 'indexData'])->name('stok.data');
            Route::post('', [StokController::class, 'addData'])->name('stok.add');
            Route::get('{id}', [StokController::class, 'detailData'])->name('stok.detail');
            Route::put('{id}', [StokController::class, 'updateData'])->name('stok.update');
            Route::delete('{id}', [StokController::class, 'deleteData'])->name('stok.delete');
        });

        Route::group(['prefix' => 'kategori'], function () {
            Route::get('', [KategoriController::class, 'index'])->name('kategori');
            Route::get('data', [KategoriController::class, 'indexData'])->name('kategori.data');
            Route::post('', [KategoriController::class, 'addData'])->name('kategori.add');
            Route::get('{id}', [KategoriController::class, 'detailData'])->name('kategori.detail');
            Route::put('{id}', [KategoriController::class, 'updateData'])->name('kategori.update');
            Route::delete('{id}', [KategoriController::class, 'deleteData'])->name('kategori.delete');
        });

        Route::group(['prefix' => 'produk'], function () {
            Route::get('', [ProdukController::class, 'index'])->name('produk');
            Route::get('data', [ProdukController::class, 'indexData'])->name('produk.data');
            Route::post('', [ProdukController::class, 'addData'])->name('produk.add');
            Route::get('{id}', [ProdukController::class, 'detailData'])->name('produk.detail');
            Route::put('{id}', [ProdukController::class, 'updateData'])->name('produk.update');
            Route::delete('{id}', [ProdukController::class, 'deleteData'])->name('produk.delete');
        });

        Route::group(['prefix' => 'agen'], function () {
            Route::get('', [AgenController::class, 'index'])->name('agen');
            Route::get('data', [AgenController::class, 'indexData'])->name('agen.data');
            Route::post('', [AgenController::class, 'addData'])->name('agen.add');
            Route::get('{id}', [AgenController::class, 'detailData'])->name('agen.detail');
            Route::put('{id}', [AgenController::class, 'updateData'])->name('agen.update');
            Route::delete('{id}', [AgenController::class, 'deleteData'])->name('agen.delete');
        });

        Route::group(['prefix' => 'pesanan'], function () {
            Route::get('', [TransaksiController::class, 'index'])->name('pesanan');
            Route::get('data', [TransaksiController::class, 'indexData'])->name('pesanan.data');
            Route::get('{id}', [TransaksiController::class, 'detailData'])->name('pesanan.detail');
            Route::get('{id}/{to_status}', [TransaksiController::class, 'changeStatus'])->name('pesanan.status.change');
        });

        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('', [TransaksiController::class, 'indexPenjualan'])->name('penjualan');
            Route::get('data', [TransaksiController::class, 'indexDataPenjualan'])->name('penjualan.data');
            Route::get('{id}', [TransaksiController::class, 'detailData'])->name('penjualan.detail');
        });
    });
    Route::group(['roles' => 'Agen', 'prefix' => 'agen'], function () {
        Route::get('dashboard', [HomeController::class, 'listProduk'])->name('agen.dashboard');

        Route::group(['prefix' => 'keranjang'], function () {
            Route::get('', [TempPesananController::class, 'index'])->name('agen.keranjang');
            Route::post('', [TempPesananController::class, 'addKeranjang'])->name('agen.addKeranjang');
            Route::post('update/jumlah', [TempPesananController::class, 'updateJumlah'])->name('agen.keranjang.update');
            Route::delete('{id}', [TempPesananController::class, 'deleteData'])->name('agen.keranjang.delete');

            Route::get('gettotal', [TempPesananController::class, 'totalPesanan'])->name('agen.keranjang.gettotal');
        });

        Route::group(['prefix' => 'pesanan'], function () {
            Route::get('', [TransaksiController::class, 'indexAgen'])->name('agen.pesanan');
            Route::get('data', [TransaksiController::class, 'indexDataAgen'])->name('agen.pesanan.data');
            Route::post('', [TransaksiController::class, 'addData'])->name('agen.checkout.add');
            Route::get('{id}', [TransaksiController::class, 'detailData'])->name('agen.pesanan.detail');

            Route::get('bayar/{id}', [TransaksiController::class, 'bayarPesanan'])->name('agen.pesanan.bayar');
            Route::get('{id}/{to_status}', [TransaksiController::class, 'changeStatus'])->name('agen.pesanan.status.change');
        });

        Route::group(['prefix' => 'return'], function () {
            Route::get('{id}', [ReturnController::class, 'insert'])->name('agen.return.form');
            Route::post('', [ReturnController::class, 'create'])->name('agen.return.create');
            Route::get('', [ReturnController::class, 'indexAgen'])->name('agen.return');
            Route::get('data/agen', [ReturnController::class, 'indexDataAgen'])->name('agen.return.data');
        });
    });
});
