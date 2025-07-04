<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bosh sahifa</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Profil Card -->
                <div class="col-md-4">
                    <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-info">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="<?php echo e($user->picture_path()); ?>" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username"><?php echo e($user->surname); ?> <?php echo e($user->name); ?></h3>
                            <h5 class="widget-user-desc">Talaba</h5>
                        </div>
                        <div class="card-body">
                            <hr>
                            <!-- Shaxsiy Ma'lumotlar -->
                            <h4 class="mt-4">Shaxsiy ma'lumotlar</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user"></i> Ism
                                        </td>
                                        <td><?php echo e($user->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-tag"></i> Familiya
                                        </td>
                                        <td><?php echo e($user->surname); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-flag"></i> Millati
                                        </td>
                                        <td><?php echo e($user->nation->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-graduation-cap"></i> Guruh
                                        </td>
                                        <td><?php echo e($user->student->group->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-level-up-alt"></i> Bosqich
                                        </td>
                                        <td><?php echo e($user->student->level); ?> kurs</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-calendar-alt"></i> Tug'ilgan sanasi
                                        </td>
                                        <td><?php echo e(Carbon\Carbon::parse($user->birth_date)->format('d-m-Y')); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-passport"></i> Pasport seriyasi
                                        </td>
                                        <td><?php echo e($user->passport_number); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-university"></i> Fakultet
                                        </td>
                                        <td><?php echo e($user->student->faculty->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-home"></i> Doimiy yashash manzili
                                        </td>
                                        <td><?php echo e($user->student->address); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-id-card"></i> JSHSHIR raqami
                                        </td>
                                        <td><?php echo e($user->passport_pin); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-phone"></i> Telefon raqami
                                        </td>
                                        <td><?php echo e($user->phone); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Right Side Cards -->
                <div class="col-md-8">
                    <div class="row">
                        <!-- Guruh Tarkibi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h3 class="card-title">Guruh tarkibi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <div class="list-group">
                                        <?php $__currentLoopData = $groupmate_scores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="list-group-item d-flex align-items-start mb-3">
                                            <img src="<?php echo e($item['picture_path']); ?>" alt="User Avatar" class="img-circle elevation-2" style="width: 60px; height: 60px;">
                                            <div class="ml-3 flex-grow-1">
                                                <h5 class="mb-0"><?php echo e($item['fio']); ?></h5>
                                                <small class="text-muted">Guruh: <?php echo e($item['group']); ?></small>
                                                <span class="badge bg-primary float-right"><?php echo e($item['total_score']); ?></span>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fakultet Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h3 class="card-title">Fakultet reytingi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <ul class="list-group">
                                        <?php $__currentLoopData = $facultymate_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="mr-2">
                                                <img src="<?php echo e($item['picture_path']); ?>" alt="User Avatar" class="img-circle elevation-2" style="width: 60px; height: 60px;">
                                            </span>
                                            <div class="ml-3">
                                                <h5 class="mb-0"><?php echo e($item['fio']); ?></h5>
                                                <p class="mb-0 text-muted">Yo'nalish: <?php echo e($item['direction']); ?>

                                                </p>
                                                <p class="mb-0 text-muted">Kurs: <?php echo e($item['level']); ?>-kurs</p>
                                            </div>
                                            <span class="badge bg-primary ml-auto"><?php echo e($item['total_score']); ?></span>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Guruh Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-success">
                                <div class="card-header bg-success">
                                    <h3 class="card-title">Guruh reytingi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <ul class="list-group">
                                        <?php $__currentLoopData = $groupmate_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="<?php echo e($item['picture_path']); ?>" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;"><?php echo e($item['fio']); ?></span>
                                                <br>
                                                <small class="text-muted">Guruh: <?php echo e($item['group']); ?></small>
                                            </div>
                                            <span class="badge bg-primary"><?php echo e($item['total_score']); ?></span>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- User List -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Institut Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">Institut reytingi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <ul class="list-group">
                                        <?php $__currentLoopData = $institute_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="<?php echo e($item['picture_path']); ?>" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;"><?php echo e($item['fio']); ?></span>
                                                <br>
                                                <small class="text-muted">Fakultet: <?php echo e($item['faculty']); ?> <br>
                                                    Yo'nalish: <?php echo e($item['direction']); ?> </small>
                                            </div>
                                            <span class="badge bg-primary"><?php echo e($item['total_score']); ?></span>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/dashboard.blade.php ENDPATH**/ ?>