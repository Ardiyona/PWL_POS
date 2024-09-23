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

        // Metode FindOr
        /* $user = UserModel::findOr(20, ['username', 'nama'], function() {
            abort(404);
        });
        return view('user', ['data' => $user]); */

        // Metode FindOrFail
        /* $user = UserModel::findOrFail(1);
        return view('user', ['data' => $user]); */

        // Metode FirstOrFail
        /* $user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]); */

        // Metode Count
        /* $user = UserModel::where('level_id', 2)->count();
        return view('user', ['data' => $user]); */

        // Metode FirstOrCreate
        /* $user = UserModel::firstOrCreate(
            [
                'username' => 'manager22',
                'nama' => 'Manager Dua Dua',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
        );
        return view('user', ['data' => $user]); */

        // Metode FirstOrNew
        /* $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
        );
        $user->save();
        return view('user', ['data' => $user]); */

        // Metode isClean dan isDirty
        /* $user = UserModel::create(
            [
                'username' => 'manager55',
                'nama' => 'Manager55',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
        );

        $user->username = 'manager56';

        $user->isDirty(); //true
        $user->isDirty('username'); //true
        $user->isDirty('nama'); //false
        $user->isDirty(['nama', 'username']); //true

        $user->isClean(); //false
        $user->isClean('username'); //false
        $user->isClean('nama'); //true
        $user->isClean(['nama', 'username']); //false

        $user->save();

        $user->isDirty();
        $user->isClean();
        dd($user->isDirty()); */

        // Metode wasChanged
        /* $user = UserModel::create(
            [
                'username' => 'manager11',
                'nama' => 'Manager11',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
        );

        $user->username = 'manager12';

        $user->save();

        $user->wasChanged(); //true
        $user->wasChanged('username'); //true
        $user->wasChanged(['username', 'level_id']); //true
        $user->wasChanged('nama'); //false
        $user->wasChanged(['nama', 'username']); //true
        dd($user->wasChanged(['nama', 'username'])); //true */

        // Praktikum 2.6
        /* $user = UserModel::all();
        return view('user', ['data' => $user]); */

        // Praktikum 2.7
        $user = UserModel::with('level')->get();
        return view('user', ['data'=>$user]);
    }

    public function tambah() {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user');
    }

    public function ubah($id) {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request) {
        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id) {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}
