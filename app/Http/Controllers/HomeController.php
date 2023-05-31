<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function listProduk()
    {
        $data = Produk::join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->select('produks.*', 'kategories.nama_kategori', 'kandangs.kandang', 'stoks.jml_stok')
            ->get();

        return view('transaksi.listproduk', compact(['data', 'data']));
    }
}
