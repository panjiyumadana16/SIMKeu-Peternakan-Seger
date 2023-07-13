<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Stok;
use App\Models\TempPesanan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function addData(Request $request)
    {
        $keranjang = TempPesanan::where('user_id', Auth::user()->id)->get();
        if (count($keranjang) < 1) {
            return response()->json([
                'code'      => 400,
                'message'   => 'Keranjang Belanjaan anda kosong!',
            ]);
        }

        $this->validate($request, [
            'jenis_pengiriman'  => 'required',
            'alamat_pengiriman' => 'required',
        ]);

        $ongkir = 0;
        if ($request->jenis_pengiriman == 'Kirim ke Alamat Pengiriman') {
            $ongkir = 10000;
        }

        Transaksi::create([
            'user_id'           => Auth::user()->id,
            'tgl_transaksi'     => Carbon::now(),
            'jenis_pengiriman'  => $request->jenis_pengiriman,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'ongkir'            => $ongkir,
            'total'             => 0,
        ]);

        $get_last_tr = Transaksi::where('user_id', Auth::user()->id)->latest()->first();
        $total = 0;

        foreach ($keranjang as $data) {
            DetailTransaksi::create([
                'transaksi_id'      => $get_last_tr->id,
                'produk_id'         => $data->produk_id,
                'jumlah_produk'     => $data->jumlah,
                'sub_total_harga'   => $data->subtotal,
            ]);
            $total = $total + $data->subtotal;
        }

        Transaksi::where('id', $get_last_tr->id)->update([
            'total' => $total + $get_last_tr->ongkir,
        ]);

        TempPesanan::where('user_id', Auth::user()->id)->delete();

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil melakukan checkout pesanan, silahkan menunggu konfirmasi dari penjual!',
        ]);
    }

    public function indexAgen()
    {
        return view('transaksi.pesananagen');
    }

    public function indexDataAgen()
    {
        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama')
            ->where('transaksies.user_id', Auth::user()->id)->get();
        $data = [];
        $i = 0;
        foreach ($transaksi as $dt) {
            $detail_transaksi = DetailTransaksi::where('transaksi_id', $dt->id)->get();
            $data[$i] = $dt;
            $data[$i]['jumlah_pesanan'] = count($detail_transaksi);
            $i++;
        }

        return response()->json($data);
    }

    public function detailData($id)
    {
        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama')
            ->where('transaksies.id', $id)->first();

        $detail_tr = DetailTransaksi::join('produks', 'produks.id', '=', 'detail_transaksies.produk_id')
            ->join('stoks', 'stoks.id', '=', 'produks.stok_id')
            ->join('kategories', 'kategories.id', '=', 'stoks.kategori_id')
            ->where('detail_transaksies.transaksi_id', $id)
            ->select('detail_transaksies.*', 'stoks.jml_stok', 'kategories.nama_kategori', 'produks.nama_produk', 'produks.harga_jual')->get();

        return response()->json([
            'transaksi' => $transaksi,
            'detail_transaksi'  => $detail_tr
        ]);
    }

    public function index()
    {
        return view('transaksi.pesanan');
    }

    public function indexPenjualan()
    {
        return view('transaksi.penjualan');
    }

    public function indexData()
    {
        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama')->get();
        $data = [];
        $i = 0;
        foreach ($transaksi as $dt) {
            if ($dt->status != 'Selesai' && $dt->status != 'Selesai (Return)') {
                $detail_transaksi = DetailTransaksi::where('transaksi_id', $dt->id)->get();
                $data[$i] = $dt;
                $data[$i]['jumlah_pesanan'] = count($detail_transaksi);
                $i++;
            }
        }

        return response()->json($data);
    }

    public function indexDataPenjualan()
    {
        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama')->where('transaksies.status', 'like', '%Selesai%')->get();
        $data = [];
        $i = 0;
        foreach ($transaksi as $dt) {
            $detail_transaksi = DetailTransaksi::where('transaksi_id', $dt->id)->get();
            $data[$i] = $dt;
            $data[$i]['jumlah_pesanan'] = count($detail_transaksi);
            $i++;
        }

        return response()->json($data);
    }

    public function changeStatus($id, $to_status)
    {
        //0 = menunggu konfirmasi ,1 = belum dibayar ,2 = proses pengiriman / pengambilan, 3 = selesai
        if ($to_status == 1) {
            Transaksi::where('id', $id)->update([
                'status' => 'Belum Dibayar'
            ]);
        }
        if ($to_status == 2) {

            $detail_tr = DetailTransaksi::join('produks', 'produks.id', '=', 'detail_transaksies.produk_id')
                ->join('stoks', 'stoks.id', '=', 'produks.stok_id')
                ->where('detail_transaksies.transaksi_id', $id)
                ->select('detail_transaksies.*', 'stoks.jml_stok', 'produks.stok_id')->get();
            foreach ($detail_tr as $dt) {
                Stok::where('id', $dt->stok_id)->update([
                    'jml_stok' => $dt->jml_stok - $dt->jumlah_produk
                ]);
            }

            Transaksi::where('id', $id)->update([
                'status' => 'Proses Pengiriman / Pengambilan'
            ]);
        }
        if ($to_status == 3) {
            Transaksi::where('id', $id)->update([
                'status' => 'Selesai'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil Merubah Status Pesanan!',
        ]);
    }

    function bayarPesanan($id)
    {
        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
            ->select('transaksies.*', 'agens.nama', 'agens.no_hp')
            ->where('transaksies.id', $id)->first();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->id,
                'gross_amount' => $transaksi->total,
            ),
            'customer_details' => array(
                'first_name' => $transaksi->nama,
                'phone' => $transaksi->no_hp,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'code'      => 200,
            'snapToken' => $snapToken,
        ]);
    }
}
