<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <?php echo $__env->make('includes.frontend.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="<?php echo e(str_replace('.','-',Route::currentRouteName())); ?> background-<?php echo e($settings->background); ?> color-<?php echo e($settings->color); ?>">
    <?php echo $__env->renderWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

    <div id="particles"></div>

    <div id="error">
        <div class="ui middle aligned center aligned grid centered-container">
            <div class="column">
                <div class="ui segment">
                    <h2 class="ui <?php echo e($settings->color); ?> image header">
                        <a href="<?php echo e(route('frontend.index')); ?>">
                            <img src="<?php echo e(asset('images/logo.png')); ?>" class="image">
                        </a>
                        <div class="content">
                            <?php echo e(__('app.app_name')); ?>

                            <div class="sub header"><?php echo e(__('error.title')); ?></div>
                        </div>
                    </h2>
                    <div class="ui <?php echo e($settings->color); ?> <?php echo e($inverted); ?> statistic">
                        <div class="value">
                            <?php echo e($exception->getStatusCode()); ?>

                        </div>
                        <div class="label">
                            <?php echo e(__('error.' . $exception->getStatusCode())); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/manifest.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/vendor.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/semantic/semantic.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/auth.js')); ?>"></script>
</body>
</html>
<?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/layouts/error.blade.php ENDPATH**/ ?>