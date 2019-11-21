@extends('templates.master')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="section-header">
        <h1>Jenis Kehadiran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
            <div class="breadcrumb-item">Jenis Kehadiran</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Jenis Kehadiran</h4>
                        @can ('presence_type.create')
                            <div class="card-header-action">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="$('#modal-add-presence-type').modal('show');setTimeout(() => {$('#add-presence-type-name').focus()},500)" tooltip="Tambah Jenis Kehadiran"><i class="fas fa-plus"></i> Tambah Jenis Kehadiran</a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="presence-type-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10">
                                            #
                                        </th>
                                        <th>Nama</th>
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
    @can ('presence_type.create')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-presence-type">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Izin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-add-presence-type">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="add-presence-type-name" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-add-presence-type">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('presence_type.update')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-update-presence-type">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Jenis Kehadiran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-update-presence-type">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="" id="update-presence-type-id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" id="update-presence-type-name" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-update-presence-type">Simpan Perubahan</button>
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

            getPresenceTypes();

            @can ('presence_type.create')
                $("#form-add-presence-type").on("submit", function(e) {
                    e.preventDefault();
                    addPresenceType();
                });
            @endcan

            @can ('presence_type.update')
                $("#form-update-presence-type").on("submit", function(e) {
                    e.preventDefault();
                    updatePresenceType();
                });
            @endcan
        });

        async function getPresenceTypes()
        {
            $("#presence-type-list").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.presence_type.data') }}",
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'action' },
                ]
            });
        }

        @can ('presence_type.create')
            async function addPresenceType()
            {
                var formData = $("#form-add-presence-type").serialize();

                $.ajax({
                    url: "{{ route('admin.presence_type.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-add-presence-type").addClass('btn-progress');
                        $("#btn-add-presence-type").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-add-presence-type").removeClass('btn-progress');
                        $("#btn-add-presence-type").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-add-presence-type")[0].reset();
                            $('#modal-add-presence-type').modal('hide');
                            getPresenceTypes();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can ('presence_type.update')
            async function getUpdatePresenceType(obj)
            {
                var id = $(obj).data('id');

                $('#modal-update-presence-type').modal('show');
                $('#form-update-presence-type')[0].reset();

                $.ajax({
                    url: "{{ route('admin.presence_type.edit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-update-presence-type").addClass('btn-progress');
                        $("#btn-update-presence-type").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-presence-type").removeClass('btn-progress');
                        $("#btn-update-presence-type").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        $('#update-presence-type-id').val(result['data']['id']);
                        $('#update-presence-type-name').val(result['data']['name']);
                    }
                });
            }

            async function updatePresenceType()
            {
                var formData = $("#form-update-presence-type").serialize();

                $.ajax({
                    url: "{{ route('admin.presence_type.update') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-update-presence-type").addClass('btn-progress');
                        $("#btn-update-presence-type").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-presence-type").removeClass('btn-progress');
                        $("#btn-update-presence-type").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-update-presence-type")[0].reset();
                            $('#modal-update-presence-type').modal('hide');
                            getPresenceTypes();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can('permission.delete')
            async function deletePresenceType(object)
            {
                var id = $(object).data('id');
                Swal.fire({
                    title: 'Anda yakin menghapus jenis kehadiran?',
                    text: 'Setelah dihapus, Anda tidak dapat memulihkannya kembali',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus jenis kehadiran!',
                    showLoaderOnConfirm:true,
                    preConfirm: () => {
                        ajax =  $.ajax({
                                    url: "{{ route('admin.presence_type.destroy') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        "id": id,
                                        "_method": "DELETE",
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success : function(result) {
                                        if(result['status'] == 'success'){
                                            getPresenceTypes();
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
