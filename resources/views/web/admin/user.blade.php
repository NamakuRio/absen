@extends('templates.master')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
@endsection

@section('content')
    <div class="section-header">
        <h1>Pengguna</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
            <div class="breadcrumb-item">Pengguna</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengguna</h4>
                        @can ('user.create')
                            <div class="card-header-action">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="openModal();" tooltip="Tambah Pengguna"><i class="fas fa-plus"></i> Tambah Pengguna</a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="user-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10">
                                            #
                                        </th>
                                        <th>Peran</th>
                                        <th>Nama Pengguna</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Hp</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @can ('user.create')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-user">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-add-user">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-12 col-sm-12" id="add-view-role"></div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="add-user-username" required autofocus>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="add-user-name" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="add-user-email" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="add-user-password" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="add-user-password-confirm" required>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>No HP</label>
                                    <input type="text" class="form-control" name="phone" id="add-user-phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-add-user">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('user.update')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-update-user">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-update-user">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="" id="update-user-id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-12 col-sm-12" id="update-view-role"></div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="update-user-username" required autofocus>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="update-user-name" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="update-user-email" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="update-user-password" placeholder="Kosongkan kata sandi jika tidak ingin mengubahnya">
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="update-user-password-confirm">
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>No HP</label>
                                    <input type="text" class="form-control" name="phone" id="update-user-phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-update-user">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('user.manage')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-manage-user">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mengelola Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-manage-user">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" id="view-manage-user">

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-manage-user">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('js-library')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection

@section('js-script')
    <script>
        $(function () {
            "use strict";

            getUsers();

            @can ('user.create')
                $("#form-add-user").on("submit", function(e) {
                    e.preventDefault();
                    addUser();
                });
            @endcan

            @can ('user.update')
                $("#form-update-user").on("submit", function(e) {
                    e.preventDefault();
                    updateUser();
                });
            @endcan

            @can ('user.manage')
                $("#form-manage-user").on("submit", function(e) {
                    e.preventDefault();
                    manageUser();
                });
            @endcan
        });

        async function getUsers()
        {
            $("#user-list").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user.data') }}",
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'role_name' },
                    { data: 'username' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'action' },
                ]
            });
        }

        async function initSelect2FormRole()
        {
            $('.select2-form-role').select2({
                width: '100%',
                placeholder: "Pilih Peran",
                // minimumInputLength: 1,
                ajax: {
                    url: "{{ route('admin.role.data.select2') }}",
                    type: "get",
                    dataType: "json",
                    quietMillis: 50,
                    delay: 250,
                    data: function (term) {
                        text = term.term ? term.term : '';
                        query = {
                          _type: term._type,
                          term: text,
                        };
                        return {
                            data: query,
                        };
                    },
                    processResults : function(data) {;
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        }
                    }
                },
            })
        }

        @can ('user.create')
            async function openModal()
            {
                $('#modal-add-user').modal('show');
                $('#add-view-role').html(`
                <label>Peran</label>
                <select name="role" id="add-user-role" class="form-control select2-form-role"></select>
                `);
                initSelect2FormRole();
            }

            async function addUser()
            {
                var formData = $("#form-add-user").serialize();

                $.ajax({
                    url: "{{ route('admin.user.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-add-user").addClass('btn-progress');
                        $("#btn-add-user").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-add-user").removeClass('btn-progress');
                        $("#btn-add-user").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-add-user")[0].reset();
                            $('#modal-add-user').modal('hide');
                            getUsers();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can ('user.update')
            async function getUpdateUser(obj)
            {
                var id = $(obj).data('id');

                $('#modal-update-user').modal('show');
                $('#form-update-user')[0].reset();

                $('#update-view-role').html(`
                <label>Peran</label>
                <select name="role" id="update-user-role" class="form-control select2-form-role"></select>
                `);
                initSelect2FormRole();

                $.ajax({
                    url: "{{ route('admin.user.edit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-update-user").addClass('btn-progress');
                        $("#btn-update-user").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-user").removeClass('btn-progress');
                        $("#btn-update-user").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        $('#update-user-id').val(result['data']['user']['id']);
                        $('#update-user-username').val(result['data']['user']['username']);
                        $('#update-user-name').val(result['data']['user']['name']);
                        $('#update-user-email').val(result['data']['user']['email']);
                        $('#update-user-phone').val(result['data']['user']['phone']);
                        $('#update-user-role').append("<option value='"+result['data']['role']['id']+"' selected>"+result['data']['role']['name']+"</option>");

                    }
                });
            }

            async function updateUser()
            {
                var formData = $("#form-update-user").serialize();

                $.ajax({
                    url: "{{ route('admin.user.update') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-update-user").addClass('btn-progress');
                        $("#btn-update-user").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-user").removeClass('btn-progress');
                        $("#btn-update-user").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-update-user")[0].reset();
                            $('#modal-update-user').modal('hide');
                            getUsers();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can('user.manage')
            async function getManageUser(obj)
            {
                var id = $(obj).data('id');
                $('#modal-manage-user').modal('show');
                $("#view-manage-user").html('<h4 class="text-center my-4">Loading . . .</h4>');

                $.ajax({
                    url: "{{ route('admin.user.manage.get') }}",
                    type: "POST",
                    dataType: "html",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-manage-user").addClass('btn-progress');
                        $("#btn-manage-user").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("button").removeAttr('disabled', 'disabled');
                        $("#btn-manage-user").removeAttr('disabled', 'disabled');
                        $("#btn-manage-user").removeClass('btn-progress');
                    },
                    success : function(result) {
                        $("#view-manage-user").html(result);
                    }
                });
            }
            async function manageUser()
            {
                var formData = $("#form-manage-user").serialize();

                $.ajax({
                    url: "{{ route('admin.user.manage') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-manage-user").addClass('btn-progress');
                        $("#btn-manage-user").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-manage-user").removeClass('btn-progress');
                        $("#btn-manage-user").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-manage-user")[0].reset();
                            $('#modal-manage-user').modal('hide');
                            getUsers();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can('user.delete')
            async function deleteUser(object)
            {
                var id = $(object).data('id');
                Swal.fire({
                    title: 'Anda yakin menghapus pengguna?',
                    text: 'Setelah dihapus, Anda tidak dapat memulihkannya kembali',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus pengguna!',
                    showLoaderOnConfirm:true,
                    preConfirm: () => {
                        ajax =  $.ajax({
                                    url: "{{ route('admin.user.destroy') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        "id": id,
                                        "_method": "DELETE",
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success : function(result) {
                                        if(result['status'] == 'success'){
                                            getUsers();
                                        }
                                        swalNotification(result['status'], result['msg']);
                                    }
                                });

                        return ajax;
                    }
                })
                .then((result) => {
                    if (result.value) {
                        notification(result.value.status, result.value.msg);
                    }
                });

            }
        @endcan
    </script>
@endsection
