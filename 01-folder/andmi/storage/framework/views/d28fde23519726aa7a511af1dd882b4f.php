<?php $__env->startSection('content'); ?>
<div class="content-wrapper" style="padding: 0;">
    <section class="content-header">
        <h1>Talaba bilan chat</h1>
    </section>

    <section class="content" style="padding: 0;">
        <div class="container-fluid my-6">
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Chat</h3>
                    <div class="ml-auto">
                        <select id="studentSelect" class="form-control" required>
                            <option value="" disabled selected>Talabani tanlang</option>

                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $attr = '';

                                    if(isset($current_chat) and $student->chat->id == $current_chat) {
                                        $attr = 'selected';
                                    }
                                ?>    

                                <option value="<?php echo e($student->chat->id); ?>" <?php echo e($attr); ?>><?php echo e($student->user->short_fio()); ?> (<?php echo e($student->level); ?>-kurs, <?php echo e($student->direction->name); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <div id="chatMessages" class="p-3" style="height: 400px; overflow-y: auto;"></div>
                </div>

                <div class="card-footer">
                    <form id="chatForm" class="d-flex">
                        <input type="text" id="messageInput" class="form-control" placeholder="Xabar yozing..." required>
                        <button type="submit" class="btn btn-primary ml-2">
                            <i class="fas fa-paper-plane"></i> Jo'natish
                        </button>
                    </form>
                </div>
            </div>
        </div> <br>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>$(document).ready(function(){const chatMessages=$('#chatMessages'),messageInput=$('#messageInput'),chatForm=$('#chatForm'),studentSelect=$('#studentSelect');let currentChatId=null;if(studentSelect.val()){currentChatId=studentSelect.val();loadChatMessages(currentChatId)}function loadChatMessages(chatId){$.ajax({url:"<?php echo e(route('chat.messages', ['chat' => ':chatId'])); ?>".replace(':chatId',chatId),method:"GET",success:function(response){chatMessages.html(response.messages);chatMessages.scrollTop(chatMessages[0].scrollHeight)},error:function(){alert('Xabarlarni yuklab olishda xatolik yuz berdi.')}})}chatForm.on('submit',function(e){e.preventDefault();const message=messageInput.val().trim();if(message!==''&&currentChatId){$.ajax({url:"<?php echo e(route('chat.sendMessage', ['chat' => ':chatId'])); ?>".replace(':chatId',currentChatId),method:"POST",data:{message:message,_token:document.querySelector('meta[name="csrf-token"]').getAttribute('content')},success:function(response){messageInput.val('');loadChatMessages(currentChatId)},error:function(){alert('Xabarni yuborishda xatolik yuz berdi.')}})}});studentSelect.on('change',function(){currentChatId=$(this).val();if(currentChatId){loadChatMessages(currentChatId)}});$(document).on('click','.delete-message',function(){const messageId=$(this).data('message-id');if(confirm('Xabarni o\'chirmoqchimisiz?')){$.ajax({url:"<?php echo e(route('chat.deleteMessage', ['chat'=>':chatId'])); ?>".replace(':chatId',currentChatId),method:"POST",data:{message_id:messageId,_token:document.querySelector('meta[name="csrf-token"]').getAttribute('content')},success:function(response){loadChatMessages(currentChatId)},error:function(){alert('Xabarni o\'chirishda xatolik yuz berdi.')}})}});setInterval(function(){if(currentChatId){loadChatMessages(currentChatId)}},4000)});</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts::employee.teacher.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/teacher/chat.blade.php ENDPATH**/ ?>