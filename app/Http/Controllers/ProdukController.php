<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $stok = Stok::join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->select('stoks.*', 'kategories.nama_kategori', 'kandangs.kandang')
            ->get();
        return view('master.produk', compact(['stok', 'stok']));
    }

    public function indexData()
    {
        $data = Produk::join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->select('produks.*', 'kategories.nama_kategori', 'kandangs.kandang', 'stoks.jml_stok', 'stoks.jml_stok_terjual', 'stoks.tgl_diambil')
            ->get();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'nama_produk'  => 'required',
            'stok_id'      => 'required',
            'harga_jual'   => 'required|numeric',
        ]);

        $check = Produk::where('stok_id', $request->stok_id)->get()->count();
        if ($check < 1) {
            Produk::create([
                'nama_produk'  => $request->nama_produk,
                'stok_id'      => $request->stok_id,
                'harga_jual'   => $request->harga_jual,
            ]);
            
            return response()->json([
                'code'      => 200,
                'message'   => 'Berhasil menyimpan data Produk',
            ]);

        } else {
            return response()->json([
                'code'      => 500,
                'message'   => 'Stok Produk Sudah Ditambahkan',
            ]);
            
        }
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
            'stok_id'      => 'required',
            'harga_jual'   => 'required|numeric',
        ]);

        Produk::where('id', $id)
            ->update([
                'nama_produk'  => $request->nama_produk,
                'stok_id'      => $request->stok_id,
                'harga_jual'   => $request->harga_jual,
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

    public function changeStatus($id) {
        $check = Produk::where('id', $id);
        $checkStatus = $check->first();
        if($checkStatus->status == 'Aktif'){
            $check->update([
                'status' => 'Tidak Aktif',
            ]);
        } else {
            $check->update([
                'status' => 'Aktif',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil ubah Status Produk',
        ]);
    }
}
