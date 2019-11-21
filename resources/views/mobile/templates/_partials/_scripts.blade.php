<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
@yield('js-library')

<!-- Page Specific JS File -->
@yield('js-page')

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
    async function notification(status, titleToast, messageToast)
    {
        if(status == 'success'){
            iziToast.success({
                title: titleToast,
                message: messageToast,
                position: 'topRight'
            });
        }

        if(status == 'warning'){
            iziToast.warning({
                title: titleToast,
                message: messageToast,
                position: 'topRight'
            });
        }

        if(status == 'error'){
            iziToast.error({
                title: titleToast,
                message: messageToast,
                position: 'topRight'
            });
        }
    }

    async function swalNotification(status, message)
    {
        swal(message, {
            icon: status,
        });
    }
</script>

@yield('js-script')
