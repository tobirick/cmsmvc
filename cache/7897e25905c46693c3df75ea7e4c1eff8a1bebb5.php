<aside class="main-sidebar">
    <a class="main-sidebar__title" href="/admin/dashboard"><h1>PP<span>CMS</span></h1></a>
    <?php echo $__env->make('admin.partials.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="main-sidebar__language-changer">
        <select class="form-input" id="langChange" name="lang">
            <?php $__currentLoopData = $allLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($lang['shortName']); ?>" <?php echo e($curLang === $lang['shortName'] ? 'selected' : ''); ?>><?php echo e($lang['longName']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</aside>