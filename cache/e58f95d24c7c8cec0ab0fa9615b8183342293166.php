<?php $__env->startSection('title', 'Edit Page'); ?>
<?php $__env->startSection('content-title'); ?>
<?php echo e($lang['Edit']); ?> '<?php echo e($name); ?>'
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/pages" class="button-primary-border"><?php echo e($lang['Go back']); ?></a>
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
                <form id="submit-form" action="/admin/pages/<?php echo e($id); ?>" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($slug); ?>" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($name); ?>" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($title); ?>" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]"><?php echo e($content); ?></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>