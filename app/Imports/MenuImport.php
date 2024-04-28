<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\Stok;
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
        $stok = Stok::find($row['stok_id']);
        if($stok){
            $stok->update(['jumlah'=>0]);
        }else{
            Menu::find($row['no'])->stok(['jumlah'=>0]);
        }
        return new Menu([
            'kategori_id' => $row['kategori_id'],
            'nama_menu' => $row['menu'],
            'harga' => $row['harga'],
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
