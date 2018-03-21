<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="title" content=@yield('metatitle') />
    <meta name="description" content="@yield('metadescription')" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Pagetitle" />
    <meta property="og:title" content="@yield('metatitle')" />
    <meta property="og:description" content="@yield('metadescription')" />
    <meta name="twitter:card" content="website" />
    <meta name="twitter:site" content="Pagetitle" />
    <meta name="twitter:title" content="@yield('metatitle')" />
    <meta name="twitter:description" content="@yield('metadescription')" />
    <title itemprop="name">@yield('title')</title>
    @include('public.themes.trtheme.partials.styles')
</head>
<body>
    @include('public.themes.trtheme.partials.navigation')
    @yield('content')
    @include('public.themes.trtheme.partials.scripts')
</body>
</html>