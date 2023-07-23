<?php

namespace App\Http\Controllers;

use App\Models\OngkirKota;
use Illuminate\Http\Request;

class OngkirKotaController extends Controller
{
    public function index()
    {
        return view('master.ongkir-kota');
    }

    public function indexData()
    {
        $data = OngkirKota::all();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'nama_kota'     => 'required',
            'biaya_ongkir'  => 'required'  
        ]);

        OngkirKota::create([
            'nama_kota'     => $request->nama_kota,
            'biaya_ongkir'  => $request->biaya_ongkir,
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil menyimpan data Ongkir Kota',
        ]);
    }

    public function detailData($id)
    {
        $data = OngkirKota::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kota'     => 'required',
            'biaya_ongkir'  => 'required'  
        ]);

        OngkirKota::where('id', $id)
            ->update([
                'nama_kota'     => $request->nama_kota,
                'biaya_ongkir'  => $request->biaya_ongkir,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data Ongkir Kota',
        ]);
    }

    public function deleteData($id)
    {
        OngkirKota::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data Ongkir Kota',
        ]);
    }
}
