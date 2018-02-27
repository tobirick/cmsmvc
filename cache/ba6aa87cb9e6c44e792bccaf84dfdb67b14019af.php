<ul class="main-sidebar__nav">
    <?php if(isset($user) && $user): ?>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('dashboard') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/dashboard">
                <i class="fa fa-tachometer" aria-hidden="true"></i> 
                <span>Dashboard</span>
            </a>
        </li>
        <!-- <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('admin/posts') ? 'active' : ''); ?>"><a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/posts"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Posts</span></a></li>-->
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('pages') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/pages">
                <i class="fa fa-file-o" aria-hidden="true"></i> 
                <span><?php echo e($lang['Pages']); ?></span>
            </a>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('media') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/media">
                <i class="fa fa-image" aria-hidden="true"></i> 
                <span><?php echo e($lang['Media']); ?></span>
            </a>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('downloads') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/downloads">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                <span><?php echo e($lang['Downloads']); ?></span>
            </a>
            <ul class="main-sidebar__sub-nav">
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/<?php echo e($curLang); ?>/admin/downloads/categories">
                        <span><?php echo e($lang['Categories']); ?></span>
                    </a>    
                </li>
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/<?php echo e($curLang); ?>/admin/downloads/categories/settings">
                        <span><?php echo e($lang['Settings']); ?></span>
                    </a>    
                </li>
                <li class="main-sidebar__sub-nav-item">
                    <a class="main-sidebar__sub-nav-item-link" href="/<?php echo e($curLang); ?>/admin/downloads/create">
                        <span><?php echo e($lang['New Download']); ?></span>
                    </a>    
                </li>
            </ul>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('menus') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/menus">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <span><?php echo e($lang['Menus']); ?></span>
            </a>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('themes') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/themes">
                <i class="fa fa-paint-brush" aria-hidden="true"></i> 
                <span><?php echo e($lang['Themes']); ?></span>
            </a>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('forms') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/forms">
                <i class="fa fa-wpforms" aria-hidden="true"></i> 
                <span><?php echo e($lang['Forms']); ?></span>
            </a>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('settings') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/settings">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <span><?php echo e($lang['Settings']); ?></span>
            </a>
        </li>
        <li class="main-sidebar__nav-item <?php echo e(checkIfNavItemIsActive('pagebuilder') ? 'active' : ''); ?>">
            <a class="main-sidebar__nav-item-link" href="/<?php echo e($curLang); ?>/admin/pagebuilder">
                <i class="fa fa-building-o" aria-hidden="true"></i> 
                <span><?php echo e($lang['Pagebuilder']); ?></span>
            </a>
        </li>
    <?php endif; ?>
</ul>