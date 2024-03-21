<?php

namespace App\Imports;

use App\Models\Jenis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JenisImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Jenis([
            'id' => auth()->user()->jenis_id,
            'nama' => $row['nama']
        ]);
    }

    public function headingRow(): int
    {
        return 3;
    }
}
