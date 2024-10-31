<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index() {
        return KategoriModel::all();
    }

    public function store(Request $request) {
        //set validation
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|min:3',
            'kategori_nama' => 'required',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategori = KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        //return response JSON kategori is created
        if ($kategori) {
            return response()->json([
                'success' => true,
                'kategori' => $kategori,
            ], 201);
        }
    }

    public function show(KategoriModel $kategori) {
        return KategoriModel::find($kategori);
    }

    public function update(Request $request, KategoriModel $kategori) {
        $kategori->update($request->all());
        return KategoriModel::find($kategori);
    }

    public function destroy(KategoriModel $kategori) {
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
