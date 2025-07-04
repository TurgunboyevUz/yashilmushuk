<?php
    use App\Models\File\File;
    use App\Models\File\Article;
    use App\Models\File\Scholarship;
    use App\Models\File\Invention;
    use App\Models\File\Startup;
    use App\Models\File\GrandEconomy;
    use App\Models\File\Olympic;
    use App\Models\File\LangCertificate;
    use App\Models\File\Achievement;

    $employee_id = $user->employee->id;

    $counts = [
        'articles' => File::where('fileable_type', Article::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'scholarships' => File::where('fileable_type', Scholarship::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'inventions' => File::where('fileable_type', Invention::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'startups' => File::where('fileable_type', Startup::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'grand_economies' => File::where('fileable_type', GrandEconomy::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'olympics' => File::where('fileable_type', Olympic::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'lang_certificates' => File::where('fileable_type', LangCertificate::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
        'achievements' => File::where('fileable_type', Achievement::class)->where('status', 'pending')->whereHas('user.student', function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->count(),
    ];

    $all_count = collect($counts)->sum();
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo e(asset('img/bmi_logo.jpg')); ?>" alt="BMI Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BMI Platformasi</span>
    </a>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="<?php echo e(route('employee.teacher.dashboard')); ?>" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Bosh sahifa</p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-folder"></i>
                    <p> Kelib tushgan hujjatlar <i class="right fas fa-angle-left"></i>
                        <span class="right badge badge-danger"><?php echo e($all_count); ?></span>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.article')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-upload"></i>
                            <p>Yuklangan Maqolalar
                                <span class="right badge badge-info"><?php echo e($counts['articles']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.scholarship')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>Stipendiyat
                                <span class="right badge badge-info"><?php echo e($counts['scholarships']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.invention')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>Ixtro/DGU/Foydali model
                                <span class="right badge badge-info"><?php echo e($counts['inventions']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.startup')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-rocket"></i>
                            <p>Startup/Tanlov
                                <span class="right badge badge-info"><?php echo e($counts['startups']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.grand-economy')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Grant/Xo'jalik shartonmalar
                                <span class="right badge badge-info"><?php echo e($counts['grand_economies']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.olympics')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-medal"></i>
                            <p>Olimpiyadalar
                                <span class="right badge badge-info"><?php echo e($counts['olympics']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.lang-certificate')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-language"></i>
                            <p>Til Sertifikatlari
                                <span class="right badge badge-info"><?php echo e($counts['lang_certificates']); ?></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.achievement')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-award"></i>
                            <p>O’quv yili davomida<br>erishgan boshqa yutuqlari<br><span class="right badge badge-info"><?php echo e($counts['achievements']); ?></span></p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('employee.teacher.tasks')); ?>" class="nav-link">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Topshiriq yaratish</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('employee.teacher.student-list')); ?>" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>Talabalar ro'yxati</p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>
                        Statistika
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.rating.attached-students')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Biriktirilgan talabalar reytingi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.rating.department')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kafedra bo'yicha reytingi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.rating.faculty')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fakultet reytingi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.rating.institute')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Institut reytingi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('employee.teacher.rating.general-institute')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Talabalarni institut <br>bo'yicha umumiy reytingi</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('employee.teacher.chat')); ?>" class="nav-link">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>Talabalar bilan chat
                        <span class="right badge badge-danger"><?php echo e($messages_count); ?></span>
                    </p>
                </a>
            </li>
        </ul>
    </nav>
</aside><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/layouts/employee/teacher/sidebar.blade.php ENDPATH**/ ?>