<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Http\Controllers\Model;
use App\Models\HistoryTitipan;
use App\Models\Titipan;
use App\Models\Menu;
use App\Models\Pelanggan;

class PDFController extends Controller
{

    public function exportPDF()
    {
        // Ambil data yang akan diekspor (contoh: dari database)
        $data = Titipan::all();
        $data = Menu::all();

        // Render data ke dalam tampilan HTML
        $html = view('titipan.pdf', compact('data'))->render();
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
