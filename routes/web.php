<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TitipanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\HistoryTitipanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TentangAplikasiController;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\TentangAplikasi;
use App\Models\Titipan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\Absensi; // Gantilah dengan namespace yang sesuai

Route::post('/absensi', function ($request) {
    $absensi = Absensi::find($request->status);
    $absensi->status = $request->status;
    $absensi->save();

    return response()->json(['message' => 'Status berhasil diperbarui']);
});

//route sebelum login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/cek', [LoginController::class, 'cekUserLogin'])->name('cekLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//route sesudah login
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['cekUserLogin:admin,kasir']);
    Route::resource('/pelanggan', PelangganController::class)->middleware(['cekUserLogin:admin,kasir']);
    Route::resource('/transaksi', TransaksiController::class)->middleware(['cekUserLogin:admin,kasir']);
    Route::get('/nota/{noFaktur}', [TransaksiController::class, 'faktur'])->middleware(['cekUserLogin:admin,kasir']);
    Route::resource('/menu', MenuController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/kategori', KategoriController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/meja', MejaController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/stok', StokController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/pemesanan', PemesananController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/titipan', TitipanController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/absensi', AbsensiController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/det_transaksi', DetailTransaksiController::class)->middleware(['cekUserLogin:kasir']);
    Route::resource('/history_titipan', HistoryTitipanController::class)->middleware(['cekUserLogin:admin']);
    Route::resource('/jenis', JenisController::class)->middleware(['cekUserLogin:admin']);
    Route::get('/tentang-aplikasi', [TentangAplikasiController::class, 'index'])->name('tentang-aplikasi');


    //route export import
    Route::get('export/menu', [MenuController::class, 'exportData'])->name('export-menu');
    Route::post('menu/import', [MenuController::class, 'importData'])->name('menu.import');
    Route::get('export-pdf/menu', [MenuController::class, 'exportPDF'])->name('menu-export-pdf');


    Route::get('export/jenis', [JenisController::class, 'exportData'])->name('export-jenis');
    Route::post('jenis/import', [JenisController::class, 'importData'])->name('import-jenis');
    Route::get('export-pdf/jenis', [JenisController::class, 'exportPDF'])->name('jenis-export-pdf');

    Route::get('export/stok', [StokController::class, 'exportData'])->name('export-stok');
    Route::post('stok/import', [StokController::class, 'importData'])->name('import-stok');
    Route::get('export-pdf/stok', [StokController::class, 'exportPDF'])->name('stok-export-pdf');

    Route::get('export/pelanggan', [PelangganController::class, 'exportData'])->name('export-pelanggan');
    Route::post('pelanggan/import', [PelangganController::class, 'importData'])->name('import-pelanggan');
    Route::get('export-pdf/pelanggan', [PelangganController::class, 'exportPDF'])->name('pelanggan-export-pdf');

    Route::get('export/titipan', [TitipanController::class, 'exportData'])->name('export-titipan');
    Route::post('titipan/import', [TitipanController::class, 'importData'])->name('import-titipan');
    Route::get('export-pdf/titipan', [TitipanController::class, 'exportPDF'])->name('titipan-export-pdf');

    Route::get('export/absensi', [AbsensiController::class, 'exportData'])->name('export-absensi');
    Route::post('absensi/import', [AbsensiController::class, 'importData'])->name('import-absensi');
    Route::get('export-pdf/absensi', [AbsensiController::class, 'exportPDF'])->name('absensi-export-pdf');


    Route::get('export/kategori', [KategoriController::class, 'exportData'])->name('export-kategori');
    Route::post('kategori/import', [KategoriController::class, 'importData'])->name('import-kategori');
    Route::get('export-pdf/kategori', [KategoriController::class, 'exportPDF'])->name('kategori-export-pdf');

    Route::get('export/detailTransaksi', [DetailTransaksiController::class, 'exportData'])->name('export-detail_transaksi');
    Route::get('export-pdf/detailTransaksi', [DetailTransaksiController::class, 'exportPDF'])->name('detailTransaksi-export-pdf');

    Route::get('export-pdf/meja', [MejaController::class, 'exportPDF'])->name('meja-export-pdf');
    Route::get('export/meja', [MejaController::class, 'exportData'])->name('export-meja');
    Route::post('meja/import', [MejaController::class, 'importData'])->name('meja-import');

    Route::post('update-status', [AbsensiController::class, 'updateStatus']);
});

// Route::group(['middleware' => ['cekUserLogin:admin']], function () {

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    // Route::get('/nota/{noFaktur}', [TransaksiController::class, 'faktur']);
// });
// });
