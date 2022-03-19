<script>
    toastr.option = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    @if($errors->any())
        @foreach($errors->all() as $error) 
            toastr.error("{{ $error }}")
        @endforeach
    @endif 
    @if(session()->has('danger'))
        toastr.error("{{ session('danger') }}")
    @endif
    @if(session()->has('success'))
        toastr.success("{{ session('success') }}")
    @endif
    @if (session()->has('info'))
        toastr.info("{{ session('info') }}")
    @endif 
    @if (session()->has('warning'))
        toastr.warning("{{ session('warning') }}")
    @endif
</script>