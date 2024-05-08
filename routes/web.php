<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangResourceController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriResourceController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LevelResourceController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\StokResourceController;
use App\Http\Controllers\TransaksiPenjualanResourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::resource('level', LevelResourceController::class);
Route::post('level/list', [LevelResourceController::class, 'list']);

/**
 * Route for Resource in kategori table: create, store, show, edit, update, and destroy, also with list that return JsonResponse
 */
Route::resource('kategori', KategoriResourceController::class);
Route::post('kategori/list', [KategoriResourceController::class, 'list']);

/**
 * Route for Resource in Barang table: create, store, show, edit, update, and destroy, also with list that return JsonResponse
 */
Route::resource('barang', BarangResourceController::class);
Route::post('barang/list', [BarangResourceController::class, 'list']);

/**
 * Route for Resource in stok table: create, store, show, edit, update, and destroy, also with list that return JsonResponse
 */
Route::resource('stok', StokResourceController::class);
Route::post('stok/list', [StokResourceController::class, 'list']);


/**
 * Route for Resource Transaksi Penjualan (t_penjualan and t_penjualan_detail table): create, store, show, edit, update, and destroy, also with list that return JsonResponse
 */
Route::resource('penjualan', TransaksiPenjualanResourceController::class);
Route::post('penjualan/list', [TransaksiPenjualanResourceController::class, 'list']);

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['cek_login:1']], function() {
        Route::resource('admin', AdminController::class);
    });

    Route::group(['middleware' => ['cek_login:2']], function() {
        Route::resource('manager', ManagerController::class);
    });
});