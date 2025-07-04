<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="message my-2 d-flex align-items-start <?php echo e($message->user_id == $user->id ? 'flex-row-reverse' : ''); ?>">
        <img src="<?php echo e($message->user->picture_path()); ?>" alt="<?php echo e($message->user->short_fio()); ?>'s profile" class="rounded-circle <?php echo e($message->user_id == $user->id ? 'ml-2' : 'mr-2'); ?>" style="width: 40px; height: 40px;">
        <div class="<?php echo e($message->user_id == $user->id ? 'text-right' : ''); ?>">
            <strong><?php echo e($message->user_id == $user->id ? 'Siz' : $message->user->short_fio()); ?>:</strong>
            <p><?php echo e($message->content); ?></p>
            
            <?php if($message->user_id == $user->id): ?>
                <button class="btn btn-danger btn-sm delete-message" data-message-id="<?php echo e($message->id); ?>" style="padding: 5px 7px; font-size: 14px;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/chat/messages.blade.php ENDPATH**/ ?>