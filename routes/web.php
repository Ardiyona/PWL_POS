<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('signup', [RegistrationController::class, 'registration'])->name('signup');
Route::post('signup', [RegistrationController::class, 'store']);

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function(){

    Route::get('/', [WelcomeController::class, 'index']);

    // Menu User
    Route::middleware(['authorize:ADM'])->group(function() {
        Route::get('/user', [UserController::class, 'index']);          // menampilkan halaman awal user
        Route::Post('/user/list', [UserController::class, 'list']);      // menampilkan data user
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
        Route::post('user//ajax', [UserController::class, 'store_ajax']);        // menyimpan data user baru ajax
        Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']);    // menampilkan halaman awal user ajax
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);     // menampilkan halaman form edit user ajax
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user ajax
        Route::get('/user/{id}/confirm_ajax', [UserController::class, 'confirm_ajax']); // untuk tampilan form confirm delete user ajax
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user ajax
    });

    // Menu Level
    Route::middleware(['authorize:ADM'])->group(function() {
        Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
        Route::Post('/level/list', [LevelController::class, 'list']);      // menampilkan data level
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan halaman form tambah level ajax
        Route::post('level//ajax', [LevelController::class, 'store_ajax']);        // menyimpan data level baru ajax
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']);    // menampilkan halaman awal level ajax
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);     // menampilkan halaman form edit level ajax
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data level ajax
        Route::get('/level/{id}/confirm_ajax', [LevelController::class, 'confirm_ajax']); // untuk tampilan form confirm delete level ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // menghapus data level ajax
    });

    // Menu Kategori
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function() {
        Route::get('/kategori', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
        Route::Post('/kategori/list', [KategoriController::class, 'list']);      // menampilkan data kategori
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan halaman form tambah kategori ajax
        Route::post('kategori//ajax', [KategoriController::class, 'store_ajax']);        // menyimpan data kategori baru ajax
        Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']);    // menampilkan halaman awal kategori ajax
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);     // menampilkan halaman form edit kategori ajax
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori ajax
        Route::get('/kategori/{id}/confirm_ajax', [KategoriController::class, 'confirm_ajax']); // untuk tampilan form confirm delete kategori ajax
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori ajax
    });

    // Menu Supplier
    Route::middleware(['authorize:ADM,MNG'])->group(function() {
        Route::get('/supplier', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
        Route::Post('/supplier/list', [SupplierController::class, 'list']);      // menampilkan data supplier
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah supplier ajax
        Route::post('supplier//ajax', [SupplierController::class, 'store_ajax']);        // menyimpan data supplier baru ajax
        Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']);    // menampilkan halaman awal supplier ajax
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);     // menampilkan halaman form edit supplier ajax
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data supplier ajax
        Route::get('/supplier/{id}/confirm_ajax', [SupplierController::class, 'confirm_ajax']); // untuk tampilan form confirm delete supplier ajax
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // menghapus data supplier ajax
    });

    // Menu Barang
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function() {
        Route::get('/barang', [BarangController::class, 'index']);          // menampilkan halaman awal barang
        Route::Post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah barang ajax
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);        // menyimpan data barang baru ajax
        Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);    // menampilkan halaman awal barang ajax
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);     // menampilkan halaman form edit barang ajax
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data barang ajax
        Route::get('/barang/{id}/confirm_ajax', [BarangController::class, 'confirm_ajax']); // untuk tampilan form confirm delete barang ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // menghapus data barang ajax
    });
});