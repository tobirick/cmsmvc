<?php $__env->startSection('title', 'Admin Page'); ?>
<?php $__env->startSection('content-title'); ?>
Welcome back <?php echo e($user['name']); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>