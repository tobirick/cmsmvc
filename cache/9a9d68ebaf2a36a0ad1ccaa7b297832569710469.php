<?php $__env->startSection('title', 'Create Page'); ?>
<?php $__env->startSection('content-title', 'Add new Page'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/pages" class="button-primary-border">Go back</a>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('right'); ?>
        <a href="#" class="button-primary">Save</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <form action="/admin/pages" method="POST">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]"></textarea>
                    </div>
                    <div class="form-row">
                        <button>Add Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>