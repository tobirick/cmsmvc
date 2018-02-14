<?php $__env->startSection('title', 'Admin Themes'); ?>
<?php $__env->startSection('content-title', 'Themes'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/themes/create" class="button-primary">New Theme</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div>
        <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div <?php echo e($theme['name'] === $activetheme ? 'class="active"' : ''); ?>>
            <?php echo e($theme['name']); ?>

            <form action="/admin/themes/<?php echo e($theme['name']); ?>/<?php echo e($theme['id']); ?>" method="POST">
                <input type="hidden" name='_METHOD' value="DELETE">
                <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                <button>Delete</button>
            </form>
            <form action="/admin/themes/<?php echo e($theme['name']); ?>/<?php echo e($theme['id']); ?>" method="POST">
                <input type="hidden" name='_METHOD' value="PUT">
                <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                <button>Activate</button>
            </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>