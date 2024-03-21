<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\DetailTransaksi;
use App\Models\Jenis;
use App\Models\Menu;
use App\Models\Titipan;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDOException;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenis'] = Jenis::with(['menu'])->get();
        return view('transaksi.index')->with($data);
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
     * @param  \App\Http\Requests\StoreTransaksiRequest  $request
     */
    public function store(StoreTransaksiRequest $request)
    {
        try {
            DB::beginTransaction();
            $last_id = Transaksi::where('tanggal', date('Y-m-d'))->orderBy('created_at', 'desc')->select('id')->first();
            $noTrans = $last_id == null ? date('Ymd') . '0001' : date('Ymd') . sprintf('%04d', substr($last_id->id, 8, 4) + 1);
            $insertTransaksi = Transaksi::create([
                'id_pelanggan' => $request->id_pelanggan,
                'id' => $noTrans,
                'tanggal' => date('Y-m-d'),
                'total_harga' => $request->total,
                'metode_pembayaran' => "cash",
                'keterangan' => '',
            ]);

            if (!$insertTransaksi->exists) return 'error';

            // Memproses menu yang dipesan
            foreach ($request->orderedList as $detail) {
                $menu = Menu::find($detail['menu_id']);
                $menu->stok = $menu->stok - $detail['qty'];
                $menu->save();

                DetailTransaksi::create([
                    'id_transaksi' => $noTrans,
                    'id_menu' => $detail['menu_id'],
                    'jumlah' => $detail['qty'],
                    'subtotal' => $detail['harga'] * $detail['qty'],
                ]);
            }

            // // Memproses titipan
            // foreach ($request->titipanList as $titipan) {
            //     // Ambil data produk titipan dari database
            //     $produkTitipan = Titipan::find($titipan['produk_id']);

            //     // Kurangi stok produk titipan
            //     $produkTitipan->stok = $produkTitipan->stok - $titipan['qty'];
            //     $produkTitipan->save();

            //     // Buat detail transaksi untuk produk titipan
            //     DetailTransaksi::create([
            //         'id_transaksi' => $noTrans,
            //         'id_produk_titipan' => $titipan['produk_id'],
            //         'jumlah' => $titipan['qty'],
            //         'subtotal' => $produkTitipan->harga * $titipan['qty'],
            //     ]);
            // }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Pemesanan Berhasil!', 'nota' => $noTrans]);
        } catch (Exception | QueryException | PDOException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Pemesanan Gagal', 'error' => $e->getMessage()]);
        }
    }
}
