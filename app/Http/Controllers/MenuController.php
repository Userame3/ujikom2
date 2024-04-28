<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Jenis;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Exception;
use PDOException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MenuExport;
use App\Imports\MenuImport;
use App\Models\Kategori;
use App\Models\Stok;
use App\Models\Titipan;
use Dompdf\Dompdf;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['menu'] = Menu::all();
            // $data['menu'] = DB::table('menus')
            //     ->join('kategoris', 'menus.kategori_id', '=', 'kategoris.id')
            //     ->join('stoks', 'menus.stok_id', '=', 'stoks.id')
            //     ->select('menus.*', 'kategoris.nama_kategori', 'kategoris.id as idKategori', 'stoks.jumlah as stok')->orderBy('created_at', 'DESC')->get();
            $jenis = Jenis::get();
            return view('Menu.index', [
                'page' => 'menu',
                'section' => 'Kelola data',
            ], compact('jenis'))->with($data);
        } catch (QueryException | Exception | PDOException $error) {
            return $error->getMessage();
            $this->failResponse($error->getCode());
        }

        // try {
        //     $data['menu'] = menu::orderBy('created_at', 'DESC')->get();
        //     $jenis = Jenis::get();
        //     return view('Menu.index', compact('jenis'))->with($data);
        // } catch (QueryException | Exception | PDOException $error) {
        //     $this->failResponse($error->getCode());
        // }
    }

    public function store(StoreMenuRequest $request)
    {
        $images = $request->file('images');
        $filename = date('Y-m-d') . $images->getClientOriginalName();
        $path = 'menu-images/' . $filename;
        Storage::disk('public')->put($path, file_get_contents($images));

        $stok = Stok::create(['jumlah' => 0]);

        $data['kategori_id'] = $request->kategori_id;
        $data['nama_menu'] = $request->nama_menu;
        $data['harga'] = $request->harga;
        $data['images'] = $filename;
        $data['deskripsi'] = $request->deskripsi;
        $data['stok_id'] = $stok->id;
        $menu = Menu::create($data);

        return redirect('menu')->with('succes', 'data menu berhasil ditambahkan');


        // try {
        //     DB::beginTransaction();
        //     menu::create($request->all());
        //     DB::commit();
        //     return redirect('menu')->with('success', 'menu berhasil ditambahkan!');
        // } catch (QueryException | Exception | PDOException $error) {
        //     DB::rollBack();
        //     $this->failResponse($error->getMessage(), $error->getCode());
        // }
    }

    public function update(StoreMenuRequest $request, menu $menu)
    {
        if ($request->file('images')) {
            if ($request->old_image) {
                Storage::disk('public')->delete('menu-images/' . $request->old_image);
            }

            $images = $request->file('images');
            $filename = date('Y-m-d') . $images->getClientOriginalName();
            $path = 'menu-images/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($images));

            $data['images'] = $filename;
        } else {
            $data['images'] = $menu->images;
        }

        $data['kategori_id'] = $request->kategori_id;
        $data['nama_menu'] = $request->nama_menu;
        $data['harga'] = $request->harga;
        $stok = Stok::find($menu->stok_id);
        if ($stok) {
            $stok->jumlah = $request->stok ?? 0;
            $stok->save();
        } else {
            $newStok = Stok::create(['jumlah' => $request->stok ?? 0]);
            $menu->stok_id = $newStok->id;
            $menu->save();
        }
        $data['deskripsi'] = $request->deskripsi;

        $menu->update($data);
        return redirect('menu')->with('succes', 'data menu berhasil di edit.');

        // try {
        //     DB::beginTransaction();
        //     $menu->update($request->all());
        //     DB::commit();
        //     return redirect('menu')->with('success', 'menu berhasil diupdate!');
        // } catch (QueryException | Exception | PDOException $error) {
        //     DB::rollBack();
        //     $this->failResponse($error->getMessage(), $error->getCode());
        // }
    }

    public function destroy(menu $menu)
    {
        try {
            DB::beginTransaction();
            $menu->delete();
            DB::commit();
            return redirect('menu')->with('success', 'menu berhasil dihapus!');
        } catch (QueryException | Exception | PDOException $error) {
            DB::rollBack();
            return "Terjadi kesalahan :(" . $error->getMessage();
        }
    }

    public function exportData()
    {
        $date = date('Y-m-d');
        return Excel::download(new MenuExport, $date . '_menu.xlsx');
    }

    public function importData()
    {
        try {
            Excel::import(new MenuImport, request()->file('import'));
            return redirect()->back()->with('success', 'Import data menu berhasil');
        } catch (Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with('error', 'Gagal mengimpor data menu: ' . $e->getMessage());
        }
    }
    public function exportPDF()
    {
        // Ambil data yang akan diekspor (contoh: dari database)
        $data = Menu::all();

        // Render data ke dalam tampilan HTML
        $html = view('menu.pdf', compact('data'))->render();
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
}
