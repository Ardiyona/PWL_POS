<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $page = (object)[
            'title' => 'Profile'
        ];

        $activeMenu = 'null'; //set menu yang sedang aktif

        $user = Auth::user();
        $user_id = $user->id; // Mengambil ID user
        $username = $user->username;
        $foto = $user->foto;

        $nama = $user->nama; // Asumsikan nama pengguna disimpan dalam kolom 'name'

        return view('profile.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu], compact('nama', 'username', 'foto'));
    }

    public function upload(String $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        return view('profile.upload', ['user' => $user, 'level' => $level]);
    }

    public function upload_ajax(Request $request, String $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20',
                'foto' => 'nullable|mimes:jpeg,jpg,png|max:102400',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
    
            $check = UserModel::find($id);
    
            if ($check) {
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
    
                if ($request->hasFile('foto')) {
                    $foto = time() . '_' . $request->file('foto')->getClientOriginalName();
                    $request->file('foto')->storeAs('public/images/', $foto);
                    $check->update([
                        'username' => $request->username,
                        'nama' => $request->nama,
                        'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                        'level_id' => $request->level_id,
                        'foto' => $foto,
                    ]);
                } else {
                    $check->update([
                        'username' => $request->username,
                        'nama' => $request->nama,
                        'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                        'level_id' => $request->level_id,
                    ]);
                }
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                    'redirect' => url('/profile')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    
        return redirect('/');
    }
}
