<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <?php echo $__env->make('includes.frontend.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="<?php echo e(str_replace('.','-',Route::currentRouteName())); ?> background-<?php echo e($settings->background); ?> color-<?php echo e($settings->color); ?>" onload="if(window !== window.top) window.top.location = window.location">
    <?php echo $__env->renderWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

    <div id="app">

        <div id="before-content">
            <?php echo $__env->yieldContent('before-content'); ?>
        </div>

        <div class="ui container">
            <?php $__env->startSection('messages'); ?>
                <?php $__env->startComponent('components.session.messages'); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php echo $__env->yieldSection(); ?>
        </div>

        <div id="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <div id="after-content">
            <?php echo $__env->yieldContent('after-content'); ?>
        </div>

        <?php echo $__env->first(['includes.frontend.footer-udf','includes.frontend.footer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <?php echo $__env->make('includes.frontend.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/layouts/index.blade.php ENDPATH**/ ?>