@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-egg"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Stok Telur</span>
                                <span class="info-box-number">
                                    {{ number_format($stokTelur, 0, ',', '.') }}
                                    <small>Kg</small>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-home"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Kandang</span>
                                <span class="info-box-number">
                                    {{ number_format($kandang, 0, ',', '.') }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Transaksi</span>
                                <span class="info-box-number">
                                    {{ number_format($jmlTransaksi, 0, ',', '.') }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Agen Telur</span>
                                <span class="info-box-number">
                                    {{ number_format($jmlAgen, 0, ',', '.') }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Rekap Transaksi Bulanan Ini</h5>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <strong>Transaksi: {{ date('F Y') }}</strong>
                                        </p>

                                        <div class="chart">
                                            <!-- Sales Chart Canvas -->
                                            <canvas id="transaksiChart" height="200" style="height: 200px;"></canvas>
                                        </div>
                                        <!-- /.chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-8">
                        <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Transaksi Terakhir</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th>Atas Nama</th>
                                                <th>Jumlah</th>
                                                <th>Jenis</th>
                                                <th>Total</th>
                                                <th width="10%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lastTransaksi as $data)
                                                <tr>
                                                    <td><a href="javascript:void(0)">{{ $data->id }}</a></td>
                                                    <td>{{ $data->nama }}</td>
                                                    <td>
                                                        {{ $data->jumlah_pesanan }}
                                                    </td>
                                                    <td>
                                                        @if ($data->jenis_pengiriman == 'Kirim ke Alamat Pengiriman')
                                                            Kirim
                                                        @else
                                                            Ambil
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        {{ 'Rp. ' . number_format($data->total, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        @if ($data->status == 'Menunggu Konfirmasi')
                                                            <span class="badge badge-info">{{ $data->status }}</span>
                                                        @endif
                                                        @if ($data->status == 'Belum Dibayar')
                                                            <span class="badge badge-warning">{{ $data->status }}</span>
                                                        @endif
                                                        @if ($data->status == 'Proses Pengiriman / Pengambilan')
                                                            <span class="badge badge-primary">{{ $data->status }}</span>
                                                        @endif
                                                        @if ($data->status == 'Selesai' || $data->status == 'Selesai (Return)')
                                                            <span class="badge badge-success">{{ $data->status }}</span>
                                                        @endif
                                                        @if ($data->status == 'Proses Return')
                                                            <span class="badge badge-secondary">{{ $data->status }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="{{ route('pesanan') }}" class="btn btn-sm btn-secondary float-right">
                                    Lihat Semua Transaksi</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4">

                        <!-- PRODUCT LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Produk Baru Ditambahkan</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @foreach ($lastProduk as $prdk)
                                        <li class="item">
                                            <div class="product-img">
                                                <div class="img-size-50 text-center bg-gradient-secondary img-circle">
                                                    <i class="fas fa-egg fa-2x m-2"></i>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">
                                                    {{ $prdk->nama_produk }}
                                                    <span class="badge badge-info float-right">
                                                        {{ 'Rp. ' . number_format($prdk->harga_jual, 0, ',', '.') . ' /kg' }}
                                                    </span>
                                                </a>
                                                <span class="product-description">
                                                    {{ $prdk->nama_kategori }} - Stok : {{ $prdk->jml_stok - $prdk->jml_stok_terjual }} kg
                                                    <br> <b>Tanggal Stok : {{ $prdk->tgl_diambil }}</b>
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('produk') }}" class="uppercase">Lihat Semua Produk</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-12">
                        <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Stok Panen Terakhir</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th>Asal Stok</th>
                                                <th>Kategori Stok</th>
                                                <th>Tanggal Diambil</th>
                                                <th>Stok Tersisa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lastStok as $data)
                                                <tr>
                                                    <td><a href="javascript:void(0)">{{ $data->id }}</a></td>
                                                    <td>{{ $data->kandang }}</td>
                                                    <td>
                                                        {{ $data->nama_kategori }}
                                                    </td>
                                                    <td>
                                                        {{ $data->tgl_diambil }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format(($data->jml_stok - $data->jml_stok_terjual) , 0, ',', '.') }} Kg
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="{{ route('stok') }}" class="btn btn-sm btn-secondary float-right">
                                    Lihat Stok Panen</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    @endsection
    @section('script')
        <script>
            var salesChartCanvas = $('#transaksiChart').get(0).getContext('2d')

            var salesChartData = {
                labels: @json($labelChart),
                datasets: [{
                    label: 'Transaksi',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: 2,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: @json($dataChart)
                }]
            }

            var salesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true
                        }
                    }]
                }
            }

            var salesChart = new Chart(salesChartCanvas, {
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
            })
        </script>
    @endsection
