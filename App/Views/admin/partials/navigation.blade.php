<ul class="main-sidebar__nav">
    @if($user)
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin"><i class="fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/pages') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/pages"><i class="fa fa-file-o" aria-hidden="true"></i> <span>Pages</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/posts') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/posts"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Posts</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/menus') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/menus"><i class="fa fa-bars" aria-hidden="true"></i> <span>Menus</span></a></li>
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/pagebuilder') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/admin/pagebuilder"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Pagebuilder</span></a></li>
    @else
        <li class="main-sidebar__nav-item"><a class="main-sidebar__nav-item-link" href="/admin/login">Login</a></li>
        <li class="main-sidebar__nav-item"><a class="main-sidebar__nav-item-link" href="/admin/register">Register</a></li>
    @endif
</ul>