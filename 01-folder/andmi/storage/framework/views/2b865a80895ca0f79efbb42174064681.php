<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Talabalar ro'yxati</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Talabalar ro'yxati</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Biriktirilgan talabalar ro'yxati</h3>
                            <div class="ml-auto d-flex">
                                <button class="btn btn-success" onclick="return confirm('Chindan ham jadvalni Excel holatda yuklaysizmi?')">
                                    <i class="fas fa-file-excel"></i> Excelda yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="studentsTable" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 7%;">Rasmi</th>
                                            <th>Ism Familyasi</th>
                                            <th>Fakultet</th>
                                            <th>Yo'nalish</th>
                                            <th style="width: 8%;">Kurs</th>
                                            <th style="width: 8%;">Umumiy ball</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>1</td>
                                                <td><center><img src="<?php echo e($student->user->picture_path()); ?>" alt="User" class="img-circle" style="height: 30px;"></center></td>
                                                <td><?php echo e($student->user->fio()); ?></td>
                                                <td><?php echo e($student->faculty->name); ?></td>
                                                <td><?php echo e($student->direction->name); ?></td>
                                                <td><?php echo e($student->level); ?></td>
                                                <td><?php echo e($student->user->student_files()->sum('student_score')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts::employee.talent.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/talent/student-list.blade.php ENDPATH**/ ?>