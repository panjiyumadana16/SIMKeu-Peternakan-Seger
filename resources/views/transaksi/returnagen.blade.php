@extends('layouts.app')
@section('title', 'Daftar Permintaan Return')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
        <!-- Content Header (Page header) -->
        <div class="content-header bg-gradient-info">
            <div class="container-fluid">
                <div class="row mb-2 mt-2">
                    <div class="col-sm-6">
                        <div>
                            <h1 class="m-0">Daftar Permintaan Return</h1>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Data Permintaan Return</h5>
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
                                                <th>Tangal Return</th>
                                                <th>Atas Nama</th>
                                                <th>Jumlah Item</th>
                                                <th>Total</th>
                                                <th>Alasan Return</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data_body">
                                        </tbody>
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
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dtTableOption = {
            "paging": true,
            "lengthChange": false,
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
            $.ajax({
                url: "{{ route('agen.return.data') }}",
                type: 'GET',
                success: function(res) {
                    $('#tbl_data_tbody').html('')
                    $.each(res, function(i, data) {
                        let total = formatRupiah(data.total, 'Rp. ');
                        let btn_color = 'btn-light';
                        if (data.status == 'Menunggu Konfirmasi') {
                            to_status = 1
                            btn_color = 'btn-info';
                        }

                        if (data.status == 'Selesai') {
                            btn_color = 'btn-success';
                        }

                        htmlview += `<tr>
                        <td style="text-align: center;">` + data.id + `</td>
                        <td>` + data.tgl_return + `</td>
                        <td>` + data.nama + `</td>
                        <td>` + data.jumlah_return + `</td>
                        <td style="text-align: right;">` + total + `</td>
                        <td>` + data.alasan_return + `</td>
                        <td>`

                        htmlview += `<button class="btn ` + btn_color + ` btn-sm container" title="Status Transaksi!">
                                ` + data.status + `
                          </button>`

                        htmlview += `</td>
                        <td>
                        </td>
                       </tr>`
                    });

                    $('#tbl_data_body').html(htmlview)
                    $("#tbl_data").DataTable(dtTableOption).buttons().container().appendTo(
                        '#tbl_data_wrapper .col-md-6:eq(0)')
                }
            })
        }

        function detailData(id) {
            var _url = "{{ route('agen.pesanan.detail', ':id') }}"
            _url = _url.replace(':id', id)

            var dtlView

            $.ajax({
                url: _url,
                type: 'GET',
                success: function(res) {
                    $('#modalEditData').modal('show')
                    $('.id_transaksi').html('No. Transaksi : ' + res.transaksi.id)
                    $('.tgl_pesanan').html('Tanggal Pesanan : ' + res.transaksi.tgl_transaksi)
                    $('#dtl_atas_nama').html(res.transaksi.nama)
                    $('#dtl_jns').html(res.transaksi.jenis_pengiriman)
                    $('#dtl_alamat').html(res.transaksi.alamat_pengiriman)
                    $('#dtl_status').html(res.transaksi.status)
                    let ongkir = formatRupiah(res.transaksi.ongkir, 'Rp. ');
                    $('#dtl_ongkir').html(ongkir)
                    let total = formatRupiah(res.transaksi.total, 'Rp. ');
                    $('#dtl_total').html(total)

                    $('#dtl_data').html('')
                    $.each(res.detail_transaksi, function(i, data) {
                        let subtotal = formatRupiah(data.sub_total_harga, 'Rp. ');
                        dtlView += `
                        <tr>
                            <td>` + data.nama_produk + ` - (` + data.nama_kategori + `) - Rp. ` + data.harga_jual + ` /kg</td>
                            <td>` + data.jumlah_produk + ` kg</td>
                            <td class="text-right">` + subtotal + `</td>
                        </tr>
                        `
                    })
                    $('#dtl_data').html(dtlView)
                }
            })
        }
    </script>
@endsection
