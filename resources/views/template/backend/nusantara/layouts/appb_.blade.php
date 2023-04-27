<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    @if ($global_option != '0')

        @if ($global_option->meta_description)
            <meta name="description" content="{{ $global_option->meta_description }}">
        @else
            <meta name="description"
                content="Digital Nusantara, Digital Nusantara Borneo, Borneo, Digital, Nusantara, Kaltim">
        @endif

        @if ($global_option->meta_keywords)
            <meta name="keywords" content="{{ $global_option->meta_keywords }}">
        @else
            <meta name="keywords"
                content="Digital Nusantara, Digital Nusantara Borneo, Borneo, Digital, Nusantara, Kaltim">
        @endif
        @if ($global_option->favicon)
            <link rel="icon" href="{{ asset('') }}uploads/images/logo/{{ $global_option->favicon }}">
        @else
            <link rel="icon" href="{{ asset('') }}uploads/images/logo/favicon.png">
        @endif
    @elseif ($global_option == '0')
        <meta name="description"
            content="Digital Nusantara, Digital Nusantara Borneo, Borneo, Digital, Nusantara, Kaltim">
        <meta name="keywords" content="Kodir Zaelani, digitan nusantara, digtal ">
        <link rel="icon" href="{{ asset('') }}uploads/images/logo/favicon.png">
    @endif

    <title>@yield('title')</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('') }}assets/backend/nusantara/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('') }}assets/backend/nusantara/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/backend/nusantara/css/skin_color.css">
    @stack('styles')
    @livewireStyles
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

        @livewire('template.backend.nusantara.partials.header')
        @livewire('template.backend.nusantara.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                @yield('content')
                {{ isset($slot) ? $slot : null }}
                <!-- /.content -->
            </div>
        </div>
        @livewire('template.backend.nusantara.partials.footer')
        @livewire('template.backend.nusantara.partials.controlsidebar')

    </div>
    @livewire('template.backend.nusantara.partials.chatbox')

    <!-- ./wrapper -->
    <!-- Vendor JS -->
    <script src="{{ asset('') }}assets/backend/nusantara/js/vendors.min.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/js/pages/chat-popup.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/icons/feather-icons/feather.min.js"></script>

    {{-- <script src="{{ asset('') }}assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script> --}}
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_plugins/input-mask/jquery.inputmask.js"></script>
    <script
        src="{{ asset('') }}assets/backend/nusantara/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js">
    </script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_plugins/input-mask/jquery.inputmask.extensions.js">
    </script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_components/moment/min/moment.min.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_plugins/input-mask/jquery.inputmask.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_plugins/iCheck/icheck.min.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_components/sweetalert/sweetalert.min.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/vendor_components/sweetalert/jquery.sweet-alert.custom.js">
    </script>

    <!-- EduAdmin App -->
    <script src="{{ asset('') }}assets/backend/nusantara/js/template.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/js/pages/dashboard.js"></script>
    <script src="{{ asset('') }}assets/backend/nusantara/js/pages/calendar.js"></script>
    @stack('scripts')
    <script>
        //  Open modal delete
        window.addEventListener('openDeleteModal', event => {
            $("#modalFormDelete").modal('show');
        });

        //  Close modal delete
        window.addEventListener('closeDeleteModal', event => {
            $("#modalFormDelete").modal('hide');
        });

        //  Open modal restore
        window.addEventListener('openRestoreModal', event => {
            $("#modalFormRestore").modal('show');
        });

        //  Close modal restore
        window.addEventListener('closeRestoreModal', event => {
            $("#modalFormRestore").modal('hide');
        });

        //  Close modal deleteall
        window.addEventListener('closeDeleteModalAll', event => {
            $("#modalFormDeleteAll").modal('hide');
        });

        //Save Draft
        $('#draft-btn').click(function(e) {
            e.preventDefault();
            $('#status').val(0);
            $('#post-form').submit();
        });
        //Save Publish
        $('#publish-btn').click(function(e) {
            e.preventDefault();
            $('#status').val(1);
            $('#post-form').submit();
        });

        //flash message
        @if (session()->has('success'))
            swal("SUCCESS!", "{{ session('success') }}", "success");
        @elseif (session()->has('error'))
            swal("SUCCESS!", "{{ session('error') }}", "error");
        @endif
    </script>
    @livewireScripts
</body>

</html>
