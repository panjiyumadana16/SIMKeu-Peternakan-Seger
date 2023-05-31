<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Kategori;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $kandang = Kandang::all();
        $kategori = Kategori::all();
        return view('master.stok', compact(['kandang', 'kategori']));
    }

    public function indexData()
    {
        $data = Stok::join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->select('stoks.*', 'kategories.nama_kategori', 'kandangs.kandang')
            ->get();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'kategori_id'   => 'required',
            'kandang_id'    => 'required',
            'tgl_diambil'   => 'required',
            'jml_stok'      => 'required|numeric',
        ]);

        $check = Stok::where('kategori_id', $request->kategori_id)
            ->where('kandang_id', $request->kandang_id)
            ->get();

        if (count($check) > 0) {
            return response()->json([
                'code'      => 500,
                'message'   => 'Data Stok Telur Sudah ada, Silahkan edit Stok Telur dengan Asal dan Kategori yang sama',
            ]);
        } else {
            Stok::create([
                'kategori_id'   => $request->kategori_id,
                'kandang_id'    => $request->kandang_id,
                'tgl_diambil'   => $request->tgl_diambil,
                'jml_stok'      => $request->jml_stok,
            ]);

            return response()->json([
                'code'      => 200,
                'message'   => 'Berhasil menyimpan data Stok Telur',
            ]);
        }
    }

    public function detailData($id)
    {
        $data = Stok::join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->join('kandangs', 'kandangs.id', '=', 'stoks.kandang_id')
            ->select('stoks.*', 'kategories.nama_kategori', 'kandangs.kandang')
            ->where('stoks.id', $id)
            ->first();
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'tgl_diambil'   => 'required',
            'jml_stok'      => 'required|numeric',
        ]);

        Stok::where('id', $id)
            ->update([
                'tgl_diambil'   => $request->tgl_diambil,
                'jml_stok'      => $request->jml_stok,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data Stok Telur',
        ]);
    }

    public function deleteData($id)
    {
        Stok::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data Stok Telur',
        ]);
    }
}
