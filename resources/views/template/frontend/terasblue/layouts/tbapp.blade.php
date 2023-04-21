<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/frontend/css/style.css">
    <title>Home</title>
    @livewireStyles
</head>

<body style="background:#e2e8f0">

    @livewire('template.frontend.terasblue.partials.header')
    @yield('content')
    {{ isset($slot) ? $slot : null }}
    @livewire('template.frontend.terasblue.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>
