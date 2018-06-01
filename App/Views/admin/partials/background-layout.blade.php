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
        @if(isset($flash))
        @include('admin.components.flash')
    @endif
    <div id="particles-js"></div>
        @yield('content')
   <input type="hidden" id="csrftoken" value="{{$csrf}}">
    @include('admin.partials.scripts')
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/admin/particles.json');
    </script>
</body>
</html>