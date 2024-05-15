

<?php $__env->startSection('title'); ?>
    <?php echo e(__('auth.reset')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('before-auth'); ?>
    <div id="particles"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth'); ?>
    <div class="ui middle aligned center aligned grid centered-container">
        <div class="column">
            <div class="ui segment">
                <h2 class="ui <?php echo e($settings->color); ?> image header">
                    <a href="<?php echo e(route('frontend.index')); ?>">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" class="image">
                    </a>
                    <div class="content">
                        <?php echo e(__('app.app_name')); ?>

                        <div class="sub header"><?php echo e(__('auth.reset_header')); ?></div>
                    </div>
                </h2>
                <?php $__env->startComponent('components.session.messages'); ?>
                <?php echo $__env->renderComponent(); ?>
                <loading-form v-cloak inline-template>
                    <form class="ui form" method="POST" action="<?php echo e(route('password.email')); ?>" @submit="disableButton">
                        <?php echo e(csrf_field()); ?>

                        <div class="field<?php echo e($errors->has('email') ? ' error' : ''); ?>">
                            <div class="ui left icon input">
                                <i class="mail icon"></i>
                                <input type="email" name="email" placeholder="<?php echo e(__('auth.email')); ?>" value="<?php echo e(old('email')); ?>" required autofocus>
                            </div>
                        </div>
                        <?php if(config('settings.recaptcha.public_key')): ?>
                            <div class="field">
                                <div class="g-recaptcha" data-sitekey="<?php echo e(config('settings.recaptcha.public_key')); ?>" data-theme="<?php echo e($inverted ? 'dark' : 'light'); ?>"></div>
                            </div>
                        <?php endif; ?>
                        <button :class="[{disabled: submitted, loading: submitted}, 'ui <?php echo e($settings->color); ?> fluid large submit button']"><?php echo e(__('auth.reset')); ?></button>
                    </form>
                </loading-form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/auth.js')); ?>"></script>
    <?php if(config('settings.recaptcha.public_key')): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>