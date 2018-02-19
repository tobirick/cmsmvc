<?php $__env->startSection('title', 'Edit Menu'); ?>
<?php $__env->startSection('content-title'); ?>
Edit '<?php echo e($menu['name']); ?>'
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/admin/menus" class="button-primary-border">Go back</a>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('right'); ?>
        <a id="submit-form-btn" href="#" class="button-primary">Save</a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="admin-box">
                <h3 class="admin-box__title">Main Settings</h3>
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
                <h3 class="admin-box__title">Add new Menu Item</h3>
                <form id="add-menu-item" action="/admin/menus/<?php echo e($menu['id']); ?>/menuitems" method="POST">
                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                    <input name="menu_id" type="hidden" value="<?php echo e($menu['id']); ?>">
                    <div class="form-row">
                        <div class="col-6">
                            <input class="form-input" type="text" placeholder="Name" name="menuitem[name]">
                        </div>
                        <div class="col-4">
                            <select class="form-input" name="menuitem[page]">
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($page['id']); ?>"><?php echo e($page['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-1">
                            <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div>
    <table class="table">
        <tbody data-bind="foreach: menuListItems">
            <tr>
                <td>#</td>
                <td data-bind="text: name"></td>
                <td>
                 <form id="update-menu-item" method="POST">
                     <input type="hidden" name='_METHOD' value="PUT">
                     <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                     <div class="row">
                          <div class="col-5">
                              <input class="form-input" data-bind="value: name" type="text" placeholder="Name" name="menuitem[name]">
                          </div>
                          <div class="col-5">
                              <select class="form-input" data-bind="options: $root.pages, optionsText: 'name', value: id" name="menuitem[page]">
                            </select>
                         </div>
                        <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                    </div>
                </form>
            </td>
            </tr>
        </tbody>
    </table>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <h3 class="admin-box__title">Menu Item's</h3>
                <?php if(isset($menuitems)): ?>
                    <div id="menu-list">
                        <table class="table">
                        <tbody>
                            <?php $__currentLoopData = $menuitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td>#</td>
                                <td>
                                    <form id="update-menu-item" action="/admin/menus/<?php echo e($menu['id']); ?>/menuitems/<?php echo e($menuitem['id']); ?>" method="POST">
                                        <input type="hidden" name='_METHOD' value="PUT">
                                        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                                        <div class="row">
                                            <div class="col-5">
                                                <input class="form-input" value="<?php echo e($menuitem['name']); ?>" type="text" placeholder="Name" name="menuitem[name]">
                                            </div>
                                            <div class="col-5">
                                                <select class="form-input" name="menuitem[page]">
                                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($page['id']); ?>" <?php echo e($menuitem['page_id'] === $page['id'] ? 'selected' : ''); ?>><?php echo e($page['name']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form id="delete-menu-item" action="/admin/menus/<?php echo e($menu['id']); ?>/menuitems/<?php echo e($menuitem['id']); ?>" method="POST">
                                        <input type="hidden" name='_METHOD' value="DELETE">
                                        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                                        <button class="button-error-icon"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>