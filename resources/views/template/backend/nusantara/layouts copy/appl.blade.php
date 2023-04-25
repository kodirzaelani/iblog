<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    @if ($global_option <> '0')
    @if ($global_option->favicon)
    <link rel="icon" href="{{ asset('') }}uploads/images/logo/{{ $global_option->favicon }}">
    @else
    {{-- <link rel="icon" href="{{ asset('') }}uploads/images/logo/webicon.ico"> --}}
    <link rel="icon" href="{{ asset('') }}uploads/images/logo/favicon.png">
    @endif
    @elseif ($global_option == '0')
    {{-- <link rel="icon" href="{{ asset('') }}uploads/images/logo/webicon.ico"> --}}
    <link rel="icon" href="{{ asset('') }}uploads/images/logo/favicon.png">
    @endif

    <title>@yield('title')</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('') }}assets/backend/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('') }}assets/backend/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/backend/css/skin_color.css">

</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url({{ asset('') }}assets/images/auth-bg/bg-1.jpg)">

    <div class="container h-p100">
        <!-- Main content -->
        @yield('content')
        {{ isset($slot) ? $slot : null}}
    </div>

    <!-- Page Content overlay -->
    <!-- Vendor JS -->
    <script src="{{ asset('') }}assets/backend/js/vendors.min.js"></script>
    <script src="{{ asset('') }}assets/backend/js/pages/chat-popup.js"></script>
    <script src="{{ asset('') }}assets/icons/feather-icons/feather.min.js"></script>


</body>
</html>
