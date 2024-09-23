<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        /* // Tambah data user dengan Eloquent Model
        $data = [
            'username' => 'customer-1',
            'nama' => 'Pelanggan',
            'password' => Hash::make('12345'),
            'level_id' => 4
        ];
        UserModel::insert($data);  // Tambahkan data ke tabel m_user */

        /* // Tambah data dengan Equolent Model
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];
        UserModel::where('username', 'customer-1')->update($data); //update data user

        // Coba akses model user
        $user = UserModel::all(); // Ambil semua data dari tabel m_user
        return view('user', ['data' => $user]); */

        // Pertemuan4 - Praktikum1
        /* $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        UserModel::create($data);

        $user = UserModel::all();
        return view('user', ['data' => $user]); */

        // Metode Find
        /* $user = UserModel::find(1);
        return view('user', ['data' => $user]); */

        // Metode First
        /* $user = UserModel::where('level_id', 1)->first();
        return view('user', ['data' => $user]); */
        
        /* $user = UserModel::firstwhere('level_id', 1); // Kode ini biasanya digunakan untuk mengambil data berdasarkan satu kondisi saja
        return view('user', ['data' => $user]); */

        //Moteode FindOr
        $user = UserModel::findOr(20, ['username', 'nama'], function() {
            abort(404);
        });
        return view('user', ['data' => $user]);
    }
}
