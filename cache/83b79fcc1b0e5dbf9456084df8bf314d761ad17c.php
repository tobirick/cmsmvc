<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
    <div class="box-wrapper">
        <div class="box">
            <div class="box__title"><h2>Register for <strong>PPCMS</strong></h2></div>
            <?php if(isset($formErrors)): ?>
                <?php $__currentLoopData = $formErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formError): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($formError); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(isset($error)): ?>
                <p><?php echo e($error); ?></p>
            <?php endif; ?>
            <form method="POST" action="/admin/register">
                <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
                <div class="form-row">
                    <div id="user" class="form-input-icon">
                        <input class="form-input" placeholder="Name" type="text" name="user[name]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="email" class="form-input-icon">
                        <input class="form-input" placeholder="E-Mail" type="email" name="user[email]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input class="form-input" placeholder="Password" type="password" name="user[password]">
                    </div>
                </div>
                <button class="button-primary block">Register</button>
            </form>

            <span class="box__info">Already have an account? - <a href="/admin/login">Login here</a></span>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.background-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>