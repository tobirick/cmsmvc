<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php echo $__env->make('admin.partials.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <?php echo $__env->make('admin.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="main-content">
        <div class="main-content__header">
            <div class="main-content__toggle-sidebar">
                <span></span>
                <span></span>
                <span></span>
            </div>
                <h2><?php echo $__env->yieldContent('content-title'); ?></h2>
                <div class="main-content__header-info">
                    <a href="/admin/logout">Logout</a>
                    <a href="/admin/profiles/<?php echo e($user['name']); ?>"><?php echo e($user['name']); ?></a>
                </div>
        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->make('admin.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>