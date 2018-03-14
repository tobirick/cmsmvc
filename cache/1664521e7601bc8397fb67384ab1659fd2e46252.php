<?php $__env->startSection('title', 'Admin Pagebuilder Items'); ?>
<?php $__env->startSection('content-title', 'Pagebuilder Items'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/pagebuilder/create" class="button-primary"><?php echo e($lang['New Pagebuilder Item']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <div class="row">
                        <?php $__currentLoopData = $pagebuilderitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pagebuilderitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                <div class="card">
                                    <div class="card__title"><?php echo e($pagebuilderitem['item_name']); ?></div>
                                    <div class="card__actions">
                                        <a href="/<?php echo e($curLang); ?>/admin/pagebuilder/<?php echo e($pagebuilderitem['id']); ?>/edit"><i class="fa fa-pencil"></i></a>
                                        <form action="/admin/pagebuilder/<?php echo e($pagebuilderitem['id']); ?>" method="POST">
                                            <input type="hidden" name='_METHOD' value="DELETE">
                                            <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                                            <button><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>