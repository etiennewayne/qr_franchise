<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard()->check()): ?>
        <welcome-page></welcome-page>
    <?php else: ?>

        <Login></Login>
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.no-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\qr_franchise\resources\views/login.blade.php ENDPATH**/ ?>