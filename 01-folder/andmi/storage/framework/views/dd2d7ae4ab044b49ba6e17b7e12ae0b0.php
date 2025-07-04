<?php
    use App\Models\Chat\Chat;
    use App\Models\Chat\Message;

    $messages = Message::where('seen', 0)
        ->whereIn('chat_id', function ($query) use ($user) {
            $query->select('id')
                ->from('chats')
                ->where(function ($subQuery) use($user) {
                    $subQuery->where('user_one_id', $user->id)
                            ->orWhere('user_two_id', $user->id);
                });
        })
        ->where('user_id', '!=', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $messages = $messages->unique(function ($message) {
        return $message->chat_id;
    });
    
    $messages = $messages->map(function ($message) use($user) {
        $sender = $user->id == $message->chat->first_user->id ? $message->chat->second_user : $message->chat->first_user;

        return [
            'id' => $message->id,
            'fio' => $sender->short_fio(),
            'picture_path' => $sender->picture_path(),
            'message' => $message->content,
            'sended_at' => Carbon\Carbon::parse($message->created_at)->diffForHumans(),
        ];
    })->take(3);
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <font size='3px'><i class="fas fa-globe"></i></font>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="border-radius: 8px; padding: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                <a href="#" class="dropdown-item lang-item">O'zbekcha (lotincha)</a>
                <a href="#" class="dropdown-item lang-item">O'zbekcha (krillcha)</a>
                <a href="#" class="dropdown-item lang-item">Ruscha</a>
                <a href="#" class="dropdown-item lang-item">Inglizcha</a>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <font size='3px'><i class="fas fa-comments"></i></font>
                <span class="badge badge-danger navbar-badge"><?php echo e(count($messages)); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">Professor o'qituvchi xabarlari</span>
                <div class="dropdown-divider"></div>

                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('student.chat')); ?>" class="dropdown-item">
                        <div class="media">
                            <img src="<?php echo e($message['picture_path']); ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <?php echo e($message['fio']); ?>

                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm"><?php echo e($message['message']); ?></p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?php echo e($message['sended_at']); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo e(route('student.chat')); ?>" class="dropdown-item dropdown-footer">Barchasini ko'rish</a>
            </div>
        </li>

        <!-- Dark/Light mode toggle -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle">
                <font size='3px'><i class="fas fa-moon"></i></font>
            </a>
        </li>

        <!-- Profile Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="<?php echo e($user->picture_path()); ?>" alt="User" class="img-circle" style="height: 30px; padding-right: 8px;">
                <span class="d-none d-md-inline"><?php echo e($user->full_name()); ?></span>
                <span class="d-inline d-md-none"><?php echo e($user->short_name); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="<?php echo e(route('logout')); ?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Chiqish</a>
            </div>
        </li>
    </ul>
</nav>
<?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/layouts/student/navbar.blade.php ENDPATH**/ ?>