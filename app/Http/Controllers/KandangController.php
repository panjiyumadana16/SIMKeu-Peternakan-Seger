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
            'kandang'       => 'required',
            'jml_ayam'      => 'required|numeric',
        ]);

        Kandang::create([
            'kandang'       => $request->kandang,
            'jml_ayam'      => $request->jml_ayam,
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil menyimpan data Kandang Ayam',
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
            'kandang'       => 'required',
            'jml_ayam'      => 'required|numeric',
        ]);

        Kandang::where('id', $id)
            ->update([
                'kandang'       => $request->kandang,
                'jml_ayam'      => $request->jml_ayam,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data Kandang Ayam',
        ]);
    }

    public function deleteData($id)
    {
        Kandang::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data Kandang Ayam',
        ]);
    }
}
