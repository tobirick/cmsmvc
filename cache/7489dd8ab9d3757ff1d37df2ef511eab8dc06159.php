<header class="header">
    <div class="container">
        <a class="header__logo" href="/">PP<span>CMS</span></a>
        <nav class="header__main-nav">
            <ul>
                <?php $__currentLoopData = $mainmenupages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="header__main-nav-item <?php echo e(checkIfNavItemIsActive($page['slug']) ? 'active' : ''); ?>"><a class="header__main-nav-item-link" href=<?php echo e($page['slug']); ?>><?php echo e($page['name']); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </nav>
    </div>
</header>