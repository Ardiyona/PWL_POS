<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StokController;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/', [WelcomeController::class, 'index']);

    // Menu User
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/user', [UserController::class, 'index']);          // menampilkan halaman awal user
        Route::Post('/user/list', [UserController::class, 'list']);      // menampilkan data user
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
        Route::post('user/ajax', [UserController::class, 'store_ajax']);        // menyimpan data user baru ajax
        Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']);    // menampilkan halaman awal user ajax
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);     // menampilkan halaman form edit user ajax
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user ajax
        Route::get('/user/{id}/confirm_ajax', [UserController::class, 'confirm_ajax']); // untuk tampilan form confirm delete user ajax
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user ajax
        Route::get('/user/export_excel', [UserController::class, 'export_excel']);   // export excel
        Route::get('/user/export_pdf', [UserController::class, 'export_pdf']);   // export pdf
        Route::get('/user/import', [UserController::class, 'import']);  // ajax form upload excel
        Route::post('/user/import_ajax', [UserController::class, 'import_ajax']);   // ajax import excel
    });

    // Menu Level
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
        Route::Post('/level/list', [LevelController::class, 'list']);      // menampilkan data level
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan halaman form tambah level ajax
        Route::post('level/ajax', [LevelController::class, 'store_ajax']);        // menyimpan data level baru ajax
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']);    // menampilkan halaman awal level ajax
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);     // menampilkan halaman form edit level ajax
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data level ajax
        Route::get('/level/{id}/confirm_ajax', [LevelController::class, 'confirm_ajax']); // untuk tampilan form confirm delete level ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // menghapus data level ajax
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']);   // export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']);   // export pdf
        Route::get('/level/import', [LevelController::class, 'import']);  // ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']);   // ajax import excel
    });

    // Menu Kategori
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
        Route::Post('/kategori/list', [KategoriController::class, 'list']);      // menampilkan data kategori
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan halaman form tambah kategori ajax
        Route::post('kategori/ajax', [KategoriController::class, 'store_ajax']);        // menyimpan data kategori baru ajax
        Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']);    // menampilkan halaman awal kategori ajax
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);     // menampilkan halaman form edit kategori ajax
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori ajax
        Route::get('/kategori/{id}/confirm_ajax', [KategoriController::class, 'confirm_ajax']); // untuk tampilan form confirm delete kategori ajax
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori ajax
        Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']);   // export excel
        Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']);   // export pdf
        Route::get('/kategori/import', [KategoriController::class, 'import']);  // ajax form upload excel
        Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']);   // ajax import excel
    });

    // Menu Supplier
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
        Route::Post('/supplier/list', [SupplierController::class, 'list']);      // menampilkan data supplier
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah supplier ajax
        Route::post('supplier/ajax', [SupplierController::class, 'store_ajax']);        // menyimpan data supplier baru ajax
        Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']);    // menampilkan halaman awal supplier ajax
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);     // menampilkan halaman form edit supplier ajax
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data supplier ajax
        Route::get('/supplier/{id}/confirm_ajax', [SupplierController::class, 'confirm_ajax']); // untuk tampilan form confirm delete supplier ajax
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // menghapus data supplier ajax
        Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']);   // export excel
        Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']);   // export pdf
        Route::get('/supplier/import', [SupplierController::class, 'import']);  // ajax form upload excel
        Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']);   // ajax import excel
    });

    // Menu Barang
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);          // menampilkan halaman awal barang
        Route::Post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah barang ajax
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);        // menyimpan data barang baru ajax
        Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);    // menampilkan halaman awal barang ajax
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);     // menampilkan halaman form edit barang ajax
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data barang ajax
        Route::get('/barang/{id}/confirm_ajax', [BarangController::class, 'confirm_ajax']); // untuk tampilan form confirm delete barang ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // menghapus data barang ajax
        Route::get('/barang/import', [BarangController::class, 'import']);  // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']);   // ajax import excel
        Route::get('/barang/export_excel', [BarangController::class, 'export_excel']);   // export excel
        Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']);   // export pdf
    });

    // Menu Profile
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index']);          // menampilkan halaman awal barang
        Route::get('/profile/{id}/upload', [ProfileController::class, 'upload']);  // ajax form upload excel
        Route::post('/profile/{id}/upload_ajax', [ProfileController::class, 'upload_ajax'])->name('editProfile');   // ajax import excel
    });

    // Menu stok barang
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/stok', [StokController::class, 'index']);          // menampilkan halaman awal stok
        Route::Post('/stok/list', [StokController::class, 'list']);      // menampilkan data stok
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']); // menampilkan halaman form tambah stok ajax
        Route::post('stok/ajax', [StokController::class, 'store_ajax']);        // menyimpan data stok baru ajax
        Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']);    // menampilkan halaman awal stok ajax
        Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']);     // menampilkan halaman form edit stok ajax
        Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']); // menyimpan perubahan data stok ajax
        Route::get('/stok/{id}/confirm_ajax', [StokController::class, 'confirm_ajax']); // untuk tampilan form confirm delete stok ajax
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // menghapus data stok ajax
        Route::get('/stok/export_excel', [StokController::class, 'export_excel']);   // export excel
        Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']);   // export pdf
        Route::get('/stok/import', [StokController::class, 'import']);  // ajax form upload excel
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']);   // ajax import excel
    });

    // Menu transaksi penjualan
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);          // menampilkan halaman awal penjualan
        Route::Post('/penjualan/list', [PenjualanController::class, 'list']);      // menampilkan data penjualan
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']); // menampilkan halaman form tambah penjualan ajax
        Route::post('penjualan/ajax', [PenjualanController::class, 'store_ajax']);        // menyimpan data penjualan baru ajax
        Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);    // menampilkan halaman awal penjualan ajax
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);     // menampilkan halaman form edit penjualan ajax
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // menyimpan perubahan data penjualan ajax
        Route::get('/penjualan/{id}/confirm_ajax', [PenjualanController::class, 'confirm_ajax']); // untuk tampilan form confirm delete penjualan ajax
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // menghapus data penjualan ajax
        Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']);   // export excel
        Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']);   // export pdf
        Route::get('/penjualan/import', [PenjualanController::class, 'import']);  // ajax form upload excel
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);   // ajax import excel
    });

    // Menu transaksi penjualan
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/detail', [DetailPenjualanController::class, 'index']);          // menampilkan halaman awal detail
        Route::Post('/detail/list', [DetailPenjualanController::class, 'list']);      // menampilkan data detail
        Route::get('/detail/create_ajax', [DetailPenjualanController::class, 'create_ajax']); // menampilkan halaman form tambah detail ajax
        Route::post('detail/ajax', [DetailPenjualanController::class, 'store_ajax']);        // menyimpan data detail baru ajax
        Route::get('/detail/{id}/show_ajax', [DetailPenjualanController::class, 'show_ajax']);    // menampilkan halaman awal detail ajax
        Route::get('/detail/{id}/edit_ajax', [DetailPenjualanController::class, 'edit_ajax']);     // menampilkan halaman form edit detail ajax
        Route::put('/detail/{id}/update_ajax', [DetailPenjualanController::class, 'update_ajax']); // menyimpan perubahan data detail ajax
        Route::get('/detail/{id}/confirm_ajax', [DetailPenjualanController::class, 'confirm_ajax']); // untuk tampilan form confirm delete detail ajax
        Route::delete('/detail/{id}/delete_ajax', [DetailPenjualanController::class, 'delete_ajax']); // menghapus data detail ajax
        Route::get('/detail/export_excel', [DetailPenjualanController::class, 'export_excel']);   // export excel
        Route::get('/detail/export_pdf', [DetailPenjualanController::class, 'export_pdf']);   // export pdf
        Route::get('/detail/import', [DetailPenjualanController::class, 'import']);  // ajax form upload excel
        Route::post('/detail/import_ajax', [DetailPenjualanController::class, 'import_ajax']);   // ajax import excel
        Route::get('/detail/{id}', [DetailPenjualanController::class, 'index_id']);          // menampilkan halaman awal detail
    });
});
