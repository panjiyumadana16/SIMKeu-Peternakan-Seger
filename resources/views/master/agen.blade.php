@extends('layouts.app')
@section('title', 'Agen')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Master Agen</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Agen</li>
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
                                <h5 class="card-title">Data Agen</h5>

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
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Nomor HP</th>
                                                <th>Kota</th>
                                                <th>Alamat</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Agen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <form enctype="multipart/form-data" autocomplete="off" id="formAddData" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-12 bg-secondary">
                                <label for="username">Username</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="username" name="username" class="form-control"
                                            minlength="8" maxlength="16">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 bg-secondary pb-2">
                                <label for="password">Password</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="password" placeholder="password" name="password" class="form-control"
                                            minlength="8" maxlength="16">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="nama">Nama Agen</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Nama Agen" name="nama" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="no_hp">Nomor HP</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="083..." name="no_hp" class="form-control"
                                            maxlength="13" minlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="kota">Kota</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" name="kota" placeholder="Kota" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="alamat">Alamat</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <textarea name="alamat" class="form-control" placeholder="Alamat Agen" height="2"></textarea>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Agen</h5>
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
                            <div class="col-md-12 bg-secondary">
                                <label for="username">Username</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="username" name="username"
                                            class="form-control" minlength="8" maxlength="16">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 bg-secondary pb-2">
                                <label for="password">Password <small class="text-light">*isi untuk mengubah
                                        password</small></label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="password" placeholder="password" name="password"
                                            class="form-control" minlength="8" maxlength="16">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="nama">Nama Agen</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Nama Agen" name="nama"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="no_hp">Nomor HP</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="083..." name="no_hp" class="form-control"
                                            maxlength="13" minlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="kota">Kota</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <input type="text" name="kota" placeholder="Kota" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="alamat">Alamat</label>
                                <div class="col-md-14 row">
                                    <div class="col-md-12">
                                        <textarea name="alamat" class="form-control" placeholder="Alamat Agen" height="2"></textarea>
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

        var Notif = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })

        getData()

        function getData() {
            var htmlview
            $.ajax({
                url: "{{ route('agen.data') }}",
                type: 'GET',
                success: function(res) {
                    $('tbody').html('')
                    $.each(res, function(i, data) {
                        htmlview += `<tr>
                        <td style="text-align: center;">` + data.id + `</td>
                        <td>` + data.username + `</td>
                        <td>` + data.nama + `</td>
                        <td>` + data.no_hp + `</td>
                        <td>` + data.kota + `</td>
                        <td>` + data.alamat + `</td>
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
                url: "{{ route('agen.add') }}",
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
            var _url = "{{ route('agen.detail', ':id') }}"
            _url = _url.replace(':id', id)

            $.ajax({
                url: _url,
                type: 'GET',
                success: function(res) {
                    $('#modalEditData').modal('show')
                    $('#formEditData').attr("data-id", id)
                    $.each(res, function(i, data) {
                        var el = $('#formEditData').find('[name="' + i + '"]');
                        if (i != 'password') {
                            el.val(data);
                        }
                    })
                }
            })
        }

        function updateData() {
            var id = $('#formEditData').data('id')
            var _url = "{{ route('agen.update', ':id') }}"
            _url = _url.replace(':id', id)

            $.ajax({
                url: _url,
                type: 'PUT',
                data: $('#formEditData').serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
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
                        var _url = "{{ route('agen.delete', ':id') }}";
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
