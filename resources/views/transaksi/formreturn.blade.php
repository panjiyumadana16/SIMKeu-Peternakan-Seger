@extends('layouts.app')
@section('title', 'Form Permintaan Return')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
        <!-- Content Header (Page header) -->
        <div class="content-header bg-gradient-info">
            <div class="container-fluid">
                <div class="row mb-2 mt-2">
                    <div class="col-sm-6">
                        <div>
                            <h1 class="m-0">Form Permintaan Return</h1>
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
                                <h5 class="card-title">Data Pesanan</h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="tbl_data_wrapper"
                                    class="dataTables_wrapper dt-bootstrap4 table-responsive text-nowrap">
                                    <table id="tbl_data" class="table table-bordered dataTable" aria-describedby="tbl_data"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="45%">Produk</th>
                                                <th width="15%">Harga /kg</th>
                                                <th width="15%">Jumlah (kg)</th>
                                                <th width="20%">Sub-total</th>
                                                <th width="5%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data_body">
                                            @foreach ($detail_tr as $dt)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="produk[]" disabled
                                                            class="form-control produk" value="{{ $dt->nama_produk }}">
                                                        <input type="text" hidden name="produk_id[]" class="produk_id"
                                                            value="{{ $dt->produk_id }}">
                                                        <input type="text" hidden name="detail_tr_id[]"
                                                            class="detail_tr_id" value="{{ $dt->id }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="harga_jual[]" disabled
                                                            class="form-control harga_jual" value="{{ $dt->harga_jual }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="jumlah_return[]"
                                                            class="form-control jumlah_return"
                                                            value="{{ $dt->jumlah_produk }}" min="1"
                                                            max="{{ $dt->jumlah_produk }}">
                                                    </td>
                                                    <td class="text-primary text-right subtotal">
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-sm delete_return">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right 
                                                border-left-0 border-danger text-danger"
                                                    colspan="3">
                                                    Biaya Return 10%
                                                </th>
                                                <td class="text-right text-danger
                                                border-right-0 border-left-0 border-danger"
                                                    id="biaya_return">
                                                    - Rp. 0
                                                </td>
                                                <td class="bg-danger border-danger"></td>
                                            </tr>
                                            <tr>
                                                <th class="text-right 
                                                border-left-0 border-info"
                                                    colspan="3">
                                                    Total
                                                </th>
                                                <td class="text-right text-bold
                                                border-right-0 border-left-0 border-info"
                                                    id="total_return">
                                                    Rp. 0
                                                </td>
                                                <td class="bg-info border-info"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="container-fluid row">
                                    <div class="my-2 col-md-12">
                                        <label for="alasan_return">Alasan Return</label>
                                        <div class="col-md-14 row">
                                            <div class="col-md-12">
                                                <textarea placeholder="Alasan Return" name="alasan_return" class="form-control" id="alasan_return"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <a href="{{ route('agen.pesanan') }}" class="float-right">
                                            <button class="btn btn-secondary container-fluid">Batal</button>
                                        </a>

                                        <button class="btn btn-info float-right mx-2" id="buat_return"
                                            data-tr-id="{{ $detail_tr[0]->transaksi_id }}"> Buat
                                            Permintaan Return </button>
                                    </div>
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
@endsection

@section('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dtTableOption = {
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
        };

        $.fn.dataTable.ext.errMode = 'none'

        var Notif = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
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

        updateSubtotal()

        function updateSubtotal() {
            let tr = $("tbody").find('tr')

            tr.each((i, row) => {
                let harga = $(row).children('td').children('.harga_jual').val()
                let jml = $(row).children('td').children('.jumlah_return').val()
                let subtotal = harga * jml

                let rowCell = $(row).children('.subtotal')
                rowCell.html(subtotal)
            })
        }

        updateBiaya()

        function updateBiaya() {
            let tr = $("tbody").find('tr')
            var total = 0

            tr.each((i, row) => {
                let rowCell = $(row).children('.subtotal').text()
                rowCell = parseInt(rowCell)
                total += rowCell
            })

            var biaya = total * 0.1
            $('#biaya_return').html(biaya)
        }

        updateTotal()

        function updateTotal() {
            let tr = $("tbody").find('tr')
            let biaya = $('#biaya_return').html()
            var total = 0

            tr.each((i, row) => {
                let rowCell = $(row).children('.subtotal').text()
                rowCell = parseInt(rowCell)
                total += rowCell
            })

            total = total - parseInt(biaya)
            $('#total_return').html(total)
        }

        $('.jumlah_return').on('change', function(e) {
            e.preventDefault()

            updateSubtotal()
            updateBiaya()
            updateTotal()
        })

        $('.delete_return').on('click', function(e) {
            let $this = $(this).closest('tr')
            let tr = $("tbody").find('tr')

            if (tr.length > 1) {
                $this.remove()

                updateSubtotal()
                updateBiaya()
                updateTotal()
            } else {
                Notif.fire({
                    icon: 'warning',
                    title: 'Item Return tersisa 1, tidak bisa dapat melakukan penghapusan item!',
                });
            }
        })

        $('#buat_return').on('click', function(e) {
            e.preventDefault();

            let tr = $("tbody").find('tr')
            let tr_id = $(this).data('tr-id')
            let harga = [],
                detail_id = [],
                jml = []
            let alasan = $('#alasan_return').val()
            let total = $('#total_return').text()

            tr.each((i, row) => {
                harga[i] = $(row).children('td').children('.harga_jual').val()
                detail_id[i] = $(row).children('td').children('.detail_tr_id').val()
                jml[i] = $(row).children('td').children('.jumlah_return').val()
            })

            if (alasan === '') {
                Notif.fire({
                    icon: 'warning',
                    title: 'Alasan return harus diisi!',
                });
            } else {
                Swal.fire({
                    title: "Apakah anda yakin ingin membuat permintaan return transaksi?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya!",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('agen.return.create') }}",
                            type: "POST",
                            data: {
                                'detail_transaksies_id': detail_id,
                                'jml_return': jml,
                                'transaksi_id': tr_id,
                                'alasan_return': alasan,
                                'total': total
                            },
                            dataType: 'json',
                            success: function(res) {
                                if (res.code == 200) {
                                    Notif.fire({
                                        icon: 'success',
                                        title: res.message
                                    })
                                    setTimeout(() => {
                                        location.href = "{{ route('agen.pesanan') }}"
                                    }, 3000);
                                }
                                if (res.code == 400) {
                                    Notif.fire({
                                        icon: 'warning',
                                        title: res.message
                                    })
                                }
                            },
                            error: function(err) {
                                Notif.fire({
                                    icon: 'error',
                                    title: 'Gagal Membuat Pemintaan Return!',
                                });
                            }
                        })
                    }
                })
            }
        })
    </script>
@endsection
