@extends('templates.master')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
@endsection

@section('content')
    <div class="section-header">
        <h1>Karyawan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
            <div class="breadcrumb-item">Karyawan</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Karyawan</h4>
                        @can ('employee.create')
                            <div class="card-header-action">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="openModal();" tooltip="Tambah Karyawan"><i class="fas fa-plus"></i> Tambah Karyawan</a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="employee-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10">
                                            #
                                        </th>
                                        <th>NIP</th>
                                        <th>Nama Pengguna</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Hp</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Agama</th>
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
    @can ('employee.create')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-employee">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-add-employee">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
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
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>No HP</label>
                                    <input type="text" class="form-control" name="phone" id="add-user-phone" required>
                                </div>
                                <div class="divider"></div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" name="nip" id="add-employee-nip" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Jenis Kelamin</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="gender" id="add-employee-gender-l" value="L" class="selectgroup-input" checked="" required>
                                            <span class="selectgroup-button">Laki - laki</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="gender" id="add-employee-gender-p" value="P" class="selectgroup-input" required>
                                            <span class="selectgroup-button">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="address" id="add-employee-address" cols="30" rows="10" required></textarea>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Agama</label>
                                    <select name="religion" id="add-employee-religion" class="form-control selectric" required>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-add-employee">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can ('employee.update')
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-update-employee">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="javascript:void(0)" id="form-update-employee">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="" id="update-employee-id">
                        <div class="modal-body">
                            <div class="row">
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
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>No HP</label>
                                    <input type="text" class="form-control" name="phone" id="update-user-phone" required>
                                </div>
                                <div class="divider"></div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" name="nip" id="update-employee-nip" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Jenis Kelamin</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="gender" id="update-employee-gender-l" value="L" class="selectgroup-input" checked="" required>
                                            <span class="selectgroup-button">Laki - laki</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="gender" id="update-employee-gender-p" value="P" class="selectgroup-input" required>
                                            <span class="selectgroup-button">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="address" id="update-employee-address" cols="30" rows="10" required></textarea>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <label>Agama</label>
                                    <select name="religion" id="update-employee-religion" class="form-control selectric" required>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn-update-employee">Simpan Perubahan</button>
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
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection

@section('js-script')
    <script>
        $(function () {
            "use strict";

            getEmployees();

            @can ('employee.create')
                $("#form-add-employee").on("submit", function(e) {
                    e.preventDefault();
                    addEmployee();
                });
            @endcan

            @can ('employee.update')
                $("#form-update-employee").on("submit", function(e) {
                    e.preventDefault();
                    updateEmployee();
                });
            @endcan
        });

        async function getEmployees()
        {
            $("#employee-list").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.employee.data') }}",
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'nip' },
                    { data: 'username' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'gender' },
                    { data: 'address' },
                    { data: 'religion' },
                    { data: 'action' },
                ]
            });
        }

        @can ('employee.create')
            async function openModal()
            {
                $('#modal-add-employee').modal('show');
            }

            async function addEmployee()
            {
                var formData = $("#form-add-employee").serialize();

                $.ajax({
                    url: "{{ route('admin.employee.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-add-employee").addClass('btn-progress');
                        $("#btn-add-employee").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-add-employee").removeClass('btn-progress');
                        $("#btn-add-employee").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-add-employee")[0].reset();
                            $('#modal-add-employee').modal('hide');
                            getEmployees();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can ('employee.update')
            async function getUpdateEmployee(obj)
            {
                var id = $(obj).data('id');

                $('#modal-update-employee').modal('show');
                $('#form-update-employee')[0].reset();

                $.ajax({
                    url: "{{ route('admin.employee.edit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "id": id,
                        "_method": "POST",
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend() {
                        $("#btn-update-employee").addClass('btn-progress');
                        $("#btn-update-employee").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-employee").removeClass('btn-progress');
                        $("#btn-update-employee").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        $('#update-employee-id').val(result['data']['employee']['id']);
                        $('#update-user-username').val(result['data']['user']['username']);
                        $('#update-user-name').val(result['data']['user']['name']);
                        $('#update-user-email').val(result['data']['user']['email']);
                        $('#update-user-phone').val(result['data']['user']['phone']);
                        $('#update-employee-nip').val(result['data']['employee']['nip']);
                        if(result['data']['employee']['gender'] == 'L'){
                            $('#update-employee-gender-l').prop('checked', true);
                        }
                        if(result['data']['employee']['gender'] == 'P'){
                            $('#update-employee-gender-p').prop('checked', true);
                        }
                        $('#update-employee-address').val(result['data']['employee']['address']);
                        $('#update-employee-religion').val(result['data']['employee']['religion']);
                    }
                });
            }

            async function updateEmployee()
            {
                var formData = $("#form-update-employee").serialize();

                $.ajax({
                    url: "{{ route('admin.employee.update') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    beforeSend() {
                        $("#btn-update-employee").addClass('btn-progress');
                        $("#btn-update-employee").attr('disabled', 'disabled');
                        $("input").attr('disabled', 'disabled');
                        $("select").attr('disabled', 'disabled');
                        $("button").attr('disabled', 'disabled');
                    },
                    complete() {
                        $("#btn-update-employee").removeClass('btn-progress');
                        $("#btn-update-employee").removeAttr('disabled', 'disabled');
                        $("input").removeAttr('disabled', 'disabled');
                        $("select").removeAttr('disabled', 'disabled');
                        $("button").removeAttr('disabled', 'disabled');
                    },
                    success : function(result) {
                        if(result['status'] == 'success'){
                            $("#form-update-employee")[0].reset();
                            $('#modal-update-employee').modal('hide');
                            getEmployees();
                        }

                        notification(result['status'], result['msg']);
                    }
                });
            }
        @endcan

        @can('employee.delete')
            async function deleteEmployee(object)
            {
                var id = $(object).data('id');
                Swal.fire({
                    title: 'Anda yakin menghapus karyawan?',
                    text: 'Setelah dihapus, Anda tidak dapat memulihkannya kembali',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus karyawan!',
                    showLoaderOnConfirm:true,
                    preConfirm: () => {
                        ajax =  $.ajax({
                                    url: "{{ route('admin.employee.destroy') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        "id": id,
                                        "_method": "DELETE",
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success : function(result) {
                                        if(result['status'] == 'success'){
                                            getEmployees();
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
