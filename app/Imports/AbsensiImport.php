<?php

namespace App\Imports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Absensi([
            'namaKaryawan' => $row['nama_karyawan'],
            'tanggalMasuk' => $row['tanggal_masuk'],
            'waktuMasuk' => $row['waktu_masuk'],
            'status' => $row['status'],
            'waktuKeluar' => $row['waktu_keluar']
        ]);
    }
}
