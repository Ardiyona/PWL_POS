<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index() {
        return BarangModel::all();
    }

    public function store(Request $request) {
        //set validation
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'barang_kode' => 'required|min:3',
            'barang_nama' => 'required',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/images/', $image);

        $barang = BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'image' => $image,
        ]);
        //return response JSON barang is created
        if ($barang) {
            return response()->json([
                'success' => true,
                'barang' => $barang,
            ], 201);
        }
    }

    public function show(BarangModel $barang) {
        return BarangModel::find($barang);
    }

    public function update(Request $request, BarangModel $barang) {
        $barang->update($request->all());
        return BarangModel::find($barang);
    }

    public function destroy(BarangModel $barang) {
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
