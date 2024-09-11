<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'stok_id' => 1,
                'supplier_id' => 1,
                'barang_id' => 1,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-01'),
                'stok_jumlah' => 83,
            ],
            [
                'stok_id' => 2,
                'supplier_id' => 1,
                'barang_id' => 2,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-01'),
                'stok_jumlah' => 65,
            ],
            [
                'stok_id' => 3,
                'supplier_id' => 1,
                'barang_id' => 3,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-03'),
                'stok_jumlah' => 23,
            ],
            [
                'stok_id' => 4,
                'supplier_id' => 1,
                'barang_id' => 4,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-03'),
                'stok_jumlah' => 107,
            ],
            [
                'stok_id' => 5,
                'supplier_id' => 1,
                'barang_id' => 5,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-03'),
                'stok_jumlah' => 49,
            ],
            [
                'stok_id' => 6,
                'supplier_id' => 2,
                'barang_id' => 6,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-03'),
                'stok_jumlah' => 3,
            ],
            [
                'stok_id' => 7,
                'supplier_id' => 2,
                'barang_id' => 7,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-05'),
                'stok_jumlah' => 24,
            ],
            [
                'stok_id' => 8,
                'supplier_id' => 2,
                'barang_id' => 8,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-06'),
                'stok_jumlah' => 67,
            ],
            [
                'stok_id' => 9,
                'supplier_id' => 2,
                'barang_id' => 9,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-06'),
                'stok_jumlah' => 19,
            ],
            [
                'stok_id' => 10,
                'supplier_id' => 2,
                'barang_id' => 10,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-06'),
                'stok_jumlah' => 42,
            ],
            [
                'stok_id' => 11,
                'supplier_id' => 3,
                'barang_id' => 11,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-07'),
                'stok_jumlah' => 126,
            ],
            [
                'stok_id' => 12,
                'supplier_id' => 3,
                'barang_id' => 12,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-07'),
                'stok_jumlah' => 71,
            ],
            [
                'stok_id' => 13,
                'supplier_id' => 3,
                'barang_id' => 13,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-07'),
                'stok_jumlah' => 20,
            ],
            [
                'stok_id' => 14,
                'supplier_id' => 3,
                'barang_id' => 14,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-09'),
                'stok_jumlah' => 69,
            ],
            [
                'stok_id' => 15,
                'supplier_id' => 3,
                'barang_id' => 15,
                'user_id' => 2,
                'stok_tanggal' => date('2024-09-09'),
                'stok_jumlah' => 37,
            ],
        ];
        DB::table('t_stok')->insert($data);
    }
}