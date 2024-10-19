<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    // Menampilkan halaman awal stok
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object)[
            'title' => 'Daftar stok barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif

        $supplier = SupplierModel::all(); // ambil data supplier untuk filter supplier
        $barang = BarangModel::all(); // ambil data barang untuk filter barang
        $user = UserModel::all(); // ambil data user untuk filter user

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Ambil data stok dalam bentuk json untuk datables
    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('supplier', 'barang', 'user',);

        //Filter data stok berdasarkan supplier_id
        if ($request->supplier_id) {
            $stoks->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($stoks)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {  // menambahkan kolom aksi 
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id .
                    '/confirm_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    // Menampilkan halaman form tambah stok barang ajax
    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        // Kirimkan semua data ke view
        return view('stok.create_ajax', [
            'supplier' => $supplier,
            'barang' => $barang,
            'user' => $user
        ]);
    }

    // Menyimpan data stok barang baru ajax
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id'  => 'required|integer',
                'barang_id'  => 'required|integer',
                'user_id'  => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah'      => 'required|integer'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,  // response status , false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            StokModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail stok barang ajax
    public function show_ajax(String $id) {
        $stok = StokModel::with('supplier', 'barang', 'user')->find($id);
    
        return view('stok.show_ajax', ['stok' => $stok]);
    }

    // Menampilkan halaman form edit stok barang ajax
    public function edit_ajax(String $id) {
        $stok = StokModel::find($id);
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        return view('stok.edit_ajax', ['stok' => $stok, 'supplier' => $supplier,  'barang' => $barang,  'user' => $user]);
    }

    
    // Menyimpan perubahan data stok barang ajax
    public function update_ajax(Request $request, $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id'  => 'required|integer',
                'barang_id'  => 'required|integer',
                'user_id'  => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah'      => 'required|integer'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = StokModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    // Menampilkan hapus data stok ajax
    public function confirm_ajax(string $id) {
        $stok = StokModel::find($id);
        
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    // Menghapus data stok ajax
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
