<header class="header {{$themesettings['header_layout']}}">
    <div class="container">
        @if($white_logo_active === '1')
        <a class="header__logo" href="/"><img src="{{$themesettings['logo_white']}}" alt="{{$settings['sitetitle']}}"></a>
        @else
        <a class="header__logo" href="/"><img src="{{$themesettings['logo']}}" alt="{{$settings['sitetitle']}}"></a>
        @endif
        <nav class="header__main-nav">
            <ul>
                @foreach ($mainmenupages as $page)
                @if($page['language_id'] === $currentpubliclanguage['id'])
                    <li class="header__main-nav-item {{checkIfNavItemIsActive($page['slug']) ? 'active' : ''}} {{$page['css_class']}}"><a class="header__main-nav-item-link" href="/{{$currentpubliclanguage['iso']}}/{{$page['slug']}}">{{$page['name']}}</a></li>
                @endif
                @endforeach
            </ul>
        </nav>
    </div>
</header>