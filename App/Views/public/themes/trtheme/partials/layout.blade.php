<!DOCTYPE html>
<html lang="{{$currentpubliclanguage['iso']}}">
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
    <title itemprop="name">{{$settings['sitetitle']}} - @yield('title')</title>

    <link rel="apple-touch-icon" sizes="256x256" href="{{$themesettings['favicon']}}"/>
    <link rel="icon" type="image/png" sizes="256x256" href="{{$themesettings['favicon']}}"/>

    @include('public.themes.' . $activetheme . '.partials.styles')
    {{$themesettings['custom_styles']}}
    {{$themesettings['google_font']}}
    {{$themesettings['header_code']}}
    {{$themesettings['google_analytics']}}
   </head>
   <body class="{{$currentpubliclanguage['iso']}} {{$user ? 'logged-in' : ''}}{{$themesettings['fixed_navigation'] ? 'fixed' : ''}} {{isset($id) ? 'page-id-' . $id : 'home'}}">
      @if($user)
      <div class="admin-bar">
         <ul>
            <li><a target="_blank" href="/admin/dashboard">{{$settings['sitetitle']}}</a></li>
            <li><a target="_blank" href="/admin/pages/{{$id}}/edit">Edit Page</a></li>
            <li><a target="_blank" href="/admin/settings">Maintenance Mode: {{$settings['maintenance_mode'] ? ' On' : ' Off'}}</a></li>
         </ul>
         <ul>
         <li><a target="_blank" href="/admin/users/{{$user['name']}}">Hey, {{$user['name']}}!</a></li>
         </ul>
      </div>
      @endif
      @if($themesettings['to_top'])
         <a href="">To Top</a>
      @endif
      {{$themesettings['body_code']}}

    @include('public.themes.' . $activetheme . '.partials.navigation')
    <div id="content">
       @yield('content')
    </div>
    {{$themesettings['custom_scripts']}}
    <footer id="footer">
       <div class="container">
          @if(sizeof($footercols) > 0)
          @foreach($footercols as $footercol)
             <div>
                <div>{{$footercol['title']}}</div>
                <div>{!! trim($footercol['html']) !!}</div>
             </div>
          @endforeach
        @endif
        <select id="changePublicLang" name="publicLang">
            @foreach($publiclanguages as $lang)
              <option value="{{$lang['iso']}}" {{$lang['id'] === $currentpubliclanguage['id'] ? 'selected' : ''}}>{{$lang['name']}}</option>
          @endforeach
        </select>
       </div>
    </footer>
    <footer id="footer-bottom">
      <div class="container">
          {!! trim($themesettings['footer_bottom']) !!}
      </div>
    </footer>
    @include('public.themes.' . $activetheme . '.partials.scripts')
</body>
</html>