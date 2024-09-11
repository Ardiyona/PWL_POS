<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'JUS',
                'supplier_nama' => 'Jaya Utama Santikah',
                'supplier_alamat' => 'JL Daan Mogot, Jakarta Barat, DKI Jakarta,',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'PMJY',
                'supplier_nama' => 'Podo Mekar Jaya Sentosa',
                'supplier_alamat' => 'Jl. Pucang Anom No. 22, Surabaya, Jawa Timur',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'RCP',
                'supplier_nama' => 'Ramdays Cendani Prima',
                'supplier_alamat' => 'Jl.Penganten Ali No.42 A Ruko OASIS Mansion Ciracas, Jakarta Timur, DKI Jakarta',
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}