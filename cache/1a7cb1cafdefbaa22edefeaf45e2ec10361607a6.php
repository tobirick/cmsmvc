<?php $__env->startSection('title', 'Admin Themes'); ?>
<?php $__env->startSection('content-title', 'Themes'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/themes/create" class="button-primary"><?php echo e($lang['New Theme']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <div class="row">
                        <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                <div class="card <?php echo e($theme['name'] === $activetheme ? 'active-theme' : ''); ?>">
                                    <div class="card__title"><?php echo e($theme['name']); ?></div>
                                    <div class="card__actions">
                                        <form action="/admin/themes/<?php echo e($theme['name']); ?>/<?php echo e($theme['id']); ?>" method="POST">
                                            <input type="hidden" name='_METHOD' value="PUT">
                                            <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                                            <button><i class="fa fa-check <?php echo e($theme['name'] === $activetheme ? 'active' : ''); ?>"></i></button>
                                        </form>
                                        <form action="/admin/themes/<?php echo e($theme['name']); ?>/<?php echo e($theme['id']); ?>" method="POST">
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