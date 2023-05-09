<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $kandang = Kandang::all();
        $kategori = Kategori::all();
        return view('master.produk', compact(['kandang', 'kategori']));
    }

    public function indexData()
    {
        $data = Produk::join('kategories', 'kategories.id', '=', 'produks.kategori_id')
            ->join('kandangs', 'kandangs.id', '=', 'produks.kandang_id')
            ->select('produks.*', 'kategories.nama_kategori', 'kandangs.kandang', 'kandangs.stok')
            ->get();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'nama_produk'  => 'required',
            'kategori_id'  => 'required',
            'harga_jual'   => 'required|numeric',
            'kandang_id'   => 'required',
        ]);

        Produk::create([
            'nama_produk'  => $request->nama_produk,
            'kategori_id'  => $request->kategori_id,
            'harga_jual'   => $request->harga_jual,
            'kandang_id'   => $request->kandang_id,
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil menyimpan data Produk',
        ]);
    }

    public function detailData($id)
    {
        $data = Produk::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'nama_produk'  => 'required',
            'kategori_id'  => 'required',
            'harga_jual'   => 'required|numeric',
            'kandang_id'   => 'required',
        ]);

        Produk::where('id', $id)
            ->update([
                'nama_produk'  => $request->nama_produk,
                'kategori_id'  => $request->kategori_id,
                'harga_jual'   => $request->harga_jual,
                'kandang_id'   => $request->kandang_id,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data Produk',
        ]);
    }

    public function deleteData($id)
    {
        Produk::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data Produk',
        ]);
    }
}
