<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Biriktilgan talabalar ro'yxati</h3>
                            <div class="ml-auto d-flex">
                                <button id="excelDownload" class="btn btn-success" onclick="window.location = '<?php echo e(route('excel.attached-students-list')); ?>';">
                                    <i class="fas fa-file-excel"></i> Excel yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th>Rasmi</th>
                                            <th>Talaba ismi, familiyasi</th>
                                            <th>Yo'nalishi</th>
                                            <th>Guruhi</th>
                                            <th>Kursi</th>
                                            <th>Biriktirilgan o'qituvchi</th>
                                            <th>Harakatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $id = 1; ?>

                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($id++); ?></td>
                                            <td><img src="<?php echo e($student->user->picture_path()); ?>" alt="User" class="img-circle" style="height: 30px;"></td>

                                            <td><?php echo e($student->user->short_fio()); ?></td>
                                            <td><?php echo e($student->direction->name); ?></td>
                                            <td><?php echo e($student->group->name); ?></td>
                                            <td><?php echo e($student->level); ?></td>
                                            <td><?php echo e($student->employee->user->short_fio()); ?></td>
                                            <td>
                                                <form action="<?php echo e(route('employee.dean.detach-student')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <input type="hidden" name="id" value="<?php echo e($student->id); ?>">
                                                    <button class="btn btn-danger btn-sm" type="submit">
                                                        <i class="fas fa-trash-alt"></i> O'chirish
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- Qo'shimcha talabalar ma'lumotlari qo'shiladi -->
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
<?php echo $__env->make('layouts::employee.dean.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/dean/attached-students.blade.php ENDPATH**/ ?>