<?php

namespace App\Imports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Menu([
            'jenis_id' => auth()->user()->jenis_id,
            'nama_menu' => $row['nama_menu'],
            'harga' => $row['harga'],
            'stok' => $row['stok'],
            'image' => $row['image'],
            'deskripsi' => $row['deskripsi']
        ]);
    }
    public function headingRow(): int
    {
        return 3;
    }
}
