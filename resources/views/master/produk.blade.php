@extends('layouts.app')
@section('title', 'Produk')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Master Produk</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Produk</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Data Produk</h5>

                                <div class="card-tools">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddData">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </button>
                                </div>
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
                                                <th>Nama Produk</th>
                                                <th>Stok dari Kandang</th>
                                                <th>Kategori</th>
                                                <th>Harga Jual /kg</th>
                                                <th>Stok</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

    <!-- The Modal -->
    <div class="modal fade" id="modalAddData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog-scrollable modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <form enctype="multipart/form-data" autocomplete="off" id="formAddData" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nama_produk">Nama Produk</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="nama Produk" name="nama_produk"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="stok_id">Stok dari kandang</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <select name="stok_id" id="" class="form-control">
                                            <option value="" disabled> Pilih Stok Kandang</option>
                                            @foreach ($stok as $data)
                                                <option value="{{ $data->id }}">{{ $data->kandang }} -
                                                    {{ $data->nama_kategori }} ( STOK :
                                                    {{ $data->jml_stok }} kg )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="harga_jual">Harga Jual /kg (Rp)</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="number" name="harga_jual" class="form-control" min="0"
                                            value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer container-fluid mt-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                <button type="button" id="tambahData" class="btn btn-primary">Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog-scrollable modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <form enctype="multipart/form-data" autocomplete="off" id="formEditData" data-id=""
                        class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nama_produk">Nama Produk</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="nama Produk" name="nama_produk"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="stok_id">Stok dari kandang</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <select name="stok_id" id="" class="form-control">
                                            <option value="" disabled> Pilih Stok Kandang</option>
                                            @foreach ($stok as $data)
                                                <option value="{{ $data->id }}">{{ $data->kandang }} -
                                                    {{ $data->nama_kategori }} ( STOK :
                                                    {{ $data->jml_stok }} kg )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="harga_jual">Harga Jual /kg (Rp)</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="number" name="harga_jual" class="form-control" min="0"
                                            value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer container-fluid mt-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                <button type="button" id="simpanData" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                url: "{{ route('produk.data') }}",
                type: 'GET',
                success: function(res) {
                    $('tbody').html('')
                    $.each(res, function(i, data) {
                        let harga = formatRupiah(data.harga_jual, 'Rp ');
                        htmlview += `<tr>
                        <td style="text-align: center;">` + data.id + `</td>
                        <td>` + data.nama_produk + `</td>
                        <td>` + data.kandang + `</td>
                        <td>` + data.nama_kategori + `</td>
                        <td style="text-align: right;">` + harga + `</td>
                        <td style='text-align: right;'>` + data.jml_stok + ` kg</td>
                        <td>
                          <button class="btn btn-info btn-sm" title="Edit Data!" onClick="detailData('` + data
                            .id + `')"> <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" title="Delete Data!" onClick="deleteData('` + data
                            .id + `')"> <i class="fas fa-trash"></i>
                          </button>
                        </td>
                       </tr>`
                    });

                    $('tbody').html(htmlview)
                    $("#tbl_data").DataTable(dtTableOption).buttons().container().appendTo(
                        '#tbl_data_wrapper .col-md-6:eq(0)')
                }
            })
        }

        function addData() {
            $.ajax({
                url: "{{ route('produk.add') }}",
                type: "POST",
                data: $('#formAddData').serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
                        $('#formAddData').trigger('reset')
                        $('#modalAddData').modal('hide')

                        Notif.fire({
                            icon: 'success',
                            title: res.message,
                        })
                        $("#tbl_data").DataTable().destroy();
                        getData()
                    }
                },
                error: function(err) {
                    Notif.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Data!',
                    });

                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $('#formAddData').find('[name="' + i + '"]');
                        el.addClass('is-invalid');
                        el.after('<div class="invalid-feedback">' + error[0] + '</div>');
                    });
                }
            })
        }

        function detailData(id) {
            var _url = "{{ route('produk.detail', ':id') }}"
            _url = _url.replace(':id', id)

            $.ajax({
                url: _url,
                type: 'GET',
                success: function(res) {
                    $('#modalEditData').modal('show')
                    $('#formEditData').attr("data-id", id)
                    $.each(res, function(i, data) {
                        var el = $('#formEditData').find('[name="' + i + '"]');
                        el.val(data);
                    })
                }
            })
        }

        function updateData() {
            var id = $('#formEditData').find('input[name="id"]').val()
            var _url = "{{ route('produk.update', ':id') }}"
            _url = _url.replace(':id', id)

            $.ajax({
                url: _url,
                type: 'PUT',
                data: $('#formEditData').serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
                        $('#formEditData').attr('data-id', '')
                        $('#formEditData').trigger('reset')
                        $('#modalEditData').modal('hide')

                        Notif.fire({
                            icon: 'success',
                            title: res.message,
                        })
                        $("#tbl_data").DataTable().destroy();
                        getData()
                    }
                },
                error: function(err) {
                    Notif.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Data!',
                    });

                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $('#formEditData').find('[name="' + i + '"]');
                        el.addClass('is-invalid');
                        el.after('<div class="invalid-feedback">' + error[0] + '</div>');
                    });
                }
            })
        }

        $('#tambahData').on('click', function(e) {
            e.preventDefault()
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            addData()
        })

        $('#simpanData').on('click', function(e) {
            e.preventDefault()
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            updateData()
        })

        function deleteData(id) {
            Swal.fire({
                    title: "Apakah anda yakin hapus data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Tidak",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        var _url = "{{ route('produk.delete', ':id') }}";
                        _url = _url.replace(':id', id)
                        var _token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: _url,
                            type: 'DELETE',
                            data: {
                                _token: _token
                            },
                            success: function(res) {
                                Notif.fire({
                                    icon: 'success',
                                    title: res.message,
                                })
                                $("#tbl_data").DataTable().destroy();
                                getData();
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                });
        }
    </script>
@endsection
