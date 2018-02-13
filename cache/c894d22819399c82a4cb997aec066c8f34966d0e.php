<?php $__env->startSection('title', 'Create Menu'); ?>
<?php $__env->startSection('content-title', 'Add new Menu'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/menus" class="button-primary-border">Go back</a>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('right'); ?>
        <a href="#" class="button-primary">Save</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
    <div class="container">
        Create Menu
        <form action="/admin/menus" method="POST">
            <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
            <input type="text" placeholder="Name" name="menu[name]">
            <button>Add Menu</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>