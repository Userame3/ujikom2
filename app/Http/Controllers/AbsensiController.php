<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsenExport;
use App\Imports\AbsensiImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use PDOException;



class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['absensi'] = Absensi::orderBy('created_at', 'DESC')->get();
        return view('absensi.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAbsensiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbsensiRequest $request)
    {
        Absensi::create($request->all());
        return redirect('absensi')->with('success', 'Data Karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbsensiRequest  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbsensiRequest  $request, Absensi $absensi)
    {
        $absensi->update($request->all());
        return redirect('absensi')->with('success', 'Update Data Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect('absensi')->with('success', 'Data Absensi berhasil dihapus!');
    }
    public function exportData()
    {
        $date = date('Y-m-d');
        // return Excel::download(new AbsensiExport, $date . '_Absen.xlsx');
    }

    public function importData()
    {

        Excel::import(new AbsensiImport, request()->file('import'));
        return redirect('absensi')->with('success', 'Import data Titipan berhasil');
    }

    public function exportPDF()
    {
        // Ambil data yang akan diekspor (contoh: dari database)
        $data = Absensi::all();

        // Render data ke dalam tampilan HTML
        $html = view('Absensi.pdf', compact('data'))->render();
        // Inisialisasi Dompdf
        $dompdf = new Dompdf();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran dan orientasi halaman
        $dompdf->setPaper('A4', 'potrait');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Simpan atau kirimkan PDF ke browser
        return $dompdf->stream('laporan.pdf');
    }
    public function updateStatus(Request $request)
    {
        $row_num = $request->input('row_num');
        $new_status = $request->input('new_status');

        // Temukan data absensi dengan nomor baris yang sesuai
        $absen = Absensi::find($row_num);

        // Jika data absensi tidak ditemukan, kembalikan respons dengan pesan error
        if (!$absen) {
            return response()->json(['error' => 'Data absensi tidak ditemukan', 'id' => $row_num], 404);
        }

        // Perbarui status absensi
        $absen->status = $new_status;
        $absen->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
