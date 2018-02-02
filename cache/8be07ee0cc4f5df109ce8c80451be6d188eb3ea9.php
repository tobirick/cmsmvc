<?php $__env->startSection('title', 'Admin Pages'); ?>
<?php $__env->startSection('content-title', 'Pages'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/pages/create" class="button-primary">New Page</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div>
        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <?php echo e($page['name']); ?>

                <a href="/admin/pages/<?php echo e($page['id']); ?>/edit">Edit</a>
                <a target="_blank" href="/<?php echo e($page['slug']); ?>">Zur Seite</a>
                <form action="/admin/pages/<?php echo e($page['id']); ?>" method="POST">
                    <input type="hidden" name='_METHOD' value="DELETE">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <button>Delete</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>