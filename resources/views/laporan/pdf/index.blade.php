<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Laporan Pendapatan</title>
    <style>
       body{
           font-size: 9pt;
       }

       .header{
           width: 100%;
           height: 40px;
       }

       .header .logo{
           float: left;
       }

       .header .address{
           float: left;
           margin-left: 10px;
           margin-top: -25px;
           width: 300px;
           font-size: 9pt;
       }

       .header .supplier{
           float: right;
           margin-top: -25px;
           font-size: 8pt;
       }

       .header .logo img{
            border-radius: 50%;
       }

       .header .supplier {
           width: 250px;
       }

       .header .supplier .sup{
           margin-bottom: -10px;
       }

       .header .supplier .from{
           margin-left: 54px;
       }

       .header .supplier .addr{
           height: auto;
           margin-left: 55px;
       }

       .content{
           width: 100%;
           height: auto;
       }
       
       .content .judul{
           text-align: center;
       }

       .content .subjudul{
           text-align: center;
           margin-top: -15px;
       }

       .content .periode{
           text-align: center;
           margin-top: 5px;
       }

       .content .tabel-keuangan{
           font-size: 12pt;
           width: 100%;
       }

       .content .tabel-keuangan .type{
           text-align: left;
       }

       .content .tabel-keuangan .total-pengeluaran{
           text-align: center;
       }

       .content .tabel-keuangan .total-pendapatan{
           text-align: center;
       }

        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, td {
            border: 1px solid #000;
            padding: 8px;
        }
        
        .table th {
            background-color: #f2f2f2;
        }

        .footer-nota{
            width: 100px;
            float: right;
            margin-top: 100px;
        }

       .footer-nota .attention{
           width: 100%;
           margin-top: 2px;
           font-size: 10px
       }

       .footer-nota .user{
           width: 400px;
           bottom: 50px;
           text-align: center;
       }
       .footer-nota .user .penerima{
           margin-top: -20px;
           width: 90px;
           height: 40px;
           font-size: 10px;
           float: left;
       }

       .footer-nota .user .users{
           width: 200px;
           float: right;
           margin-top: 60px;
       }
   </style>
</head>
<body>
    <div class="header">
        <div class="logo" style="margin-top: -20px;">
            <img src="{{public_path().'/img/Logo.png'}}" width="60px">
        </div>
        <div class="address">
            <h1>Peternakan Seger</h1>
            <hr>
        </div>
        <div style="float: right;">
            {{date('d F Y')}} {{date('H:i:s')}}
        </div>
    </div>
    <hr>
    <div class="content">
        <h3 class="judul">Laporan Pendapatan</h3>
        <p class="subjudul">Tanggal : {{$tgl_awal}} s/d {{$tgl_akhir}}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">ID</th>
                <th>Tangal Pesanan</th>
                <th>Atas Nama</th>
                <th>Jenis Pengiriman</th>
                <th>Kota Pengiriman</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $dt)
            <tr>
                <td style="text-align: center;">{{$dt->id}}</td>
                <td>{{$dt->tgl_transaksi}}</td>
                <td>{{$dt->nama}}</td>
                <td>{{$dt->jenis_pengiriman}}</td>
                <td>{{$dt->nama_kota}}</td>
                <td>
                    {{$dt->status}}
                </td>
                <td style="text-align: right;">Rp. {{ number_format($dt->total,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #52d283;">
            <tr>
                <th colspan="6" style="text-align: right;">Total Pendapatan:</th>
                <th style="text-align: right;">Rp. {{ number_format($total_pendapatan,0,',','.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>