<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page not found</title>
    <?php echo $__env->make('admin.partials.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <a href="#" onclick="history.go(-1); return false;">Go back</a>
    <?php echo $__env->make('admin.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>