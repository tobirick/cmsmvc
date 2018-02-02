<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <?php if(isset($formErrors)): ?>
    <?php $__currentLoopData = $formErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formError): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($formError); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(isset($error)): ?>
    <p><?php echo e($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="/register">
        <input name="csrf_token" type="hidden" value="<?php echo e($csrf); ?>">
        <input placeholder="Name" type="text" name="user[name]">
        <input placeholder="E-Mail" type="email" name="user[email]">
        <input placeholder="Password" type="password" name="user[password]">
        <button>Register</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>