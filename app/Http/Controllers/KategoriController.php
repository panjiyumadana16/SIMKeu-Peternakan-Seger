<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('master.kategori');
    }

    public function indexData()
    {
        $data = Kategori::all();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'nama_kategori'       => 'required',
        ]);

        Kategori::create([
            'nama_kategori'       => $request->nama_kategori,
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil menyimpan data Kategori Produk',
        ]);
    }

    public function detailData($id)
    {
        $data = Kategori::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kategori'       => 'required',
        ]);

        Kategori::where('id', $id)
            ->update([
                'nama_kategori'       => $request->nama_kategori,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data Kategori Produk',
        ]);
    }

    public function deleteData($id)
    {
        Kategori::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data Kategori Produk',
        ]);
    }
}
