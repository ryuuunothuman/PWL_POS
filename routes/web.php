<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);

// Route::get('/user', [UserController::class, 'index']);




// Route::get('/hehe', function(){
//     return 'test';
// });

// Route::get('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan'])->name('user.tambah.simpan');
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah'])->name('user.ubah');
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan'])->name('user.ubah.simpan');
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');


// Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
// Route::get('/level/create', [LevelController::class, 'create'])->name('level.create');

// Route::post('/user', [UserController::class, 'store']);
// Route::post('/level', [LevelController::class, 'store']);

// Route::resource('m_user', POSController::class);



// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
// Route::post('/kategori', [KategoriController::class, 'store']);
// Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
// Route::put('/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
// Route::get('/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');

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