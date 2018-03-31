<ul class="main-sidebar__nav">
    @if(isset($user) && $user)
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('dashboard') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/dashboard">
                <i class="fa fa-tachometer" aria-hidden="true"></i> 
                <span>Dashboard</span>
            </a>
        </li>
        <!-- <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('admin/posts') ? 'active' : ''}}"><a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/posts"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Posts</span></a></li>-->
        @if(checkPerm('view_page'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('pages') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/pages">
                <i class="fa fa-file-o" aria-hidden="true"></i> 
                <span>{{$lang['Pages']}}</span>
            </a>
        </li>
        @endif
        @if(checkPerm('view_media'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('media') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/media">
                <i class="fa fa-image" aria-hidden="true"></i> 
                <span>{{$lang['Media']}}</span>
            </a>
        </li>
        @endif
        <!--<li class="main-sidebar__nav-item {{checkIfNavItemIsActive('downloads') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/downloads">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                <span>{{$lang['Downloads']}}</span>
            </a>
            <ul class="main-sidebar__sub-nav">
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/{{$curLang}}/admin/downloads/categories">
                        <span>{{$lang['Categories']}}</span>
                    </a>    
                </li>
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/{{$curLang}}/admin/downloads/categories/settings">
                        <span>{{$lang['Settings']}}</span>
                    </a>    
                </li>
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/{{$curLang}}/admin/downloads/create">
                        <span>{{$lang['New Download']}}</span>
                    </a>    
                </li>
            </ul>
        </li>-->
        @if(checkPerm('view_menu'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('menus') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/menus">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <span>{{$lang['Menus']}}</span>
            </a>
        </li>
        @endif
        @if(checkPerm('view_theme'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('themes') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/themes">
                <i class="fa fa-paint-brush" aria-hidden="true"></i> 
                <span>{{$lang['Themes']}}</span>
            </a>
        </li>
        @endif
        <!--<li class="main-sidebar__nav-item {{checkIfNavItemIsActive('forms') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/forms">
                <i class="fa fa-wpforms" aria-hidden="true"></i> 
                <span>{{$lang['Forms']}}</span>
            </a>
        </li>-->
        @if(checkPerm('view_settings'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('settings') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/settings">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <span>{{$lang['Settings']}}</span>
            </a>
            @if(checkPerm('view_language'))
            <ul class="main-sidebar__sub-nav">
               <li class="main-sidebar__sub-nav-item">
                   <a class="main-sidebar__sub-nav-item-link" href="/{{$curLang}}/admin/settings/languages">
                       <span>{{$lang['Languages']}}</span>
                   </a>    
               </li>
           </ul>
           @endif
        </li>
        @endif
        @if(checkPerm('view_pagebuilder_item'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('pagebuilder') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/pagebuilder">
                <i class="fa fa-building-o" aria-hidden="true"></i> 
                <span>{{$lang['Pagebuilder']}}</span>
            </a>
        </li>
        @endif
        @if(checkPerm('view_users'))
        <li class="main-sidebar__nav-item {{checkIfNavItemIsActive('users') ? 'active' : ''}}">
            <a class="main-sidebar__nav-item-link" href="/{{$curLang}}/admin/users">
                <i class="fa fa-users" aria-hidden="true"></i>
                <span>{{$lang['Users']}}</span>
            </a>
            <ul class="main-sidebar__sub-nav">
               @if(checkPerm('view_user_roles'))
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/{{$curLang}}/admin/users/roles">
                        <span>{{$lang['User Roles']}}</span>
                    </a>    
                </li>
                @endif
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/{{$curLang}}/admin/users/{{$user['name']}}">
                        <span>{{$lang['Your Profile']}}</span>
                    </a>    
                </li>
            </ul>
        </li>
        @endif
    @endif
</ul>