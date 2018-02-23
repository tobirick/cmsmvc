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
        <div class="col-8">

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

            <div class="admin-box">
                <div class="row">
                    <div class="admin-grid-section">
                        <div class="admin-grid-section__action">
                            <button><i class="fa fa-bars"></i></button>
                            <button><i class="fa fa-clone"></i></button>
                            <button><i class="fa fa-times"></i></button>
                        </div>
                        <div class="admin-grid-rows">
                            <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <span class="admin-grid__add-row"><i class="fa fa-plus"></i> Add Row</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="admin-grid-section">
                        <div class="admin-grid-section__action">
                            <button><i class="fa fa-bars"></i></button>
                            <button><i class="fa fa-clone"></i></button>
                            <button><i class="fa fa-times"></i></button>
                        </div>
                        <div class="admin-grid-rows">
                            <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <span class="admin-grid__add-row"><i class="fa fa-plus"></i> Add Row</span>
                        </div>
                    </div>
                    <span class="admin-grid__add-section"><i class="fa fa-plus"></i> Add Section</span>
                </div>
            </div>
            
        </div>
        <div class="col-4">
            <div id="fixed-sidebar">
            <div class="admin-box">
                <h3 class="admin-box__title">Grid</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">12</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">9</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">8</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">6</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">4</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">3</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">2</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                        </div>
                </div>
            </div>

            <div class="admin-box">
                <h3 class="admin-box__title">Elements</h3>
            </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>