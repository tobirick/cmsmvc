<ul class="main-sidebar__nav">
    @if($user)
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('/' . $curLang . '/admin/dashboard') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive($curLang . '/admin/pages') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/pages"><i class="fa fa-file-o" aria-hidden="true"></i> <span>Pages</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive($curLang . '/admin/posts') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/posts"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Posts</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive($curLang . '/admin/menus') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/menus"><i class="fa fa-bars" aria-hidden="true"></i> <span>Menus</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive($curLang . '/admin/themes') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/themes"><i class="fa fa-paint-brush" aria-hidden="true"></i> <span>Themes</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive($curLang . '/admin/settings') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/settings"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Settings</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive($curLang . '/admin/pagebuilder') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/pagebuilder"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Pagebuilder</span></a></li>
    @else
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/login') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/login"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Login</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/register') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/register"><i class="fa fa-plus" aria-hidden="true"></i> <span>Register</span></a></li>
    @endif
</ul>