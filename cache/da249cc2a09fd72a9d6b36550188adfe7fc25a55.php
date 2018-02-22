<?php $__env->startSection('title', 'Edit Menu'); ?>
<?php $__env->startSection('content-title'); ?>
<?php echo e($lang['Edit']); ?> '<?php echo e($menu['name']); ?>'
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/menus" class="button-primary-border"><?php echo e($lang['Go back']); ?></a>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('right'); ?>
        <a id="submit-form-btn" href="#" class="button-primary"><?php echo e($lang['Save']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="admin-box">
                <h3 class="admin-box__title"><?php echo e($lang['Main Settings']); ?></h3>
                <form id="submit-form" action="/admin/menus/<?php echo e($menu['id']); ?>" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <div class="form-row">
                        <input class="form-input" value="<?php echo e($menu['name']); ?>" type="text" placeholder="Name" name="menu[name]">
                    </div>
                    <?php $__currentLoopData = $allmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allmenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input <?php echo e($menu['id'] === $allmenu['value'] ? 'checked' : ''); ?> name="menu[<?php echo e($allmenu['name']); ?>]" type="checkbox" value="<?php echo e($menu['id']); ?>"> <?php echo e($allmenu['name']); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </form>
            </div>
        </div>
    <div class="col-6">
            <div class="admin-box">
                <h3 class="admin-box__title"><?php echo e($lang['New Menu Item']); ?></h3>
                <form data-bind="submit: addMenuListItem">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <input name="menu_id" type="hidden" value="<?php echo e($menu['id']); ?>">
                    <div class="form-row">
                        <div class="col-6">
                            <input data-bind="value: $root.newMenuItemName" class="form-input" type="text" placeholder="Name" name="menuitem[name]">
                        </div>
                        <div class="col-4">
                            <select class="form-input" data-bind="options: pagesList, optionsText: 'name', optionsValue: 'id', value: $root.newMenuItemPage" name="menuitem[page]"></select>
                        </div>
                        <div class="col-1">
                            <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <h3 class="admin-box__title"><?php echo e($lang['Menu']); ?> Item's</h3>
                    <div id="menu-list">
                        <table class="table">
                            <tbody data-bind="foreach: menuListItems">
                                <tr>
                                    <td>#</td>
                                    <td>
                                     <div class="row">
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input class="form-input" data-bind="value: name, valueUpdate: 'afterkeydown'" type="text" placeholder="Name" name="menuitem[name]">
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', value: page_id, optionsValue: 'id'" name="menuitem[page]"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <button data-bind="click: updateMenuListItem" class="button-primary-icon"><i class="fa fa-check"></i></button>
                                            <button data-bind="click: deleteMenuListItem" class="button-error-icon"><i class="fa fa-trash"></i></button>
                                            <button class="button-warning-icon"><i class="fa fa-arrows"></i></button>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
    <input type="hidden" id="menuid" value="<?php echo e($menu['id']); ?>">
    <input type="hidden" id="csrftoken" value="<?php echo e($csrf); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>