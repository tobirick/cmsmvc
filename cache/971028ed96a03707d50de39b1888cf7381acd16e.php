<?php $__env->startSection('title', 'Admin Media Manager'); ?>
<?php $__env->startSection('content-title', $lang['Media Manager']); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('right'); ?>
        <a href="#" data-bind="click: $root.openAddFolderPopup" class="button-primary-border"><?php echo e($lang['New Folder']); ?></a>
        <a href="#" data-bind="click: $root.openUploadPopup" class="button-primary"><?php echo e($lang['Upload']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div data-bind="visible: popupOpen, click: closePopup" class="popup__overlay"></div>
<?php $__env->startComponent('admin.popups.media-add-folder-popup'); ?><?php echo $__env->renderComponent(); ?>
<?php $__env->startComponent('admin.popups.media-upload-popup'); ?><?php echo $__env->renderComponent(); ?>
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
                            <th>Größe</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody data-bind="sortable: {data: mediaElements}">
                    <!-- ko if: type() === 'file' -->
                        <tr data-bind="css: {file: type() === 'file'}, droppable: type() === 'dir' ? {data: changeFolder, accept: '.file'} : {options: {disabled: true}}">
                            <td>#</td>
                            <td data-bind="click: type() === 'dir' ? openFolder : openFile"><span data-bind="if: type() === 'dir'"><i class="fa fa-folder"></span></i> <span data-bind="text: name"></span></td>
                            <td data-bind="text: size">Größe</td>
                            <td class="action">
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a data-bind="click: deleteMediaElement" href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <!-- /ko -->
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>