@extends('templates.auth')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                <div class="card card-primary">
                    <div class="card-header"><h4>Masuk</h4></div>

                    <div class="card-body">
                        <form method="POST" action="javascript:void(0)" class="needs-validation" novalidate="" id="form-login">
                            @csrf
                            <div class="form-group">
                                <label for="username">Nama Pengguna</label>
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" tabindex="1" required autofocus autocomplete="off">
                                <div class="invalid-feedback">
                                    Silakan isi nama pengguna Anda
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Kata Sandi</label>
                                    @if (Route::has('password.request'))
                                    <div class="float-right">
                                        <a href="{{ route('password.request') }}" class="text-small">
                                            Lupa Kata Sandi?
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                <input id="password" type="password" class="form-control" name="password" tabindex="2" required autocomplete="off">
                                <div class="invalid-feedback">
                                    Silakan isi kata sandi Anda
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                    <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="btn-login">
                                    Login
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
                @if (Route::has('login'))
                <div class="mt-5 text-muted text-center">
                    Belum memiliki akun? <a href="{{ route('register') }}">Daftar</a>
                </div>
                @endif
                <div class="simple-footer">
                    {{ date('Y') }} &copy; {{ $app_name }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        var url = "{{ url('/') }}";

        $(document).ready(function () {
            $("#form-login").on("submit", function(e) {
                e.preventDefault();

                if($("#username").val().length == 0 || $("#password").val().length == 0){
                    notification('warning', 'Harap isi semua field.');
                    return false;
                }

                login();
            });
        });

        async function login()
        {
            var formData = $("#form-login").serialize();

            $.ajax({
                url: "{{ route('login') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                beforeSend() {
                    $("#btn-login").addClass('btn-progress');
                    $("input").attr('disabled', 'disabled');
                    $("#btn-login").attr('disabled', 'disabled');
                },
                complete() {
                    $("input").removeAttr('disabled', 'disabled');
                    $("#btn-login").removeAttr('disabled', 'disabled');
                    $("#btn-login").removeClass('btn-progress');
                },
                success : function(result) {
                    notification(result['status'], result['msg']);

                    $("#username").focus();

                    if(result['status'] == 'success'){
                        window.location=url+result['redirect'];
                    }
                }
            });
        }
    </script>
@endsection
