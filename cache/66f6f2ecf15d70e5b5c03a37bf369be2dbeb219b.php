<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
Das ist ein base theme
    <h1><?php echo e($title); ?></h1>

    <p><?php echo e($content); ?></p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('public.themes.trtheme.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>