<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ReturnTransaksi;
use App\Models\Stok;
use App\Models\TempPesanan;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $jml_pesanan = 0;
        foreach ($keranjang as $dt) {
            $jml_pesanan = $jml_pesanan + $dt->jumlah;
        }

        if ($jml_pesanan < 10 && $request->jenis_pengiriman == 'Kirim ke Alamat Pengiriman') {
            return response()->json([
                'code'      => 400,
                'message'   => 'Minimal 10kg total pesanan untuk jenis pengiriman "Kirim ke Alamat Pengiriman"!',
            ]);
        }

        $this->validate($request, [
            'jenis_pengiriman'  => 'required',
            'kota'              => 'required',
            'ongkir'            => 'required',
            'alamat_pengiriman' => 'required',
        ]);

        $ongkir = 0;
        if ($request->jenis_pengiriman == 'Kirim ke Alamat Pengiriman') {
            $ongkir = $request->ongkir;
        }

        Transaksi::create([
            'user_id'           => Auth::user()->id,
            'tgl_transaksi'     => Carbon::now(),
            'jenis_pengiriman'  => $request->jenis_pengiriman,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'ongkir_kota_id'    => $request->kota,
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
        ->join('ongkir_kotas','ongkir_kotas.id','=','transaksies.ongkir_kota_id')
        ->select('transaksies.*', 'agens.nama','ongkir_kotas.nama_kota')
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
            ->join('ongkir_kotas','ongkir_kotas.id','=','transaksies.ongkir_kota_id')
            ->select('transaksies.*', 'agens.nama','ongkir_kotas.nama_kota')
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
        ->join('ongkir_kotas','ongkir_kotas.id','=','transaksies.ongkir_kota_id')
        ->select('transaksies.*', 'agens.nama','ongkir_kotas.nama_kota')
        ->get();
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
        ->join('ongkir_kotas','ongkir_kotas.id','=','transaksies.ongkir_kota_id')
        ->select('transaksies.*', 'agens.nama','ongkir_kotas.nama_kota')
        ->where('transaksies.status', 'like', '%Selesai%')->get();
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
                ->select('detail_transaksies.*', 'stoks.jml_stok','stoks.jml_stok_terjual', 'produks.stok_id')->get();
            foreach ($detail_tr as $dt) {
                Stok::where('id', $dt->stok_id)->update([
                    'jml_stok_terjual' => $dt->jml_stok_terjual + $dt->jumlah_produk
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

    public function laporanView() {
        return view('laporan.index');
    }

    public function laporanPendapatan(Request $request) {
        $tgl_awal_a = '';
        $tgl_akhir_a = '';
        if ($request->tgl_awal == '' || $request->tgl_akhir == '') {
            return response()->json([
                'code'      => 400,
                'message'   => 'Tanggal Belum ditentukan!',
            ]);
        } else {
            $tgl_awal_a = $request->tgl_awal . ' 00:00:01';
            $tgl_akhir_a = $request->tgl_akhir . ' 23:59:59';
        }

        if ($request->tgl_awal > $request->tgl_akhir) {
            return response()->json([
                'code'      => 400,
                'message'   => 'Tanggal tidak valid!',
            ]);
        }

        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
        ->join('ongkir_kotas','ongkir_kotas.id','=','transaksies.ongkir_kota_id')
        ->select('transaksies.*', 'agens.nama','ongkir_kotas.nama_kota')
        ->whereBetween('transaksies.tgl_transaksi', [$tgl_awal_a, $tgl_akhir_a])
        ->where('transaksies.status','LIKE','%Selesai%')
        ->get();

        $data = [];
        $no = 0;
        foreach ($transaksi as $val) {
            if ($val->status == 'Selesai') {
                $data[$no] = $val;
            } else {
                $get_return = ReturnTransaksi::where('transaksi_id',$val->id)->first();
                $data[$no] = $val;
                $data[$no]['return_total'] = $get_return->total;
                $data[$no]['total'] = $val->total - $get_return->total;
            }
            $no = $no + 1;
        }

        return response()->json($data);
    }

    public function laporanPendapatanPrintCheck(Request $request) {
        if ($request->tgl_awal == '' || $request->tgl_akhir == '') {
            return response()->json([
                'code'      => 400,
                'message'   => 'Tanggal Belum ditentukan!',
            ]);
        }

        if ($request->tgl_awal > $request->tgl_akhir) {
            return response()->json([
                'code'      => 400,
                'message'   => 'Tanggal tidak valid!',
            ]);
        }

        return response()->json([
            'code'      => 200,
            'message'   => 'Proses Generate PDF!',
        ]);
    }

    public function laporanPendapatanPrint($start, $end){

        $tgl_awal_a = $start . ' 00:00:01';
        $tgl_akhir_a = $end . ' 23:59:59';

        $tgl_awal = $start;
        $tgl_akhir = $end;

        $transaksi = Transaksi::join('agens', 'agens.user_id', '=', 'transaksies.user_id')
        ->join('ongkir_kotas','ongkir_kotas.id','=','transaksies.ongkir_kota_id')
        ->select('transaksies.*', 'agens.nama','ongkir_kotas.nama_kota')
        ->whereBetween('transaksies.tgl_transaksi', [$tgl_awal_a, $tgl_akhir_a])
        ->where('transaksies.status','LIKE','%Selesai%')
        ->get();

        $data = [];
        $no = 0;
        $total_pendapatan = 0;
        foreach ($transaksi as $val) {
            if ($val->status == 'Selesai') {
                $data[$no] = $val;
            } else {
                $get_return = ReturnTransaksi::where('transaksi_id',$val->id)->first();
                $data[$no] = $val;
                $data[$no]['return_total'] = $get_return->total;
                $data[$no]['total'] = $val->total - $get_return->total;
            }
            $total_pendapatan = $total_pendapatan + $data[$no]['total'];
            $no = $no + 1;
        }

        $pdf = Pdf::loadView('laporan.pdf.index', compact(['data', 'tgl_awal', 'tgl_akhir','total_pendapatan']));
        $pdf->setPaper('A4','potrait');
        return $pdf->stream('Cetak Laporan Pendapatan - '.date('Y-m-d H:i:s').'.pdf');
    }
}
