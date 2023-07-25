@extends('layouts.app')
@section('title', 'Laporan Pendapatan')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Laporan Pendapatan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                            <li class="breadcrumb-item active">Laporan Pendapatan</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <h5 class="card-title">Filter Transaksi</h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body row">
                                <div class="col-md-4">
                                    <label for="tgl_awal">Tanggal Awal</label>
                                    <div class="col-md-14 row">
                                        <div class="col-md-12">
                                            <input type="date" placeholder="Tanggal Awal" name="tgl_awal" class="form-control" value="{{ date('Y-m').'-01' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="tgl_akhir">Tanggal Akhir</label>
                                    <div class="col-md-14 row">
                                        <div class="col-md-12">
                                            <input type="date" placeholder="Tanggal Akhir" name="tgl_akhir" class="form-control"
                                            value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">&nbsp;</label>
                                    <div class="col-md-14 row">
                                        <div class="col-md-6 ">
                                            <button class="btn btn-outline-info container" id="cari_transaksi">
                                                <i class="fas fa-magnifying-glass"></i> Cari</button>
                                        </div>
                                        <div class="col-md-6 ">
                                            <button class="btn btn-outline-primary container" id="print_laporan">
                                                <i class="fas fa-print"></i> Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Data Transaksi</h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="tbl_data_wrapper"
                                    class="dataTables_wrapper dt-bootstrap4 table-responsive text-nowrap">
                                    <table id="tbl_data" class="table table-bordered table-striped dataTable"
                                        aria-describedby="tbl_data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" style="text-align: center;">ID</th>
                                                <th>Tangal Pesanan</th>
                                                <th>Atas Nama</th>
                                                <th>Jenis Pengiriman</th>
                                                <th>Alamat Pengiriman</th>
                                                <th>Total</th>
                                                <th>Status Pesanan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data_body">
                                        </tbody>
                                        <tfoot class="bg-secondary">
                                            <tr>
                                                <th colspan="5" class="text-right">Total :</th>
                                                <th class="text-right" id="total_pendapatan">Rp. 0</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="modalEditData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog-scrollable modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light row">
                    <div class="col-sm-6">
                        <div class="id_transaksi">
                            No. Transaksi :
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="tgl_pesanan text-right">
                            Tanggal Pesanan :
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <table style="width: 100%;" border="0">
                            <tr>
                                <td width="20%">Atas Nama</td>
                                <td>:</td>
                                <td id="dtl_atas_nama"></td>
                            </tr>
                            <tr>
                                <td width="20%">Jenis Pengiriman</td>
                                <td>:</td>
                                <td id="dtl_jns"></td>
                            </tr>
                            <tr>
                                <td width="20%">Alamat Pengiriman</td>
                                <td>:</td>
                                <td id="dtl_alamat"></td>
                            </tr>
                            <tr>
                                <td width="20%">Status Pesanan</td>
                                <td>:</td>
                                <td id="dtl_status"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <table id="tbl_detail" class="table table-bordered table-striped dataTable"
                            aria-describedby="tbl_detail" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Sub total</th>
                                </tr>
                            </thead>
                            <tbody id="dtl_data">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2">Ongkir :</td>
                                    <td id="dtl_ongkir" class="text-right"></td>
                                </tr>
                                <tr class="bg-gradient-lightblue">
                                    <th class="text-right" colspan="2">Total :</th>
                                    <th id="dtl_total" class="text-right"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer container-fluid mt-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dtTableOption = {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
        };

        $.fn.dataTable.ext.errMode = 'none'

        var Notif = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })

        function formatRupiah(angka, prefix) {
            var angka = angka.toString();
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        getData()

        function getData() {
            var htmlview
            var tgl_awal = $('input[name="tgl_awal"]').val();
            var tgl_akhir = $('input[name="tgl_akhir"]').val();
            $.ajax({
                url: "{{ route('laporan.data') }}",
                type: 'POST',
                data: {
                    'tgl_awal' : tgl_awal,
                    'tgl_akhir' : tgl_akhir,
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(res) {
                    if (res.code == 400) {
                        Notif.fire({
                        icon: 'error',
                        title: res.message,
                    });
                    } else {
                        var total_pendapatan = 0;
                        $('#tbl_data_tbody').html('')
                        $.each(res, function(i, data) {
                            let total = formatRupiah(data.total, 'Rp. ');
                            total_pendapatan = total_pendapatan + data.total;
                            let to_status = 0;
                            let btn_color = 'btn-info disabled';

                            if (data.status == 'Selesai') {
                                btn_color = 'btn-success disabled';
                            }

                            htmlview += `<tr>
                            <td style="text-align: center;">` + data.id + `</td>
                            <td>` + data.tgl_transaksi + `</td>
                            <td>` + data.nama + `</td>
                            <td>` + data.jenis_pengiriman + `</td>
                            <td>`+data.nama_kota+` - ` + data.alamat_pengiriman + `</td>
                            <td style="text-align: right;">` + total + `</td>
                            <td>
                            <button class="btn ` + btn_color + ` btn-sm container" title="Status Transaksi!">
                                    ` + data.status + `
                            </button>
                            </td>
                        </tr>`
                        });

                        $("#total_pendapatan").html(formatRupiah(total_pendapatan,'Rp. '))
                        $('#tbl_data_body').html(htmlview)
                        $("#tbl_data").DataTable(dtTableOption)
                    }
                }
            })
        }

        $('#cari_transaksi').on('click',function(e){
            e.preventDefault()
            getData()
        })

        $('#print_laporan').on('click',function(e){
            e.preventDefault()
            var tgl_awal = $('input[name="tgl_awal"]').val();
            var tgl_akhir = $('input[name="tgl_akhir"]').val();

            $.ajax({
                url: "{{ route('laporan.data.print') }}",
                type: 'POST',
                data: {
                    'tgl_awal' : tgl_awal,
                    'tgl_akhir' : tgl_akhir,
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(res) {
                    if (res.code == 400) {
                        Notif.fire({
                            icon: 'error',
                            title: res.message,
                        })
                    }
                    if (res.code == 200) {
                        Notif.fire({
                            icon: 'success',
                            title: res.message,
                        })

                        let _url = '{{ route("laporan.print",[":tgl_awal",":tgl_akhir"]) }}'
                        _url = _url.replace(':tgl_awal',tgl_awal)
                        _url = _url.replace(':tgl_akhir',tgl_akhir)

                        setTimeout(() => {
                            window.open(_url);
                        }, 1500);
                    }
                }
            })
        })
    </script>
@endsection
