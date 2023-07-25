<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use App\Models\OngkirKota;
use App\Models\Produk;
use App\Models\TempPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempPesananController extends Controller
{
    public function index()
    {
        $keranjang = TempPesanan::join('produks', 'produks.id', '=', 'temp_pesanans.produk_id')
            ->join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->where('temp_pesanans.user_id', Auth::user()->id)
            ->select('temp_pesanans.*', 'stoks.jml_stok', 'stoks.jml_stok_terjual', 'kategories.nama_kategori', 'produks.nama_produk', 'produks.harga_jual')->get();
        $kota = OngkirKota::all();
        $agen = Agen::where('user_id', Auth::user()->id)->first();

        return view('transaksi.keranjang', compact(['keranjang', 'agen','kota']));
    }

    public function addKeranjang(Request $request)
    {
        $check = TempPesanan::where('user_id', $request->user_id)
            ->where('produk_id', $request->produk_id)->get();

        if (count($check) > 0) {
            return response()->json([
                'code'      => 400,
                'message'   => 'Produk sudah ada di keranjang anda!',
            ]);
        } else {
            TempPesanan::create([
                'user_id'   => $request->user_id,
                'produk_id' => $request->produk_id,
                'jumlah'    => 0,
                'subtotal'  => 0,
            ]);

            return response()->json([
                'code'      => 200,
                'message'   => 'Berhasil Menambahkan Produk ke keranjang!',
            ]);
        }
    }

    public function updateJumlah(Request $request)
    {
        $tempProduk = TempPesanan::where('id', $request->id)->first();

        $produk = Produk::where('id', $tempProduk->produk_id)->first();

        $sub_total = $request->jumlah * $produk->harga_jual;

        TempPesanan::where('id', $request->id)->update([
            'jumlah'        => $request->jumlah,
            'subtotal'      => $sub_total
        ]);

        return response()->json([
            'code'      => 200,
            'sub_total' => $sub_total
        ]);
    }

    public function deleteData($id)
    {
        TempPesanan::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus Produk dari keranjang!',
        ]);
    }

    public function totalPesanan()
    {
        $temp = TempPesanan::where('user_id', Auth::user()->id)->get();
        $total = 0;
        foreach ($temp as $data) {
            $total = $total + $data->subtotal;
        }

        return response()->json([
            'code'      => 200,
            'total'     => $total
        ]);
    }
}
