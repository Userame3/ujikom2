<?php

namespace App\Http\Controllers;

use App\Models\Titipan;
use App\Models\Jenis;
use App\Http\Requests\StoreTitipanRequest;
use App\Http\Requests\UpdateTitipanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Exception;
use PDOException;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TitipanExport;
use App\Imports\TitipanImport;

class TitipanController extends Controller
{
    public function index()
    {
        try {
            $data['titipan'] = DB::table('titipans')
                ->join('jenis', 'titipans.jenis_id', '=', 'jenis.id')
                ->select('Titipans.*', 'jenis.nama_jenis', 'jenis.id as idJenis')->orderBy('created_at', 'DESC')->get();
            $jenis = Jenis::get();
            return view('titipan.index', [
                'page' => 'Titipan',
                'section' => 'Kelola data',
            ], compact('jenis'))->with($data);
        } catch (QueryException | Exception | PDOException $error) {
            $this->failResponse($error->getCode());
        }
    }

    public function store(StoreTitipanRequest $request)
    {
        $data['jenis_id'] = $request->jenis_id;
        $data['nama_produk'] = $request->nama_produk;
        $data['nama_supplier'] = $request->nama_supplier;
        $data['harga_beli'] = $request->harga_beli;
        $data['harga_jual'] = $request->harga_jual;
        $data['stok'] = $request->stok;

        Titipan::create($data);
        return redirect('titipan')->with('succes', 'Data Titipan berhasil ditambahkan');
    }



    public function update(UpdateTitipanRequest $request, Titipan $titipan)
    {
        
        $data['jenis_id'] = $request->jenis_id;
        $data['nama_produk'] = $request->nama_produk;
        $data['nama_supplier'] = $request->nama_supplier;
        $data['harga_beli'] = $request->harga_beli;
        $data['harga_jual'] = $request->harga_jual;
        $data['stok'] = $request->stok;
        $titipan->update($data);
        return redirect('titipan')->with('succes', 'Data Titipan berhasil di edit.');
    }

    public function destroy(titipan $titipan)
    {
        try {
            DB::beginTransaction();
            $titipan->delete();
            DB::commit();
            return redirect('titipan')->with('success', 'Data Titipan berhasil dihapus!');
        } catch (QueryException | Exception | PDOException $error) {
            DB::rollBack();
            return "Terjadi kesalahan: " . $error->getMessage();
        }
    }

    public function exportData()
    {
        $date = date('Y-m-d');
        return Excel::download(new TitipanExport, $date . '_Titipan.xlsx');
    }

    public function importData()
    {
        Excel::import(new TitipanImport, request()->file('import'));
        return redirect('titipan')->with('success', 'Import data Titipan berhasil');
    }
}
