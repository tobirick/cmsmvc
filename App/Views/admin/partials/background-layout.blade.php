<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('admin.partials.styles')
</head>
<body>
    <div id="particles-js"></div>
        @yield('content')
    @include('admin.partials.scripts')
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/admin/particles.json', function() {
            console.log('callback - particles.js config loaded');
        });
    </script>
</body>
</html>