<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <?php echo $__env->make('includes.frontend.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="<?php echo e(str_replace('.','-',Route::currentRouteName())); ?> background-<?php echo e($settings->background); ?> color-<?php echo e($settings->color); ?>">
    <?php echo $__env->renderWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

    <div id="app">

        <div id="before-auth">
            <?php echo $__env->yieldContent('before-auth'); ?>
        </div>

        <div id="auth">
            <?php echo $__env->yieldContent('auth'); ?>
        </div>

    </div>

    <?php echo $__env->make('includes.frontend.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/layouts/auth.blade.php ENDPATH**/ ?>