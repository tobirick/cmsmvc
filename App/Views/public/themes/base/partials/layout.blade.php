<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('public.themes.trtheme.partials.styles')
</head>
<body>
    @include('public.themes.trtheme.partials.navigation')
    @yield('content')
    @include('public.themes.trtheme.partials.scripts')
</body>
</html>