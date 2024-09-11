<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'Kategori_id' => 1,
                'barang_kode' => 'HTRBSC',
                'barang_nama' => 'Hatari Biscuit kaleng',
                'harga_beli' => '45000',
                'harga_jual' => '60000',
            ],
            [
                'barang_id' => 2,
                'Kategori_id' => 1,
                'barang_kode' => 'SRNRDC',
                'barang_nama' => 'SERENA RODEO CREAM',
                'harga_beli' => '2500',
                'harga_jual' => '4000',
            ],
            [
                'barang_id' => 3,
                'Kategori_id' => 1,
                'barang_kode' => 'NSSVGTB',
                'barang_nama' => 'NISSIN VEGETABLES CRACKERS',
                'harga_beli' => '3400',
                'harga_jual' => '5700',
            ],
            [
                'barang_id' => 4,
                'Kategori_id' => 1,
                'barang_kode' => 'CSP',
                'barang_nama' => 'Chesa pancake',
                'harga_beli' => '14300',
                'harga_jual' => '18000',
            ],
            [
                'barang_id' => 5,
                'Kategori_id' => 2,
                'barang_kode' => 'HLTT',
                'barang_nama' => 'Hilo Thai Tea',
                'harga_beli' => '1625',
                'harga_jual' => '2400',
            ],
            [
                'barang_id' => 6,
                'Kategori_id' => 5,
                'barang_kode' => 'IMSFA',
                'barang_nama' => 'Imusive for Adults suplemen dan vitamin',
                'harga_beli' => '22500',
                'harga_jual' => '35000',
            ],
            [
                'barang_id' => 7,
                'Kategori_id' => 5,
                'barang_kode' => 'ITNF',
                'barang_nama' => 'Intunal-F',
                'harga_beli' => '2700',
                'harga_jual' => '4500',
            ],
            [
                'barang_id' => 8,
                'Kategori_id' => 5,
                'barang_kode' => 'VTMC',
                'barang_nama' => 'Vitamin C',
                'harga_beli' => '5300',
                'harga_jual' => '8100',
            ],
            [
                'barang_id' => 9,
                'Kategori_id' => 5,
                'barang_kode' => 'BRCTEXP',
                'barang_nama' => 'Bronchitin Expectorant',
                'harga_beli' => '13000',
                'harga_jual' => '17500',
            ],
            [
                'barang_id' => 10,
                'Kategori_id' => 5,
                'barang_kode' => 'NFD',
                'barang_nama' => 'Nufadol',
                'harga_beli' => '11500',
                'harga_jual' => '15800',
            ],
            [
                'barang_id' => 11,
                'Kategori_id' => 3,
                'barang_kode' => 'KPBST',
                'barang_nama' => 'Kamper Ball Swallow Toilet',
                'harga_beli' => '1500',
                'harga_jual' => '2700',
            ],
            [
                'barang_id' => 12,
                'Kategori_id' => 3,
                'barang_kode' => 'STLAN',
                'barang_nama' => 'Stella Aerosol Naturals',
                'harga_beli' => '32400',
                'harga_jual' => '39600',
            ],
            [
                'barang_id' => 13,
                'Kategori_id' => 3,
                'barang_kode' => 'WPKWP',
                'barang_nama' => 'Wipol Karbol Wangi Pouch',
                'harga_beli' => '27000',
                'harga_jual' => '33500',
            ],
            [
                'barang_id' => 14,
                'Kategori_id' => 3,
                'barang_kode' => 'BMCD',
                'barang_nama' => 'BOOM Cream Detergent',
                'harga_beli' => '8700',
                'harga_jual' => '10200',
            ],
            [
                'barang_id' => 15,
                'Kategori_id' => 3,
                'barang_kode' => 'TAFYKP',
                'barang_nama' => 'Yuri Krim Pembersih TAF',
                'harga_beli' => '21500',
                'harga_jual' => '25800',
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}