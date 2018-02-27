<?php $__env->startSection('title', 'Create Pagebuilder Item'); ?>
<?php $__env->startSection('content-title', 'Create Pagebuilder Item'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/pagebuilder" class="button-primary-border"><?php echo e($lang['Go back']); ?></a>
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
                     <form id="submit-form" method="POST" action="/admin/pagebuilder">
                          <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                          <div class="form-row">
                              <input placeholder="Name" class="form-input" type="text" name="item[name]">
                         </div>
                         <div class="form-row">
                             <textarea placeholder="Content" class="form-input" name="item[content]"></textarea>
                        </div>
                        <div class="form-row">
                             <input placeholder="Type" class="form-input" name="item[type]">
                        </div>
                        <div class="form-row">
                             <input placeholder="Description" class="form-input" name="item[description]">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>