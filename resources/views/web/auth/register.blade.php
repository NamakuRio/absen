@extends('templates.auth')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">

                <div class="card card-primary">
                    <div class="card-header"><h4>Daftar</h4></div>

                    <div class="card-body">
                        <form method="POST" action="javascript:void(0)" class="needs-validation" novalidate="" id="form-register">
                            @csrf

                            <div class="row">
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="username">Nama Pengguna</label>
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" tabindex="1" required autofocus autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silakan isi nama pengguna Anda
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="name">Nama</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" tabindex="2" required autocomplete="off" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silakan isi nama Anda
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" tabindex="3" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silakan isi email Anda
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="password" class="d-block">Kata Sandi</label>
                                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" tabindex="4" required autocomplete="off">
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Silakan isi nama pengguna Anda
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-sm-12">
                                    <div class="d-block">
                                        <label for="password-confirm" class="control-label">Konfirmasi Kata Sandi</label>
                                    </div>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" tabindex="5" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silakan isi konfirmasi kata sandi Anda
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label>Jenis Kelamin</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="gender" id="gender-l" value="L" class="selectgroup-input" checked="" required>
                                            <span class="selectgroup-button">Laki - laki</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="gender" id="gender-p" value="P" class="selectgroup-input" required>
                                            <span class="selectgroup-button">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="date-of-birth">Tanggal Lahir</label>
                                    <input type="text" id="date-of-birth" class="form-control datepicker" value="{{ old('date_of_birth') }}" name="date_of_birth" required autocomplete="off" tabindex="6">
                                    <div class="invalid-feedback">
                                        Silakan isi Tanggal lahir Anda
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="education">Pendidikan</label>
                                    <select name="education" id="education" class="form-control selectric" required autocomplete="off" tabindex="7">
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="DIPLOMA">DIPLOMA</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="job">Pekerjaan</label>
                                    <input type="text" id="job" class="form-control" name="job" required autocomplete="off" tabindex="8">
                                    <div class="invalid-feedback">
                                        Silakan isi Pekerjaan Anda
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                                    <label class="custom-control-label" for="agree">Saya setuju dengan syarat dan ketentuan</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="9" id="btn-register">
                                    Daftar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
                @if (Route::has('login'))
                <div class="mt-5 text-muted text-center">
                    Sudah memiliki akun? <a href="{{ route('login') }}">Login</a>
                </div>
                @endif
                <div class="simple-footer">
                    {{ date('Y') }} &copy; {{ $app_name }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-library')
    <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
@endsection

@section('js-script')
    <script>
        var url = "{{ url('/') }}";

        $(document).ready(function () {
            $(".pwstrength").pwstrength();

            $("#form-register").on("submit", function(e) {
                e.preventDefault();

                if($("#username").val().length == 0
                || $("#name").val().length == 0
                || $("#email").val().length == 0
                || $("#password").val().length == 0
                || $("#password-confirm").val().length == 0
                || $("#date-of-birth").val().length == 0
                || $("#education").val().length == 0
                || $("#job").val().length == 0){
                    return false;
                }

                if($("#password").val() != $('#password-confirm').val()){
                    notification('warning', 'Warning!', 'Password yang Anda masukkan tidak sama');
                    return false;
                }

                register();
            });
        });

        async function register()
        {
            var formData = $("#form-register").serialize();

            $.ajax({
                url: "{{ route('register') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                beforeSend() {
                    $("#btn-register").addClass('btn-progress');
                    $("input").attr('disabled', 'disabled');
                    $("#btn-register").attr('disabled', 'disabled');
                },
                complete() {
                    $("input").removeAttr('disabled', 'disabled');
                    $("#btn-register").removeAttr('disabled', 'disabled');
                    $("#btn-register").removeClass('btn-progress');
                },
                success : function(result) {
                    notification(result['status'], result['title'], result['msg']);

                    $("#username").focus();

                    if(result['status'] == 'success'){
                        $("#form-register")[0].reset();
                        window.location="{{ route('login') }}";
                    }
                }
            });
        }
    </script>
@endsection

