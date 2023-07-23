<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use App\Models\DetailTransaksi;
use App\Models\Kandang;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stokTelur = Stok::sum('jml_stok');
        $stokTelur2 = Stok::sum('jml_stok_terjual');
        $stokTelur = $stokTelur - $stokTelur2;
        $kandang = Kandang::all()->count();
        $jmlTransaksi = Transaksi::all()->count();
        $jmlAgen = Agen::all()->count();

        $lastProduk = Produk::join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->select('produks.*', 'kategories.nama_kategori'
            , 'kandangs.kandang', 'stoks.jml_stok'
            , 'stoks.jml_stok_terjual' ,'stoks.tgl_diambil')
            ->latest()->take(5)->get();

        $lastStok = Stok::join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->select('stoks.*', 'kategories.nama_kategori', 'kandangs.kandang')
            ->latest()->take(5)->get();

        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama')->latest()->take(5)->get();
        $lastTransaksi = [];
        $i = 0;
        foreach ($transaksi as $dt) {
            $detail_transaksi = DetailTransaksi::where('transaksi_id', $dt->id)->get();
            $lastTransaksi[$i] = $dt;
            $lastTransaksi[$i]['jumlah_pesanan'] = count($detail_transaksi);
            $i++;
        }

        $labelNoDate = Carbon::now()->lastOfMonth()->day;
        $labelChart = array();
        $dataChart = array();
        for ($d = 1; $d <= $labelNoDate; $d++) {
            $labelChart[] .= $d;

            $chartData = Transaksi::select('*')
                ->whereDay('tgl_transaksi', $d)
                ->whereYear('tgl_transaksi', Carbon::now())
                ->whereMonth('tgl_transaksi', Carbon::now())
                ->get()->count();

            $dataChart[] += $chartData;
        }

        return view('dashboard.index', compact(['stokTelur', 'kandang', 'jmlTransaksi', 'jmlAgen', 'lastProduk', 'lastTransaksi', 'labelChart', 'dataChart', 'lastStok']));
    }

    public function listProduk()
    {
        $data = Produk::join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->select('produks.*', 'kategories.nama_kategori'
            , 'kandangs.kandang', 'stoks.jml_stok'
            , 'stoks.jml_stok_terjual' ,'stoks.tgl_diambil')
            ->where('produks.status' ,'Aktif')
            ->latest()->get();

        return view('transaksi.listproduk', compact(['data']));
    }
}
