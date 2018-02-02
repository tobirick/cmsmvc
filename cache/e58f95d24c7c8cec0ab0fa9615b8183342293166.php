<?php $__env->startSection('title', 'Edit Page'); ?>
<?php $__env->startSection('content-title'); ?>
Edit '<?php echo e($name); ?>'
<?php $__env->stopSection(); ?>

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
    <form action="/admin/pages/<?php echo e($id); ?>" method="POST">
        <input type="hidden" name='_METHOD' value="PUT">
        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
        <input value="<?php echo e($slug); ?>" type="text" placeholder="Slug" name="page[slug]">
        <input value="<?php echo e($name); ?>" type="text" placeholder="Name" name="page[name]">
        <input value="<?php echo e($title); ?>" type="text" placeholder="Title" name="page[title]">
        <textarea name="page[content]"><?php echo e($content); ?></textarea>
        <button>Update Page</button>
    </form>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>