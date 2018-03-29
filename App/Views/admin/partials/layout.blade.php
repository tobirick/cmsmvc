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
    @include('admin.partials.sidebar')
    <div class="main-content">
        <div class="main-content__header">
            <div class="main-content__toggle-sidebar">
                <span></span>
                <span></span>
                <span></span>
            </div>
                <h2>@yield('content-title')</h2>
                @if(isset($user['name']))
                <div class="main-content__header-info">
                    <a href="/admin/logout">Logout</a>
                    <a href="/{{$curLang}}/admin/users/{{$user['name']}}">{{$user['name']}}</a>
                </div>
                @endif
        </div>

        @yield('content')
    </div>
    <input type="hidden" id="csrftoken" value="{{$csrf}}">
    @include('admin.partials.scripts')
</body>
</html>