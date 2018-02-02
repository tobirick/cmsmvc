<?php $__env->startSection('title', 'Show Post'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    Show Post (Vorschau)
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>