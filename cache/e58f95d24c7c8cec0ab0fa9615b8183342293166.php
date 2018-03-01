<?php $__env->startSection('title', 'Edit Page'); ?>
<?php $__env->startSection('content-title'); ?>
<?php echo e($lang['Edit']); ?> '<?php echo e($page['name']); ?>'
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
<div class="admin-draggable-cols-wrapper">
            <div class="admin-box">
                <div class="admin-box__toggle"><i class="fa fa-chevron-left"></i></div>
                <h3 class="admin-box__title">Grid</h3>
                <div data-bind="foreach: possibleColumns" class="admin-draggable-cols">
                    <div class="admin-dragged-col" data-bind="draggable: {data: $data, connectClass: 'admin-grid-cols', options: {helper: 'clone', appendTo: 'body', revert: 'invalid', greedy: true}}">
                        <div data-bind="foreach: $parent.columns">
                            <div data-bind="css: 'col-'+col()">
                                <div class="admin-grid-col">
                                    col-<span data-bind="text: col"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
    </div>
<div id="content">    
<div class="container">
    <div class="row">

        <div class="col-9">
            <div class="admin-box">
                <form id="submit-form" action="/admin/pages/<?php echo e($page['id']); ?>" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($page['slug']); ?>" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($page['name']); ?>" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($page['title']); ?>" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]"><?php echo e($page['content']); ?></textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-3">
            <div class="admin-box">
            
            </div>
        </div>

        <div class="col-8">
            <div class="admin-box">
                <h3 class="admin-box__title">Pagebuilder</h3>
                <button class="button-primary fr" data-bind="click: savetoDB"><?php echo e($lang['Save']); ?></button>
                <div class="admin-grid-sections" data-bind="sortable: {data: sections, connectClass: 'admin-grid-sections', options: {revert: 'invalid'}}">
                    <?php $__env->startComponent('admin.components.pagebuilder-section'); ?><?php echo $__env->renderComponent(); ?>
                </div>
                <span data-bind="click: $root.addSection" class="admin-grid__add-section"><i class="fa fa-plus"></i> Add Section</span>
            </div>  
        </div>
        <div class="col-4">
            <div class="admin-box">
                <h3 class="admin-box__title">Elements</h3>
                <div data-bind="foreach: elements" class="row">
                    <div class="col-6">
                        <div data-bind="draggable: {data: $data, options: {revert: 'invalid'}}" class="admin-element-list-item">
                            <span data-bind="css: type" class="admin-element-list-item__type"></span>
                            <span data-bind="text: name" class="admin-element-list-item__name"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>