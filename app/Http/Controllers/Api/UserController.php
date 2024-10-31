<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        return UserModel::all();
    }

    public function store(Request $request) {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5',
            'level_id' => 'required',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        //return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        }
    }

    public function show(UserModel $user) {
        return UserModel::find($user);
    }

    public function update(Request $request, UserModel $user) {
        $user->update($request->all());
        return UserModel::find($user);
    }

    public function destroy(UserModel $user) {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
