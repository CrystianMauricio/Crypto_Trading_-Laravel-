<?php $__env->startComponent('mail::message'); ?>

<?php if(! empty($greeting)): ?>
# <?php echo e($greeting); ?>

<?php else: ?>
<?php if($level == 'error'): ?>
# <?php echo e(__('email.greeting_error')); ?>

<?php else: ?>
# <?php echo e(__('email.greeting')); ?>

<?php endif; ?>
<?php endif; ?>


<?php $__currentLoopData = $introLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($line); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if(isset($actionText)): ?>
<?php
switch ($level) {
    case 'success':
        $color = 'green';
        break;
    case 'error':
        $color = 'red';
        break;
    default:
        $color = 'blue';
}
?>
<?php $__env->startComponent('mail::button', ['url' => $actionUrl, 'color' => $color]); ?>
<?php echo e($actionText); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


<?php $__currentLoopData = $outroLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($line); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if(! empty($salutation)): ?>
<?php echo e($salutation); ?>

<?php endif; ?>


<?php if(isset($actionText)): ?>
<?php $__env->startComponent('mail::subcopy'); ?>
<?php echo e(__('email.raw_link', ['action' => $actionText, 'url' => $actionUrl])); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/vendor/notifications/email.blade.php ENDPATH**/ ?>