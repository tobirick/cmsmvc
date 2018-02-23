<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
    <div class="box-wrapper">
        <div class="box">
            <div class="box__title"><h2>Login to <strong>PPCMS</strong></h2></div>
            <?php if(isset($formErrors)): ?>
            <?php $__currentLoopData = $formErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formError): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="form-error"><?php echo e($formError); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(isset($error)): ?>
            <p class="form-error"><?php echo e($error); ?></p>
            <?php endif; ?>
            <form id="validate-form" method="POST" action="/admin/login">
                <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                <div class="form-row">
                    <div id="email" class="form-input-icon">
                        <input placeholder="E-Mail" class="form-input validate" type="email" name="user[email]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input placeholder="Password" class="form-input validate" type="password" name="user[password]">
                    </div>
                </div>
                <button class="button-primary block">Login</button>
            </form>

            <span class="box__info">No account? - <a href="/admin/register">Register here</a></span>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.background-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>