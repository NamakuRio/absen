@extends('templates.master')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="section-header">
        <h1>Izin</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
            <div class="breadcrumb-item">Izin</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Izin</h4>
                        @can ('permission.create')
                            <div class="card-header-action">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="$('#modal-add-permission').modal('show');setTimeout(() => {$('#add-role-name').focus()},500)" tooltip="Tambah Izin"><i class="fas fa-plus"></i> Tambah Izin</a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="permission-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10">
                                            #
                                        </th>
                                        <th>Nama</th>
                                        <th>Guard Name</th>
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
    @can ('permission.create')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-permission">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Izin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-add-permission">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="add-role-name" required autofocus>
                                </div>
                                <div class="form-group col-12">
                                    <label>Guard Name</label>
                                    <input type="text" class="form-control" name="guard_name" id="add-role-guard-name" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-add-permission">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('permission.update')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-update-permission">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Izin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-update-permission">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="" id="update-permission-id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="update-permission-name" required autofocus>
                                </div>
                                <div class="form-group col-12">
                                    <label>Guard Name</label>
                                    <input type="text" class="form-control" name="guard_name" id="update-permission-guard-name" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-update-permission">Simpan Perubahan</button>
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

            getPermissions();

            @can ('permission.create')
                $("#form-add-permission").on("submit", function(e) {
                    e.preventDefault();
                    addPermission();
                });
            @endcan

            @can ('permission.update')
                $("#form-update-permission").on("submit", function(e) {
                    e.preventDefault();
                    updatePermission();
                });
            @endcan
        });

        async function getPermissions()
        {
            $("#permission-list").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.permission.data') }}",
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'guard_name' },
                    { data: 'action' },
                ]
            });
        }

        @can ('permission.create')
            async function addPermission()
            {
                var formData = $("#form-add-permission").serialize();

                $.ajax({
                    url: "{{ route('admin.permission.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-add-permission").addClass('btn-progress');
                        $("#btn-add-permission").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-add-permission").removeClass('btn-progress');
                        $("#btn-add-permission").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-add-permission")[0].reset();
                            $('#modal-add-permission').modal('hide');
                            getPermissions();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can ('permission.update')
            async function getUpdatePermission(obj)
            {
                var id = $(obj).data('id');

                $('#modal-update-permission').modal('show');
                $('#form-update-permission')[0].reset();

                $.ajax({
                    url: "{{ route('admin.permission.edit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-update-permission").addClass('btn-progress');
                        $("#btn-update-permission").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-permission").removeClass('btn-progress');
                        $("#btn-update-permission").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        $('#update-permission-id').val(result['data']['id']);
                        $('#update-permission-name').val(result['data']['name']);
                        $('#update-permission-guard-name').val(result['data']['guard_name']);
                    }
                });
            }

            async function updatePermission()
            {
                var formData = $("#form-update-permission").serialize();

                $.ajax({
                    url: "{{ route('admin.permission.update') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-update-permission").addClass('btn-progress');
                        $("#btn-update-permission").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-permission").removeClass('btn-progress');
                        $("#btn-update-permission").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-update-permission")[0].reset();
                            $('#modal-update-permission').modal('hide');
                            getPermissions();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can('permission.delete')
            async function deletePermission(object)
            {
                var id = $(object).data('id');
                Swal.fire({
                    title: 'Anda yakin menghapus izin?',
                    text: 'Setelah dihapus, Anda tidak dapat memulihkannya kembali',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus izin!',
                    showLoaderOnConfirm:true,
                    preConfirm: () => {
                        ajax =  $.ajax({
                                    url: "{{ route('admin.permission.destroy') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        "id": id,
                                        "_method": "DELETE",
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success : function(result) {
                                        if(result['status'] == 'success'){
                                            getPermissions();
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
