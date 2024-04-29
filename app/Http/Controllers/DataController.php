<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Jenis;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Stok;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class DataController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil 5 data menu dengan stok terendah
        $stock = Stok::get();
        $data['sisaStok'] = $stock->sum('jumlah');
        $data['stok'] = Stok::limit(5)->orderBy('jumlah', 'asc')->get();
        $data['laris'] = Stok::limit(5)->orderBy('jumlah', 'desc')->get();


        //Mengambil data Menu
        $menu = Menu::get();
        $data['menu'] = Menu::get();
        $data['count_menu'] = $menu->count();

        //Mengambil data Jenis
        $jenis = Jenis::get();
        $data['count_jenis'] = $jenis->count();

        //Mengambil data Pelanggan
        $pelanggan = Pelanggan::get();
        $data['count_pelanggan'] = $pelanggan->count();

        //Mengambil data Transaksi
        $transaksi = Transaksi::get();
        $data['pendapatan'] = $transaksi->sum('total_harga');
        $data['count_transaksi'] = $transaksi->count();

        $today = Carbon::today();
        $data['count_transaksi_today'] = DB::table('transaksis')
            ->whereDate('tanggal', $today)
            ->count();
        // $data['data_penjualan'] =
        $data['pelanggan'] = Pelanggan::limit(5)->orderBy('created_at', 'desc')->get();

        return view('dashboard.index
        ')->with($data);
    }


    public function data_penjualan($lastCount)
    {
        $data = 0;
        if ($lastCount == 0) {

            $data = Transaksi::select(
                'tanggal',
                DB::raw('SUM(total_harga) as total_bayar'),
                DB::raw('COUNT(id) as jumlah')
            )
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'asc')
                ->get();
        } else {
            $data = Transaksi::select(
                'tanggal',
                DB::raw('SUM(total_harga) as total_bayar'),
                DB::raw('COUNT(id) as jumlah')
            )
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'asc')
                ->skip($lastCount - 1)
                ->limit(264187365)
                ->get();
        }
        return response($data);
    }
}
