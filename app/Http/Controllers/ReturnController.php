<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ReturnTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    function index()
    {
        return view('transaksi.return');
    }

    function indexAgen()
    {
        return view('transaksi.returnagen');
    }

    function insert($id)
    {
        $detail_tr = DetailTransaksi::join('produks', 'produks.id', '=', 'detail_transaksies.produk_id')
            ->join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->where('detail_transaksies.transaksi_id', $id)
            ->select('detail_transaksies.*', 'stoks.jml_stok', 'kategories.nama_kategori', 'produks.nama_produk', 'produks.harga_jual')->get();

        return view('transaksi.formreturn', compact(['detail_tr']));
    }

    function create(Request $request)
    {
        $lengthData = count($request->detail_transaksies_id);
        for ($i = 0; $i < $lengthData; $i++) {
            ReturnTransaksi::create([
                'transaksi_id'          => $request->transaksi_id,
                'detail_transaksies_id' => $request->detail_transaksies_id[$i],
                'jml_return'            => $request->jml_return[$i],
                'total'                 => $request->total,
                'alasan_return'         => $request->alasan_return,
                'status'                => 'Menunggu Konfirmasi'
            ]);
        }

        Transaksi::where('id', $request->transaksi_id)->update([
            'status'    => 'Proses Return',
        ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil membuat permintaan return pesanan!',
        ]);
    }

    public function indexData()
    {
        $returntr = ReturnTransaksi::join('transaksies', 'transaksies.id', '=', 'return_transaksies.transaksi_id')
            ->join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('return_transaksies.*', 'agens.nama')
            ->groupBy('return_transaksies.transaksi_id')->get();
        $data = [];
        $i = 0;
        foreach ($returntr as $dt) {
            $detail_transaksi = ReturnTransaksi::where('transaksi_id', $dt->transaksi_id)->get();
            $data[$i] = $dt;
            $data[$i]['jumlah_return'] = count($detail_transaksi);
            $data[$i]['tgl_return'] = date('Y-m-d H:i:s', strtotime($dt->created_at));
            $i++;
        }

        return response()->json($data);
    }

    public function indexDataAgen()
    {
        $returntr = ReturnTransaksi::join('transaksies', 'transaksies.id', '=', 'return_transaksies.transaksi_id')
            ->join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('return_transaksies.*', 'agens.nama')
            ->groupBy('return_transaksies.transaksi_id')
            ->where('transaksies.user_id', Auth::user()->id)->get();
        $data = [];
        $i = 0;
        foreach ($returntr as $dt) {
            $detail_transaksi = ReturnTransaksi::where('transaksi_id', $dt->transaksi_id)->get();
            $data[$i] = $dt;
            $data[$i]['jumlah_return'] = count($detail_transaksi);
            $data[$i]['tgl_return'] = date('Y-m-d H:i:s', strtotime($dt->created_at));
            $i++;
        }

        return response()->json($data);
    }

    public function detailData($id)
    {
        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama')
            ->where('transaksies.id', $id)->first();

        $detail_tr = ReturnTransaksi::join('detail_transaksies', 'detail_transaksies.id', '=', 'return_transaksies.detail_transaksies_id')
            ->join('produks', 'produks.id', '=', 'detail_transaksies.produk_id')
            ->join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->where('return_transaksies.transaksi_id', $id)
            ->select('return_transaksies.*', 'stoks.jml_stok', 'kategories.nama_kategori', 'produks.nama_produk', 'produks.harga_jual')->get();

        return response()->json([
            'transaksi' => $transaksi,
            'detail_transaksi'  => $detail_tr
        ]);
    }

    public function changeStatus($id, $to_status)
    {
        //0 = menunggu konfirmasi ,1 = belum dibayar ,2 = proses pengiriman / pengambilan, 3 = selesai
        if ($to_status == 1) {
            ReturnTransaksi::where('transaksi_id', $id)->update([
                'status' => 'Disetujui'
            ]);

            Transaksi::where('id', $id)->update([
                'status' => 'Selesai (Return)'
            ]);
        }
        if ($to_status == 2) {
            ReturnTransaksi::where('transaksi_id', $id)->update([
                'status' => 'Ditolak'
            ]);

            Transaksi::where('id', $id)->update([
                'status' => 'Selesai (Return)'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil Merubah Status Pesanan!',
        ]);
    }
}
