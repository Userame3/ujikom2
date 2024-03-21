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
            $data['menu'] = DB::table('menus')
                ->join('kategoris', 'menus.kategori_id', '=', 'kategoris.id')
                ->select('menus.*', 'kategoris.nama_kategori', 'kategoris.id as idKategori')->orderBy('created_at', 'DESC')->get();;
            $kategori = Kategori::get();
            return view('Menu.index', [
                'page' => 'menu',
                'section' => 'Kelola data',
            ], compact('kategori'))->with($data);
        } catch (QueryException | Exception | PDOException $error) {
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
        $image = $request->file('image');
        $filename = date('Y-m-d') . $image->getClientOriginalName();
        $path = 'menu-image/' . $filename;
        Storage::disk('public')->put($path, file_get_contents($image));

        $data['kategori_id'] = $request->kategori_id;
        $data['nama_menu'] = $request->nama_menu;
        $data['harga'] = $request->harga;
        $data['stok'] = $request->stok;
        $data['image'] = $filename;
        $data['deskripsi'] = $request->deskripsi;

        Menu::create($data);
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
        if ($request->file('image')) {
            if ($request->old_image) {
                Storage::disk('public')->delete('menu-image/' . $request->old_image);
            }

            $image = $request->file('image');
            $filename = date('Y-m-d') . $image->getClientOriginalName();
            $path = 'menu-image/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($image));

            $data['image'] = $filename;
        } else {
            $data['image'] = $menu->image;
        }

        $data['kategori_id'] = $request->kategori_id;
        $data['nama_menu'] = $request->nama_menu;
        $data['harga'] = $request->harga;
        $data['stok'] = $request->stok;
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
            $data = Excel::toArray(new MenuImport, request()->file('import'));
            foreach ($data as $d) {
                Menu::create([
                    'kategori_id' => $d[0]['jenis_id'],
                    'nama_menu' => $d[0]['menu'],
                    'harga' => $d[0]['harga'],
                    'stok' => $d[0]['stok'],
                    'image' => $d[0]['image'],
                    'deskripsi' => $d[0]['deskripsi']
                ]);
            }
            return redirect()->back()->with('success', 'Import data menu berhasil');
        } catch (Exception $e) {
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
