<?php $__env->startSection('title', 'Profile Page'); ?>

<?php $__env->startSection('content'); ?>
<h1>Profile Page</h1>
Hi wie gehts <strong><?php echo e(isset($user) ? $user['name'] : ''); ?></strong><br>
E-Mail: <?php echo e(isset($user) ? $user['email'] : ''); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>