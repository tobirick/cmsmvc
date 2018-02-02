<?php $__env->startSection('title', 'Admin Menus'); ?>
<?php $__env->startSection('content-title', 'Menus'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/menus/create" class="button-primary">New Menu</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div>
        <?php if(isset($menus)): ?>
        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <?php echo e($menu['name']); ?>

                <a href="/admin/menus/<?php echo e($menu['id']); ?>/edit">Edit</a>
                <form action="/admin/menus/<?php echo e($menu['id']); ?>" method="POST">
                    <input type="hidden" name='_METHOD' value="DELETE">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <button>Delete</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>