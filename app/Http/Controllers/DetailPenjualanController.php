<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DetailPenjualanController extends Controller
{
    // Menampilkan halaman awal detail penjualan
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar detail penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'detail'; //set menu yang sedang aktif

        $penjualan = PenjualanModel::all(); // ambil data penjualan untuk filter penjualan

        return view('detail.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    // Ambil data penjualan dalam bentuk json untuk datables
    public function list(Request $request)
    {
        $details = DetailPenjualanModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->with('penjualan', 'barang');

        //Filter data penjualan berdasarkan penjualan_id
        if ($request->penjualan_id) {
            $details->where('penjualan_id', $request->penjualan_id);
        }

        return DataTables::of($details)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($detail) {  // menambahkan kolom aksi 
                $btn = '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id .
                    '/confirm_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    // Menampilkan halaman form tambah penjualan ajax
    public function create_ajax()
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        // Kirimkan semua data ke view
        return view('detail.create_ajax', [
            'penjualan' => $penjualan,
            'barang' => $barang,
        ]);
    }

    // Menyimpan data detail penjualan baru ajax
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id'  => 'required|integer',
                'barang_id'     => 'required|integer',
                'harga'         => 'required|integer',
                'jumlah'        => 'required|integer',
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

            PenjualanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data detail penjualan berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail penjualan ajax
    public function show_ajax(String $id)
    {
        $detail = DetailPenjualanModel::with('penjualan', 'barang')->find($id);

        return view('detail.show_ajax', ['detail' => $detail]);
    }

    // Menampilkan halaman form edit detail penjualan ajax
    public function edit_ajax(String $id)
    {
        $detail = DetailPenjualanModel::find($id);
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('detail.edit_ajax', ['detail' => $detail,  'penjualan' => $penjualan,  'barang' => $barang]);
    }


    // Menyimpan perubahan data detail penjualan ajax
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id'  => 'required|integer',
                'barang_id'     => 'required|integer',
                'harga'         => 'required|integer',
                'jumlah'        => 'required|integer',
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
            $check = DetailPenjualanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    // Menampilkan hapus data detail penjualan ajax
    public function confirm_ajax(string $id) {
        $detail = DetailPenjualanModel::find($id);
        
        return view('detail.confirm_ajax', ['detail' => $detail]);
    }

    // Menghapus data detail ajax
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $detail = DetailPenjualanModel::find($id);
            if ($detail) {
                $detail->delete();
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
