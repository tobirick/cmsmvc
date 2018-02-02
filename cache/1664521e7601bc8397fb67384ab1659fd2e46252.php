<?php $__env->startSection('title', 'Admin Pagebuilder'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    Admin Pagebuilder
    <a href="/admin/pagebuilder/create">New Pagebuilder Item</a>
    <div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>