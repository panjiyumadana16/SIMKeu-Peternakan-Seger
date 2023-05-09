<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    public function index()
    {
        return view('master.kandang');
    }

    public function indexData()
    {
        $data = Kandang::all();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'jenis_produk'  => 'required',
            'kandang'       => 'required',
            'tgl_diambil'   => 'required',
            'stok'          => 'required|numeric',
        ]);

        Kandang::create([
            'jenis_produk'  => $request->jenis_produk,
            'kandang'       => $request->kandang,
            'tgl_diambil'   => $request->tgl_diambil,
            'stok'          => $request->stok,
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil menyimpan data stok kandang',
        ]);
    }

    public function detailData($id)
    {
        $data = Kandang::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'jenis_produk'  => 'required',
            'kandang'       => 'required',
            'tgl_diambil'   => 'required',
            'stok'          => 'required|numeric',
        ]);

        Kandang::where('id', $id)
            ->update([
                'jenis_produk'  => $request->jenis_produk,
                'kandang'       => $request->kandang,
                'tgl_diambil'   => $request->tgl_diambil,
                'stok'          => $request->stok,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data stok kandang',
        ]);
    }

    public function deleteData($id)
    {
        Kandang::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data stok kandang',
        ]);
    }
}
