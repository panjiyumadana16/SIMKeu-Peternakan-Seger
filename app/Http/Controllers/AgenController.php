<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgenController extends Controller
{
    public function index()
    {
        return view('master.agen');
    }

    public function indexData()
    {
        $data = Agen::join('users', 'users.id', '=', 'agens.user_id')
            ->select('agens.*', 'users.username')
            ->get();
        return response()->json($data);
    }

    public function addData(Request $request)
    {
        $this->validate($request, [
            'username'     => 'required',
            'password'     => 'required',
            'nama'         => 'required',
            'no_hp'        => 'required',
            'kota'         => 'required',
            'alamat'       => 'required',
        ]);

        User::create([
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role_id'   => 2,
        ]);

        $user = User::where('username', $request->username)->first();

        Agen::create([
            'user_id'      => $user->id,
            'nama'         => $request->nama,
            'no_hp'        => $request->no_hp,
            'kota'         => $request->kota,
            'alamat'       => $request->alamat,
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil menyimpan data Agen',
        ]);
    }

    public function detailData($id)
    {
        $data = Agen::where('agens.id', $id)
            ->join('users', 'users.id', '=', 'agens.user_id')
            ->select('agens.*', 'users.username')
            ->first();
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'username'     => 'required',
            'nama'         => 'required',
            'no_hp'        => 'required',
            'kota'         => 'required',
            'alamat'       => 'required',
        ]);

        $agen = Agen::where('id', $id)->first();

        if (is_null($request->password) || $request->password == '') {
            User::where('id', $agen->user_id)->update([
                'username'  => $request->username,
            ]);
        } else {
            User::where('id', $agen->user_id)->update([
                'username'  => $request->username,
                'password'  => Hash::make($request->password),
            ]);
        }

        Agen::where('id', $id)
            ->update([
                'nama'         => $request->nama,
                'no_hp'        => $request->no_hp,
                'kota'         => $request->kota,
                'alamat'       => $request->alamat,
            ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil ubah data Agen',
        ]);
    }

    public function deleteData($id)
    {
        $agen = Agen::where('id', $id)->first();

        Agen::where('id', $id)->delete();
        User::where('id', $agen->user_id)->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil Hapus data Agen',
        ]);
    }
}
