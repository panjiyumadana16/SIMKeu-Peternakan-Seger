@extends('layouts.app')
@section('title', 'Keranjang Belanjaan')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
        <!-- Content Header (Page header) -->
        <div class="content-header bg-gradient-info">
            <div class="container-fluid">
                <div class="row mb-2 mt-2">
                    <div class="col-sm-6">
                        <div>
                            <h1 class="m-0">Keranjang Belanja</h1>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('agen.dashboard') }}" class="btn btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali</a>
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
                                <h5 class="card-title">Daftar Produk di keranjang</h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="tbl_data_wrapper"
                                    class="dataTables_wrapper dt-bootstrap4 table-responsive text-nowrap">
                                    <table id="tbl_data" class="table table-bordered table-striped dataTable"
                                        aria-describedby="tbl_data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th width="15%">Jumlah Dibeli</th>
                                                <th width="20%">Sub Total</th>
                                                <th width="5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($keranjang) < 1)
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted"> Keranjang Belanjaan
                                                        Kosong</td>
                                                </tr>
                                            @endif
                                            @foreach ($keranjang as $data)
                                                <tr>
                                                    <td>
                                                        {{ $data->nama_produk }} - ({{ $data->nama_kategori }}) - Rp.
                                                        {{ $data->harga_jual }} /butir
                                                        <br>
                                                        Stok : {{ $data->jml_stok }} butir
                                                    </td>
                                                    <td width="15%">
                                                        <input type="number" id="" data-id="{{ $data->id }}"
                                                            value="{{ $data->jumlah }}" class="form-control jumlah_beli">
                                                    </td>
                                                    <td width="20%" class="sub_total text-right">Rp.
                                                        {{ $data->subtotal }}
                                                    </td>
                                                    <td width="5%">
                                                        <button class="btn btn-danger btn-sm delete_keranjang"
                                                            data-id="{{ $data->id }}" id=""> <i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Total Pembayaran : </h3>
                                <h3 class="float-right" id="total_pembayaran"> Rp. 0</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="atas_nama">Pesanan Atas Nama</label>
                                        <div class="col-md-14 row">
                                            <div class="col-md-12">
                                                <input type="text" name="atas_nama" value="{{ $agen->nama }}"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_pengiriman">Metode Pengiriman</label>
                                        <div class="col-md-14 row">
                                            <div class="col-md-12">
                                                <select name="jenis_pengiriman" class="form-control">
                                                    <option value="" disabled selected>Pilih Metode Pengiriman
                                                    </option>
                                                    <option value="Kirim ke Alamat Pengiriman">Kirim ke Alamat
                                                        Pengiriman</option>
                                                    <option value="Ambil Sendiri">Ambil Sendiri</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label for="alamat_pengiriman">Alamat Pengiriman</label>
                                        <div class="col-md-14 row">
                                            <div class="col-md-12">
                                                <textarea placeholder="Alamat Pengiriman" name="alamat_pengiriman" class="form-control"> {{ $agen->alamat }}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success float-right" id="checkout">Checkout Pesanan</button>
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
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
    <script>
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
            "autoWidth": true,
            "responsive": true,
            "buttons": [{
                    text: "<i class='fas fa-copy' title='Copy Table to Clipboard'></i>",
                    className: "btn btn-outline-secondary",
                    extend: 'copy'
                },
                {
                    text: "<i class='fas fa-file-excel' title='Download File Excel'></i>",
                    className: "btn btn-outline-success",
                    extend: 'excel'
                },
                {
                    text: "<i class='fas fa-file-pdf' title='Download File PDF'></i>",
                    className: "btn btn-outline-danger",
                    extend: 'pdf'
                },
                {
                    text: "<i class='fas fa-print' title='Print Table'></i>",
                    className: "btn btn-outline-primary",
                    extend: 'print'
                },
                // {
                //     text: "<i class='fas fa-cog' title='Coloum Visible Option'></i>",
                //     className: "btn btn-outline-info",
                //     extend: 'colvis'
                // }
            ]
        };

        var Notif = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })

        $('.jumlah_beli').on('change', function(e) {
            e.preventDefault()
            var getID = $(this).data('id')
            var getVal = $(this).val()
            var $this = $(this)

            $.ajax({
                url: "{{ route('agen.keranjang.update') }}",
                type: "POST",
                data: {
                    'id': getID,
                    'jumlah': getVal
                },
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
                        $this.closest('tr').find('td.sub_total').html('Rp. ' + res.sub_total)
                    }
                },
                error: function(err) {
                    Notif.fire({
                        icon: 'error',
                        title: 'Gagal Update Jumlah!',
                    });
                }
            })

            updateTotal()
        })

        $('.delete_keranjang').on('click', function(e) {
            e.preventDefault()
            var getID = $(this).data('id')
            var $this = $(this)

            var url = "{{ route('agen.keranjang.delete', '_getid') }}"
            url = url.replace('_getid', getID);

            $.ajax({
                url: url,
                type: "DELETE",
                success: function(res) {
                    if (res.code == 200) {
                        $this.closest('tr').remove()
                    }
                },
                error: function(err) {
                    Notif.fire({
                        icon: 'error',
                        title: 'Server Error!',
                    });
                }
            })

            updateTotal()
        })

        updateTotal()

        function updateTotal() {
            $.ajax({
                url: "{{ route('agen.keranjang.gettotal') }}",
                type: "GET",
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
                        $('#total_pembayaran').html('Rp. ' + res.total)
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        function addKeranjang(produk_id) {
            let user_id = {{ Auth::user()->id }}
            $.ajax({
                url: "{{ route('agen.addKeranjang') }}",
                type: "POST",
                data: {
                    'user_id': user_id,
                    'produk_id': produk_id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
                        Notif.fire({
                            icon: 'success',
                            title: res.message,
                        })
                    }
                    if (res.code == 400) {
                        Notif.fire({
                            icon: 'warning',
                            title: res.message,
                        })
                    }
                },
                error: function(err) {
                    Notif.fire({
                        icon: 'error',
                        title: 'Gagal Menambahkan ke Keranjang!',
                    });
                }
            })
        }

        $('#checkout').on('click', function(e) {
            e.preventDefault()
            let jenis_pengiriman = $('select[name="jenis_pengiriman"]').val()
            let alamat_pengiriman = $('textarea[name="alamat_pengiriman"]').val()

            if (jenis_pengiriman === '' || alamat_pengiriman === '') {
                Notif.fire({
                    icon: 'warning',
                    title: 'Ada form yang masih kosong!',
                });
            } else {
                $.ajax({
                    url: "{{ route('agen.checkout.add') }}",
                    type: "POST",
                    data: {
                        'jenis_pengiriman': jenis_pengiriman,
                        'alamat_pengiriman': alamat_pengiriman
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.code == 200) {
                            Notif.fire({
                                icon: 'success',
                                title: res.message
                            })
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
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
                            title: 'Gagal Melakukan checkout!',
                        });
                    }
                })
            }
        })
    </script>
@endsection
