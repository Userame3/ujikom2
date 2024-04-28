<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $menu = Menu::get();
        $data['count_menu'] = $menu->count();
        $data['pelanggan'] = Pelanggan::limit(10)->orderBy('created_at', 'desc')->get();
        // $transaksi = Transaksi::get();
        // $data['pendapatan'] = $transaksi->sum();

        return view('dashboard.index
        ')->with($data);
    }
}
