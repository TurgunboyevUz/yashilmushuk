<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Institut bo'yicha umumiy reyting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Institut bo'yicha umumiy reyting</li>
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
                            <h3 class="card-title">Institutdagi talabalar reytingi</h3>
                            <div class="ml-auto d-flex">
                                <button id="excelDownload" class="btn btn-success" onclick="window.location = '<?php echo e(route('excel.student-institute')); ?>';">
                                    <i class="fas fa-file-excel"></i> Excel yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table id="studentsInstituteRatingTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">#</th>
                                            <th>Talaba FIO</th>
                                            <th>Kursi</th>
                                            <th>Fakulteti</th>
                                            <th>Yo'nalishi</th>
                                            <th>Umumiy ball</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($i++); ?></td>
                                            <td><?php echo e($student['fio']); ?></td>
                                            <td><?php echo e($student['level']); ?>-kurs</td>
                                            <td><?php echo e($student['faculty']); ?></td>
                                            <td><?php echo e($student['direction']); ?></td>
                                            <td><?php echo e($student['total_score']); ?></td>
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

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/rating/institute.blade.php ENDPATH**/ ?>