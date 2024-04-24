<?php

use App\Http\Controllers\BarangResourceController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriResourceController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LevelResourceController;
use App\Http\Controllers\POSController;
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

Route::resource('kategori', KategoriResourceController::class);
Route::post('kategori/list', [KategoriResourceController::class, 'list']);

/**
 * Route for Resource in Level table: create, store, show, edit, update, and destroy, also with list that return JsonResponse
 */
Route::resource('barang', BarangResourceController::class);
Route::post('barang/list', [BarangResourceController::class, 'list']);