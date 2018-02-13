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
    @include('admin.partials.sidebar')
    <div class="main-content">
        <div class="main-content__header">
            <div class="main-content__toggle-sidebar">
                <span></span>
                <span></span>
                <span></span>
            </div>
                <h2>@yield('content-title')</h2>
                <div class="main-content__header-info">
                    <a href="/admin/logout">Logout</a>
                    <a href="/admin/users/{{$user['name']}}">{{$user['name']}}</a>
                </div>
        </div>

        @yield('content')
    </div>
    @include('admin.partials.scripts')
</body>
</html>