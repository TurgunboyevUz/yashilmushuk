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

        <!-- Dark/Light mode toggle -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle">
                <font size='3px'><i class="fas fa-moon"></i></font>
            </a>
        </li>

        <!-- Role Switcher -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <font size='3px'>
            <i class="fas fa-exchange-alt"></i>
            </font>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route("employee.{$role->name}.dashboard")); ?>" class="dropdown-item"> <?php echo e($role->label); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </li>

        <!-- Profile Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="<?php echo e($user->picture_path()); ?>" alt="User" class="img-circle" style="height: 30px; padding-right: 8px;">
                <span class="d-none d-md-inline"><?php echo e($user->full_name()); ?></span>
                <span class="d-inline d-md-none"><?php echo e($user->short_name); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="<?php echo e(route('employee.talent.edit-profile')); ?>" class="dropdown-item">
                    <i class="nav-icon fas fa-pencil"></i> Profilni tahrirlash
                </a>
                <a href="<?php echo e(route('logout')); ?>" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Chiqish
                </a>
            </div>
        </li>
    </ul>
</nav>
<?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/layouts/employee/talent/navbar.blade.php ENDPATH**/ ?>