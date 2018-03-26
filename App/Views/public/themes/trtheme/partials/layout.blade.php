<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="title" content="{{$settings['sitetitle']}} - @yield('metatitle')" />
    <meta name="description" content="@yield('metadescription')" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{$settings['sitetitle']}}" />
    <meta property="og:title" content="{{$settings['sitetitle']}} - @yield('metatitle')" />
    <meta property="og:description" content="@yield('metadescription')" />
    <meta name="twitter:card" content="website" />
    <meta name="twitter:site" content="{{$settings['sitetitle']}}" />
    <meta name="twitter:title" content="{{$settings['sitetitle']}} - @yield('metatitle')" />
    <meta name="twitter:description" content="@yield('metadescription')" />
    <title itemprop="name">@yield('title')</title>

    <link rel="apple-touch-icon" sizes="256x256" href="{{$themesettings['favicon']}}"/>
    <link rel="icon" type="image/png" sizes="256x256" href="{{$themesettings['favicon']}}"/>

    @include('public.themes.' . $activetheme . '.partials.styles')
    {{$themesettings['custom_styles']}}
    {{$themesettings['google_font']}}
    {{$themesettings['header_code']}}
    {{$themesettings['google_analytics']}}
   </head>
   <body class="{{$themesettings['fixed_navigation'] ? 'fixed' : ''}}">
      @if($themesettings['to_top'])
         <a href="">To Top</a>
      @endif
      {{$themesettings['body_code']}}

    @include('public.themes.' . $activetheme . '.partials.navigation')
    <div id="content">
       @yield('content')
    </div>
    @include('public.themes.' . $activetheme . '.partials.scripts')
    {{$themesettings['custom_scripts']}}
    <footer id="footer">
       <div class="container">
          @if(sizeof($footercols) > 0)
          @foreach($footercols as $footercol)
             <div>
                <div>{{$footercol['title']}}</div>
                <div>{{$footercol['html']}}</div>
             </div>
          @endforeach
        @endif
       </div>
    </footer>
</body>
</html>