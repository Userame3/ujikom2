<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Stok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stok = [
            ['jumlah' => 23],
            ['jumlah' => 23],
            ['jumlah' => 23],
            ['jumlah' => 23],
            ['jumlah' => 23],
        ];
        $menu = [
            [
                'kategori_id' => 3,
                'nama_menu' => 'Croissant',
                'harga' => '5000',
                'stok_id' => 1,
                'images' => '',
                'deskripsi' => 'Dibaca Quaso-',
            ],
            [
                'kategori_id' => 2,
                'nama_menu' => 'Nasi Goreng',
                'harga' => '15000',
                'stok_id' => 2,
                'images' => '',
                'deskripsi' => 'Nasi goreng dengan topping telor ceplok.',
            ],
            [
                'kategori_id' => 2,
                'nama_menu' => 'Soto ayam',
                'harga' => '9000',
                'stok_id' => 3,
                'images' => '',
                'deskripsi' => 'Soto kuah bening.',
            ],
            [
                'kategori_id' => 1,
                'nama_menu' => 'Soda gembira',
                'harga' => '6000',
                'stok_id' => 4,
                'images' => '',
                'deskripsi' => 'Soda susu + lemon',
            ],
            [
                'kategori_id' => 1,
                'nama_menu' => 'Milkshake coklat',
                'harga' => '8000',
                'stok_id' => 5,
                'images' => '',
                'deskripsi' => 'Susu kocok rasa coklat.',
            ],
            [
                'kategori_id' => 2,
                'nama_menu' => 'Nasi Goreng',
                'harga' => '9000',
                'stok_id' => 3,
                'images' => '',
                'deskripsi' => 'Nasi Goreng Merah.',
            ],
            [
                'kategori_id' => 1,
                'nama_menu' => 'Watermelon Punch',
                'harga' => '6000',
                'stok_id' => 4,
                'images' => '',
                'deskripsi' => 'Soda lemon + Semangka',
            ],
            [
                'kategori_id' => 3,
                'nama_menu' => 'Donut',
                'harga' => '5000',
                'stok_id' => 1,
                'images' => '',
                'deskripsi' => 'Donat Berbagai Toping',
            ],
            [
                'kategori_id' => 3,
                'nama_menu' => 'Kentang Goreng',
                'harga' => '5000',
                'stok_id' => 1,
                'images' => '',
                'deskripsi' => 'Kentang Wedges di dry fried',
            ],
            [
                'kategori_id' => 1,
                'nama_menu' => ' Matcha Latte',
                'harga' => '8000',
                'stok_id' => 5,
                'images' => '',
                'deskripsi' => 'Susu fullcream + Matcha.',
            ],

        ];

        foreach ($stok as $key => $value) {
            Stok::create($value);
        }

        foreach ($menu as $key => $value) {
            $newstok = Stok::create(['jumlah' => random_int(1, 50)]);
            $value['stok_id'] = $newstok->id;
            Menu::create($value);
        }
    }
}
