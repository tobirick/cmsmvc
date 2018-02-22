<?php $__env->startSection('title', $lang['Dashboard']); ?>
<?php $__env->startSection('content-title'); ?>
<?php echo e($lang['Dashboard']); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <h4><?php echo e($lang['Welcome back']); ?> <?php echo e($user['name']); ?>!</h4>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="admin-box">
                    <h3 class="admin-box__title">Statistiken</h3>
                </div>
            </div>
            <div class="col-4">
                <div class="admin-box">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Aktivitäten</h3>
                </div>
            </div>
            <div class="col-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Aktionen</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>