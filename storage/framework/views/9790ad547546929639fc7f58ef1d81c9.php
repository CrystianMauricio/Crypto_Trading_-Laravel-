<?php if($errors->any()): ?>
    <message :messages="<?php echo e(json_encode($errors->all())); ?>" class="negative">
        <?php echo e(__('app.error')); ?>

    </message>
<?php elseif(session('error')): ?>
    <message message="<?php echo e(session('error')); ?>" class="error">
        <?php echo e(__('app.error')); ?>

    </message>
<?php elseif(session('warning')): ?>
    <message message="<?php echo e(session('warning')); ?>" class="warning">
        <?php echo e(__('app.warning')); ?>

    </message>
<?php elseif(session('success')): ?>
    <message message="<?php echo e(session('success')); ?>" class="positive">
        <?php echo e(__('app.success')); ?>

    </message>
<?php elseif(session('status')): ?>
    <message message="<?php echo e(session('status')); ?>" class="positive">
        <?php echo e(__('app.success')); ?>

    </message>
<?php elseif(session('info')): ?>
    <message message="<?php echo e(session('info')); ?>" class="info">
        <?php echo e(__('app.info')); ?>

    </message>
<?php endif; ?>

<?php if(session('view')): ?>
    <?php echo $__env->make(session('view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?><?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/components/session/messages.blade.php ENDPATH**/ ?>