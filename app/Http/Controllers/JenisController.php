<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Http\Requests\StoreJenisRequest;
use App\Http\Requests\UpdateJenisRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use PDOException;
use App\Exports\JenisExport;
use App\Imports\JenisImport;
use Maatwebsite\Excel\Facades\Excel;


class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // try {
        $data['jenis'] = Jenis::orderBy('created_at', 'DESC')->get();
        return view('jenis.index')->with($data);
        // } catch (QueryException | Exception | PDOException $error) {
        //     $this->failResponse($error->getCode());
        // }
    }

    public function store(StoreJenisRequest $request)
    {
        try {
            DB::beginTransaction();
            Jenis::create($request->all());
            DB::commit();
            return redirect('jenis')->with('success', 'Jenis berhasil ditambahkan!');
        } catch (QueryException | Exception | PDOException $error) {
            DB::rollBack();
            $this->failResponse($error->getMessage(), $error->getCode());
        }
    }

    public function update(StoreJenisRequest $request, Jenis $jeni)
    {
        try {
            DB::beginTransaction();
            $jeni->update($request->all());
            DB::commit();
            return redirect('jenis')->with('success', 'Jenis berhasil diupdate!');
        } catch (QueryException | Exception | PDOException $error) {
            DB::rollBack();
            $this->failResponse($error->getMessage(), $error->getCode());
        }
    }

    public function destroy(Jenis $jeni)
    {
        try {
            DB::beginTransaction();
            $jeni->delete();
            DB::commit();
            return redirect('jenis')->with('success', 'Jenis berhasil dihapus!');
        } catch (QueryException | Exception | PDOException $error) {
            DB::rollBack();
            return "Terjadi kesalahan :(" . $error->getMessage();
        }
    }

    public function exportData()
    {
        $date = date('Y-m-d');
        return Excel::download(new JenisExport, $date . '_Jenis.xlsx');
    }

    public function importData()
    {
        Excel::import(new JenisImport, request()->file('import'));

        return redirect(request()->segment(1) . '/jenis')->with('succes', 'Import data Jenis berhasil');
    }
}
