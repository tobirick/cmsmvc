<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php echo $__env->make('admin.partials.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <div id="particles-js"></div>
        <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('admin.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/admin/particles.json');
    </script>
</body>
</html>