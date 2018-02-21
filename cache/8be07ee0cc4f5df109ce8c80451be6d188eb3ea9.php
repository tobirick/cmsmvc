<?php $__env->startSection('title', 'Admin Pages'); ?>
<?php $__env->startSection('content-title', 'Pages'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('left'); ?>
        <a href="/<?php echo e($curLang); ?>/admin/pages/create" class="button-primary"><?php echo e($lang['New Page']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($page['id']); ?></td>
                            <td><strong><?php echo e($page['name']); ?></strong><br><span class="light-text smaller-text">/<?php echo e($page['slug']); ?></span></td>
                            <td class="action">
                                <a href="/<?php echo e($curLang); ?>/admin/pages/<?php echo e($page['id']); ?>/edit"><i class="fa fa-pencil"></i></a>
                                <a target="_blank" href="/<?php echo e($page['slug']); ?>"><i class="fa fa-arrow-right"></i></a>
                                <form action="/admin/pages/<?php echo e($page['id']); ?>" method="POST">
                                    <input type="hidden" name='_METHOD' value="DELETE">
                                    <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                                    <button><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>