@extends('templates.master')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="section-header">
        <h1>Peran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
            <div class="breadcrumb-item">Peran</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Peran</h4>
                        @can ('role.create')
                            <div class="card-header-action">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="$('#modal-add-role').modal('show');" tooltip="Tambah Peran"><i class="fas fa-plus"></i> Tambah Peran</a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="role-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10">
                                            #
                                        </th>
                                        <th>Nama</th>
                                        <th>Default Pengguna</th>
                                        <th>Tujuan login</th>
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
    @can ('role.create')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-role">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Peran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-add-role">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="add-role-name" required autofocus>
                                </div>
                                <div class="form-group col-12">
                                    <label>Tujuan Login</label>
                                    <input type="text" class="form-control" name="login_destination" id="add-role-login-destination" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-add-role">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('role.update')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-update-role">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Peran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-update-role">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="" id="update-role-id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="update-role-name" required autofocus>
                                </div>
                                <div class="form-group col-12">
                                    <label>Tujuan Login</label>
                                    <input type="text" class="form-control" name="login_destination" id="update-role-login-destination" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-update-role">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('role.manage')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-manage-role">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mengelola Peran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-manage-role">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" id="view-manage-role">

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-manage-role">Simpan Perubahan</button>
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
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection

@section('js-script')
    <script>
        $(function () {
            "use strict";

            getRoles();

            @can ('role.create')
                $("#form-add-role").on("submit", function(e) {
                    e.preventDefault();
                    addRole();
                });
            @endcan

            @can ('role.update')
                $("#form-update-role").on("submit", function(e) {
                    e.preventDefault();
                    updateRole();
                });
            @endcan

            @can ('role.manage')
                $("#form-manage-role").on("submit", function(e) {
                    e.preventDefault();
                    manageRole();
                });
            @endcan
        });

        async function getRoles()
        {
            $("#role-list").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.role.data') }}",
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'default_user' },
                    { data: 'login_destination' },
                    { data: 'action' },
                ]
            });
        }

        @can ('role.create')
            async function addRole()
            {
                var formData = $("#form-add-role").serialize();

                $.ajax({
                    url: "{{ route('admin.role.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-add-role").addClass('btn-progress');
                        $("#btn-add-role").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-add-role").removeClass('btn-progress');
                        $("#btn-add-role").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-add-role")[0].reset();
                            $('#modal-add-role').modal('hide');
                            getRoles();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can ('role.update')
            async function getUpdateRole(obj)
            {
                var id = $(obj).data('id');

                $('#modal-update-role').modal('show');
                $('#form-update-role')[0].reset();

                $.ajax({
                    url: "{{ route('admin.role.edit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-update-role").addClass('btn-progress');
                        $("#btn-update-role").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-role").removeClass('btn-progress');
                        $("#btn-update-role").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        $('#update-role-id').val(result['data']['id']);
                        $('#update-role-name').val(result['data']['name']);
                        $('#update-role-login-destination').val(result['data']['login_destination']);
                    }
                });
            }

            async function updateRole()
            {
                var formData = $("#form-update-role").serialize();

                $.ajax({
                    url: "{{ route('admin.role.update') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-update-role").addClass('btn-progress');
                        $("#btn-update-role").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-role").removeClass('btn-progress');
                        $("#btn-update-role").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-update-role")[0].reset();
                            $('#modal-update-role').modal('hide');
                            getRoles();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
            async function setDefault(object)
            {
                var id = $(object).data('id');
                Swal.fire({
                    title: 'Anda yakin mengubah default peran?',
                    text: 'Setelah diubah, semuanya data akan tersinkron',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, ubah default peran!',
                    showLoaderOnConfirm:true,
                    preConfirm: () => {
                        ajax =  $.ajax({
                                    url: "{{ route('admin.role.default') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        "id": id,
                                        "_method": "POST",
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success : function(result) {
                                        if(result['status'] == 'success'){
                                            getRoles();
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

        @can('role.manage')
            async function getManageRole(obj)
            {
                var id = $(obj).data('id');
                $('#modal-manage-role').modal('show');
                $("#view-manage-role").html('<h4 class="text-center my-4">Loading . . .</h4>');

                $.ajax({
                    url: "{{ route('admin.role.manage.get') }}",
                    type: "POST",
                    dataType: "html",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-manage-role").addClass('btn-progress');
                        $("#btn-manage-role").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("button").removeAttr('disabled', 'disabled');
                        $("#btn-manage-role").removeAttr('disabled', 'disabled');
                        $("#btn-manage-role").removeClass('btn-progress');
                    },
                    success : function(result) {
                        $("#view-manage-role").html(result);
                    }
                });
            }
            async function manageRole()
            {
                var formData = $("#form-manage-role").serialize();

                $.ajax({
                    url: "{{ route('admin.role.manage') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-manage-role").addClass('btn-progress');
                        $("#btn-manage-role").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-manage-role").removeClass('btn-progress');
                        $("#btn-manage-role").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-manage-role")[0].reset();
                            $('#modal-manage-role').modal('hide');
                            getRoles();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can('role.delete')
            async function deleteRole(object)
            {
                var id = $(object).data('id');
                Swal.fire({
                    title: 'Anda yakin menghapus peran?',
                    text: 'Setelah dihapus, Anda tidak dapat memulihkannya kembali',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus peran!',
                    showLoaderOnConfirm:true,
                    preConfirm: () => {
                        ajax =  $.ajax({
                                    url: "{{ route('admin.role.destroy') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        "id": id,
                                        "_method": "DELETE",
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success : function(result) {
                                        if(result['status'] == 'success'){
                                            getRoles();
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
