<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'Adi',
                'penjualan_kode' => '01090920024',
                'penjualan_tanggal' => date('2024-09-09'),
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Budi',
                'penjualan_kode' => '02090920024',
                'penjualan_tanggal' => date('2024-09-09'),
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Candra',
                'penjualan_kode' => '03090920024',
                'penjualan_tanggal' => date('2024-09-09'),
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'Doni',
                'penjualan_kode' => '04090920024',
                'penjualan_tanggal' => date('2024-09-09'),
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli' => 'Endah',
                'penjualan_kode' => '05100920024',
                'penjualan_tanggal' => date('2024-09-10'),
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Fauzan',
                'penjualan_kode' => '06100920024',
                'penjualan_tanggal' => date('2024-09-10'),
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => 'Garou',
                'penjualan_kode' => '07100920024',
                'penjualan_tanggal' => date('2024-09-10'),
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => 'Hans',
                'penjualan_kode' => '08110920024',
                'penjualan_tanggal' => date('2024-09-11'),
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Indah',
                'penjualan_kode' => '09110920024',
                'penjualan_tanggal' => date('2024-09-11'),
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'Jeane',
                'penjualan_kode' => '10110920024',
                'penjualan_tanggal' => date('2024-09-11'),
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}