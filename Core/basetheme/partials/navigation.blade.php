<header class="header {{$themesettings['header_layout']}}">
      <div class="container">
        <a class="header__logo" href="/"><img src="{{$themesettings['logo']}}" alt="{{$settings['sitetitle']}}"></a>
          <nav class="header__main-nav">
              <ul>
                  @foreach ($mainmenupages as $page)
              <li class="header__main-nav-item {{checkIfNavItemIsActive($page['slug']) ? 'active' : ''}}"><a class="header__main-nav-item-link" href="/{{$currentpubliclanguage['iso']}}/{{$page['slug']}}">{{$page['name']}}</a></li>
                  @endforeach
              </ul>
          </nav>
      </div>
  </header>