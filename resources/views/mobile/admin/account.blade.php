@extends('templates.master')

@section('content')
<div class="section-header">
    <h1>Akun</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
        <div class="breadcrumb-item">Akun</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Hai, {{ auth()->user()->name }}!</h2>
    <p class="section-lead">
        Ubah informasi tentang diri Anda di halaman ini.
    </p>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" class="needs-validation" novalidate="" action="javascript:void(0)" id="form-update-account" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4>Perbarui Akun</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-6 col-12">
                                <label>Nama Pengguna</label>
                                <input type="text" class="form-control" name="username" value="{{ auth()->user()->username }}" required="" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required="" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>No HP</label>
                                <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone }}" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Kata Sandi</label>
                                <input type="password" class="form-control" name="password" placeholder="Kosongkan password jika tidak ingin diubah" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Konfirmasi Kata Sandi</label>
                                <input type="password" class="form-control" name="password_confirmation" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label>Foto Profil</label>
                                <div id="update-photo-preview" class="image-preview">
                                    <label for="update-photo-upload" id="update-photo-label">Pilih Gambar</label>
                                    <input type="file" name="photo" id="update-photo-upload" />
                                </div>
                                @if (auth()->user()->photo != null)
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" id="null-photo" name="null_photo" value="1">
                                    <label class="custom-control-label" for="null-photo">Kosongkan Foto Profile</label>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" type="submit" id="btn-update-account">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-library')
<script src="{{ asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
@endsection

@section('js-script')
<script>

    $(function() {
        "use strict";

        imagePreview();
        $('#update-photo-preview').css('background', `url('{{ auth()->user()->photo == null ? asset('uploads/user/photo/default.png') : asset(auth()->user()->photo) }}') center center / cover transparent`);

        $("#form-update-account").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            updateAccount(formData);
        });
    });

    async function imagePreview()
    {
        $.uploadPreview({
            input_field: "#update-photo-upload",
            preview_box: "#update-photo-preview",
            label_field: "#update-photo-label",
            label_default: "Choose File",
            label_selected: "Change File",
            no_label: false,
            success_callback: null
        });
    }

    async function updateAccount(formData)
    {

        $.ajax({
            url: "{{ route('admin.account.update') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend() {
                $("input").attr('disabled', 'disabled');
                $("#btn-update-account").addClass('btn-progress');

            },
            complete() {
                $("input").removeAttr('disabled', 'disabled');
                $("#btn-update-account").removeClass('btn-progress');
            },
            success : function(result) {
                $('input[type="password"]').val('');

                notification(result['status'], result['msg']);

                if(result['status'] == 'success'){
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
@endsection
