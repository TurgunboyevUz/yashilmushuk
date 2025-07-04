<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo e(asset('img/bmi_logo.jpg')); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BMI Platformasi</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="<?php echo e(route('student.dashboard')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Bosh sahifa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('student.assignments')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Berilgan topshiriqlar <span class="right badge badge-primary"><?php echo e($user->student->tasks()->count()); ?></span></p>
                    </a>
                </li>
                <!-- Maqolalar Yuklash Dropdown Menu -->
                <li class="nav-item">
                    <a href="<?php echo e(route('student.article')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>Maqolalar yuklash</p>
                    </a>
                </li>
                <!-- Stipendiyat Dropdown Menu -->
                <li class="nav-item">
                    <a href="<?php echo e(route('student.scholarship')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>Stipendiyat</p>
                    </a>
                </li>
                <!-- Ixtro/DGU/Foydali model Dropdown Menu -->
                <li class="nav-item">
                    <a href="<?php echo e(route('student.invention')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-lightbulb"></i>
                        <p>Ixtro/DGU/Foydali model</p>
                    </a>
                </li>
                <!-- Startup/Tanlov Dropdown Menu -->
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('student.startup')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-rocket"></i>
                        <p>Startup/Tanlov</p>
                    </a>
                </li>
                <!-- Grand/Xo'jalik shartonmalar Dropdown Menu -->
                <li class="nav-item">
                    <a href="<?php echo e(route('student.grand-economy')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>Grant/Xo'jalik shartonmalar</p>
                    </a>
                </li>
                <!-- Olimpiyadalar Dropdown Menu -->
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('student.olympics')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-medal"></i>
                        <p>Olimpiyadalar</p>
                    </a>
                </li>
                <!-- Til sertifikati Dropdown Menu -->
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('student.lang-certificate')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-language"></i>
                        <p>Til Sertifikatlari</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('student.achievement')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-award"></i>
                        <p>O’quv yili davomida erishgan <br>boshqa yutuqlari</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('student.distinguished-scholarship')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-trophy"></i>
                        <p>Nomdor stipendiyaga ariza topshirish</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p> Statistika <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('student.rating.faculty')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fakultet reytingi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('student.rating.institute')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Institut reytingi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('student.evaluation-criteria')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Baholash me'zoni</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('student.chat')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Professor o'qituvchi bilan chat</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/layouts/student/sidebar.blade.php ENDPATH**/ ?>