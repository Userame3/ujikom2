<?php

namespace App\Imports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
    //  * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Menu([
            'kategori_id' => $row['jenis_id'],
            'nama_menu' => $row['menu'],
            'harga' => $row['harga'],
            'stok' => $row['stok'],
            'image' => $row['image'],
            'deskripsi' => $row['deskripsi']
        ]);
        // dd($row);
    }
    public function headingRow(): int
    {
        return 3;
    }
}
