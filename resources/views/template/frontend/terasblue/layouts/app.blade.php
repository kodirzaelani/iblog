<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('') }}assets/frontend/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/frontend/css/variables-blue.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/frontend/css/style.css">
    <title>Home</title>
    @livewireStyles
</head>

<body>

    @livewire('template.frontend.terasblue.partials.header')
    @yield('content')
    {{ isset($slot) ? $slot : null }}
    @livewire('template.frontend.terasblue.partials.footer')

    <script src="{{ asset('') }}assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/frontend/js/template.js"></script>
    @livewireScripts
</body>

</html>
