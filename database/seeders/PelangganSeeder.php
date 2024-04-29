<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelanggans = [
            [
                'nama' => 'Pelanggan umum',
                'email' => 'anonymous@gmail.com',
                'no_telp' => '089530377010',
                'alamat' => 'Bayubudd',
            ],
        ];
        foreach ($pelanggans as $key => $value) {
            Pelanggan::create($value);
        }
        Pelanggan::factory()->count(5)->create();
    }
}
