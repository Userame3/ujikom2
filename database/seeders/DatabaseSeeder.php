<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $makanan = Jenis::create([
            'nama_jenis' => 'Minuman'
        ]);

        $minuman = Jenis::create([
            'nama_jenis' => 'Makanan'
        ]);
        $minuman = Jenis::create([
            'nama_jenis' => 'Camilan'
        ]);
        $this->call(MenuSeeder::class);
        $this->call(TransaksiSeeder::class);
        $this->call(DetailTransaksiSeeder::class);
        $this->call(PelangganSeeder::class);
    }
}
