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

    Edit Menu
    <form id="submit-form" action="/admin/menus/<?php echo e($menu['id']); ?>" method="POST">
        <input type="hidden" name='_METHOD' value="PUT">
        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
        <input value="<?php echo e($menu['name']); ?>" type="text" placeholder="Name" name="menu[name]">

        <?php $__currentLoopData = $allmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allmenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input <?php echo e($menu['id'] === $allmenu['value'] ? 'checked' : ''); ?> name="menu[<?php echo e($allmenu['name']); ?>]" type="checkbox" value="<?php echo e($menu['id']); ?>"> <?php echo e($allmenu['name']); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>

    Add Menu Item
    <form id="add-menu-item" action="/admin/menus/<?php echo e($menu['id']); ?>/menuitems" method="POST">
        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
        <input name="menu_id" type="hidden" value="<?php echo e($menu['id']); ?>">
        <input type="text" placeholder="Name" name="menuitem[name]">
        <select name="menuitem[page]">
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($page['id']); ?>"><?php echo e($page['name']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button>Add Menu Item</button>
    </form>
    
    Menu Items:<br>
    <?php if(isset($menuitems)): ?>
    <div id="menu-list">
    <?php $__currentLoopData = $menuitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div>
        <form id="update-menu-item" action="/admin/menus/<?php echo e($menu['id']); ?>/menuitems/<?php echo e($menuitem['id']); ?>" method="POST">
            <input type="hidden" name='_METHOD' value="PUT">
            <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
            <input value="<?php echo e($menuitem['name']); ?>" type="text" placeholder="Name" name="menuitem[name]">
            <select name="menuitem[page]">
                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($page['id']); ?>" <?php echo e($menuitem['page_id'] === $page['id'] ? 'selected' : ''); ?>><?php echo e($page['name']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button>Edit Menu Item</button>
        </form>

        <form id="delete-menu-item" action="/admin/menus/<?php echo e($menu['id']); ?>/menuitems/<?php echo e($menuitem['id']); ?>" method="POST">
            <input type="hidden" name='_METHOD' value="DELETE">
            <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
            <button>Delete Menu Item</button>
        </form>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>