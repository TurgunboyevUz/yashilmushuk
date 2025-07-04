<?php $__env->startSection('content'); ?>
<div class="content-wrapper" style="padding: 0;">
    <section class="content-header">
        <h1>Professor bilan chat</h1>
    </section>

    <section class="content" style="padding: 0;">
        <div class="container-fluid my-6">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Chat</h3>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <div id="chatMessages" class="p-3" style="height: 400px; overflow-y: auto;"></div>
                </div>

                <div class="card-footer">
                    <form id="chatForm" class="d-flex">
                        <input type="text" id="messageInput" class="form-control"
                            placeholder="<?php echo e((!isset($chat)) ? 'Sizga professor-o\'qituvchi biriktirilmagan' : 'Xabar yozing...'); ?>"
                            required <?php echo e((!isset($chat)) ? 'disabled' : ''); ?>

                        >
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
<script> $(document).ready(function(){const chatMessages=$('#chatMessages'),messageInput=$('#messageInput'),chatForm=$('#chatForm');function loadChatMessages(){$.ajax({url:"<?php echo e(route('chat.messages', ['chat' => $chat->id ?? 0])); ?>",method:"GET",success:function(response){chatMessages.html(response.messages);chatMessages.scrollTop(chatMessages[0].scrollHeight)},error:function(){}})}loadChatMessages();chatForm.on('submit',function(e){e.preventDefault();const message=messageInput.val().trim();if(message!==''){$.ajax({url:"<?php echo e(route('chat.sendMessage', ['chat' => $chat->id ?? 0])); ?>",method:"POST",data:{message:message,_token:document.querySelector('meta[name="csrf-token"]').getAttribute('content')},success:function(response){messageInput.val('');loadChatMessages()},error:function(){alert('Xabarni yuborishda xatolik yuz berdi.')}})}});$(document).on('click','.delete-message',function(){const messageId=$(this).data('message-id');if(confirm('Xabarni o\'chirmoqchimisiz?')){$.ajax({url:"<?php echo e(route('chat.deleteMessage', ['chat' => $chat->id ?? 0])); ?>",method:"POST",data:{message_id:messageId,_token:document.querySelector('meta[name="csrf-token"]').getAttribute('content')},success:function(response){loadChatMessages()},error:function(){alert('Xabarni o\'chirishda xatolik yuz berdi.')}})}});setInterval(loadChatMessages,4000)}); </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/chat.blade.php ENDPATH**/ ?>