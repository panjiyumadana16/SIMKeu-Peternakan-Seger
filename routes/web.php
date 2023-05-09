<?php

use App\Http\Controllers\AgenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\ProdukController;
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
    });
});
