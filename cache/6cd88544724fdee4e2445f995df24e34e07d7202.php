<?php $__env->startSection('title', 'Create Post'); ?>
<?php $__env->startSection('content-title', 'Add new Post'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/posts" class="button-primary-border">Go back</a>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('right'); ?>
        <a href="#" class="button-primary">Save</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    Create Post
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>