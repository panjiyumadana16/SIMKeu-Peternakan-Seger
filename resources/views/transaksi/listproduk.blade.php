@extends('layouts.app')
@section('title', 'List Produk')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
        <!-- Content Header (Page header) -->
        <div class="content-header bg-gradient-info">
            <div class="container-fluid">
                <div class="row mb-2 mt-2">
                    <div class="col-sm-6">
                        <div>
                            <h1 class="m-0">List Produk Telur</h1>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('agen.keranjang') }}" class="btn btn-primary"><i
                                    class="fas fa-shopping-cart"></i> Keranjang Belanja</a>
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
                    @foreach ($data as $val)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header px-2 py-3 text-center">
                                    <h4>{{ $val->nama_produk }}</h4>
                                    ({{ $val->nama_kategori }})
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body px-3 py-2">
                                    <h5 class="float-left">Stok : {{ $val->jml_stok }} kg</h5>
                                    <h5 class="text-success float-right">Rp. {{ $val->harga_jual }} /kg
                                    </h5>
                                </div>
                                <!-- ./card-body -->
                                <div class="card-footer p-2">
                                    <button class="btn btn-info container-fluid" data-id="{{ $val->id }}"
                                        onclick="addKeranjang({{ $val->id }})"> <i class="fas fa-plus"></i> Tambahkan
                                        ke
                                        Keranjang</button>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    @endforeach
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

        $.fn.dataTable.ext.errMode = 'none'

        var Notif = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })

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
    </script>
@endsection
