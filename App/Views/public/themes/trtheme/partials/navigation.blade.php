<header class="header">
    <div class="container">
        <a class="header__logo" href="/">PP<span>CMS</span></a>
        <nav class="header__main-nav">
            <ul>
                @foreach ($pages as $page)
                    <li class="header__main-nav-item {{checkIfNavItemIsActive($page['slug']) ? 'active' : ''}}"><a class="header__main-nav-item-link" href={{$page['slug']}}>{{$page['name']}}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>