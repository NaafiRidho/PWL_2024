<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            for ($i = 1; $i <= 10; $i++) { // 10 transaksi penjualan
                for ($j = 1; $j <= 3; $j++) { // 3 barang per transaksi
                    $barang_id = rand(1, 10); // Ambil barang secara acak
                    $harga = DB::table('m_barang')->where('barang_id', $barang_id)->value('harga_jual');
                    $jumlah = rand(1, 5); // Jumlah barang yang dibeli
                    $subtotal = $harga * $jumlah; // Hitung total harga

                    DB::table('t_penjualan_detail')->insert([
                        'penjualan_id' => $i,
                        'barang_id' => $barang_id,
                        'harga' => $harga,
                        'jumlah' => $jumlah,
                    ]);
                }
            }
        }
    }
}
