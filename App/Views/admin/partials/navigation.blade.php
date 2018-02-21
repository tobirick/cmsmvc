<ul class="main-sidebar__nav">
    @if($user)
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/dashboard') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/posts') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/posts"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Posts</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/pages') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/pages"><i class="fa fa-file-o" aria-hidden="true"></i> <span>{{$lang['Pages']}}</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/menus') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/menus"><i class="fa fa-bars" aria-hidden="true"></i> <span>{{$lang['Menus']}}</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/themes') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/themes"><i class="fa fa-paint-brush" aria-hidden="true"></i> <span>{{$lang['Themes']}}</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/settings') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/settings"><i class="fa fa-cogs" aria-hidden="true"></i> <span>{{$lang['Settings']}}</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/pagebuilder') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/pagebuilder"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Pagebuilder</span></a></li>
    @else
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/login') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/login"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Login</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/register') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/register"><i class="fa fa-plus" aria-hidden="true"></i> <span>Register</span></a></li>
    @endif
</ul>