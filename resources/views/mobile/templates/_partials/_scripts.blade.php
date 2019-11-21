<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
{{-- <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@yield('js-library')

<!-- Page Specific JS File -->
@yield('js-page')

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
    async function notification(icon, title, position = "top-end", showConfirmButton = false, timer = 3000, timerProgressBar = true)
    {
        const Toast = Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: showConfirmButton,
            timer: timer,
            timerProgressBar: timerProgressBar,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: icon,
            title: title
        });
    }

    async function swalNotification(status, message)
    {
        swal(message, {
            icon: status,
        });
    }
</script>

@yield('js-script')
