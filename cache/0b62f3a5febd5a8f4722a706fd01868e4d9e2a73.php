<?php $__env->startSection('title', 'Create Theme'); ?>
<?php $__env->startSection('content-title', 'Add new Theme'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/themes" class="button-primary-border"><?php echo e($lang['Go back']); ?></a>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('right'); ?>
        <a id="submit-form-btn" href="#" class="button-primary"><?php echo e($lang['Save']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <form id="submit-form" action="/admin/themes" method="POST">
                        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                        <div class="form-row">
                            <input class="form-input" type="text" placeholder="Name" name="theme[name]">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>