<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $penjualan = null;
        $activeMenu = 'detail'; //set menu yang sedang aktif
        $penjualans = PenjualanModel::all(); // ambil data penjualan untuk filter penjualan

        return view('detail.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualans' => $penjualans, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman awal detail penjualan
    public function index_id(String $id)
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar detail penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'detail'; //set menu yang sedang aktif
        if ($id) {
            $penjualan = PenjualanModel::findOrFail($id);
            $penjualans = PenjualanModel::all(); // ambil data penjualan untuk filter penjualan

            return view('detail.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualans' => $penjualans, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
        } else {
            $penjualans = PenjualanModel::all(); // ambil data penjualan untuk filter penjualan

            return view('detail.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualans' => $penjualans, 'activeMenu' => $activeMenu]);
        }
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

            DetailPenjualanModel::create($request->all());
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

    public function export_excel()
    {
        // ambil data detail penjualan yang akan diexport
        $penjualan = DetailPenjualanModel::select('penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->orderBy('penjualan_id')
            ->with('penjualan', 'barang')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // ambil data yang aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Jumlah');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);    // bold header

        $no = 1;        // nomor data dimulai dari 1
        $baris = 2;     // baris data dimulai dari baris ke 2
        foreach ($penjualan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->penjualan->penjualan_kode);
            $sheet->setCellValue('C' . $baris, $value->barang->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->harga);
            $sheet->setCellValue('E' . $baris, $value->jumlah);
            $baris++;
            $no++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);   // set auto size untuk kolom
        }

        $sheet->setTitle('Data Detail Penjualan');    // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Detail Penjualan' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $detail = DetailPenjualanModel::select('penjualan_id', 'barang_id', 'harga', 'jumlah')
                ->orderBy('penjualan_id')
                ->orderBy('barang_id')
                ->with('penjualan', 'barang')
                ->get();
                
        $pdf = Pdf::loadView('detail.export_pdf', ['detail' => $detail]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data Detail Penjualan' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function import()
    {
        return view('detail.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_detail' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_detail'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'penjualan_id' => $value['A'],
                            'barang_id' => $value['B'],
                            'harga' => $value['C'],
                            'jumlah' => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    DetailPenjualanModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/detail');
    }
}
