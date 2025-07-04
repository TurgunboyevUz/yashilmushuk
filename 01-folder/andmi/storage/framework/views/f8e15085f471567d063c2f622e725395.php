<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Biriktirilgan talabalar reytingi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Biriktirilgan talabalar reytingi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Talabalar ma'lumotlari</h3>
                    <div class="float-right">
                        <button class="btn btn-success btn-sm mr-2" id="excel-download" onclick="window.location = '<?php echo e(route('excel.attached-students')); ?>';">
                            <i class="fas fa-file-excel"></i> Excel Yuklash
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="students-table" class="table table-bordered table-responsive table-hover" style="display: block; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" id="select-all"></th>
                                <th class="text-center">#</th>
                                <th class="text-center">Rasmi</th>
                                <th class="text-center">Talaba FIO</th>
                                <th class="text-center">Kurs</th>
                                <th class="text-center">Yo'nalish</th>
                                <th colspan="4" class="text-center">Maqolalar</th>
                                <th colspan="3" class="text-center">Stipendiyalar</th>
                                <th colspan="3" class="text-center">Ixtiro/DGU/Foydali model</th>
                                <th colspan="2" class="text-center">Startup/Tanlov</th>
                                <th colspan="2" class="text-center">Grand/Xo'jalik</th>
                                <th colspan="3" class="text-center">Olimpiyadalar</th>
                                <th colspan="3" class="text-center">Til sertifikatlari</th>
                                <th class="text-center">Yutuqlar</th>
                                <th class="text-center">Umumiy Ball</th>
                                <!-- <th class="text-center">Harakatlar</th> -->
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="rotate">SCOPUS</th>
                                <th class="rotate">Mahalliy</th>
                                <th class="rotate">Xorijiy</th>
                                <th class="rotate">Tezis</th>
                                <th class="rotate">Institut</th>
                                <th class="rotate">Viloyat</th>
                                <th class="rotate">Respublika</th>
                                <th class="rotate">Ixtiro</th>
                                <th class="rotate">DGU</th>
                                <th class="rotate">Foydali model</th>
                                <th class="rotate">Startup</th>
                                <th class="rotate">Tanlov</th>
                                <th class="rotate">Grand</th>
                                <th class="rotate">Xo'jalik</th>
                                <th class="rotate">Institut</th>
                                <th class="rotate">Viloyat</th>
                                <th class="rotate">Xalqaro</th>
                                <th class="rotate">Rus</th>
                                <th class="rotate">Ingliz</th>
                                <th class="rotate">Nemis</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><input type="checkbox" class="student-checkbox"></td>
                                <td><?php echo e($i++); ?></td>
                                <td><img src="<?php echo e($student['picture_path']); ?>" alt="Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;" loading="lazy"></td>
                                <td><?php echo e($student['fio']); ?></td>
                                <td><?php echo e($student['level']); ?>-kurs</td>
                                <td><?php echo e($student['direction']); ?></td>
                                <td><?php echo e($student['articles']['scopus'] ?? 0); ?></td>
                                <td><?php echo e($student['articles']['local'] ?? 0); ?></td>
                                <td><?php echo e($student['articles']['global'] ?? 0); ?></td>
                                <td><?php echo e($student['articles']['thesis'] ?? 0); ?></td>
                                <td><?php echo e($student['scholarships']['institute'] ?? 0); ?></td>
                                <td><?php echo e($student['scholarships']['region'] ?? 0); ?></td>
                                <td><?php echo e($student['scholarships']['republic'] ?? 0); ?></td>
                                <td><?php echo e($student['inventions']['invention'] ?? 0); ?></td>
                                <td><?php echo e($student['inventions']['dgu'] ?? 0); ?></td>
                                <td><?php echo e($student['inventions']['model'] ?? 0); ?></td>
                                <td><?php echo e($student['startups']['startup'] ?? 0); ?></td>
                                <td><?php echo e($student['startups']['contest'] ?? 0); ?></td>
                                <td><?php echo e($student['grands']['grand'] ?? 0); ?></td>
                                <td><?php echo e($student['grands']['economy'] ?? 0); ?></td>
                                <td><?php echo e($student['olympics']['institute'] ?? 0); ?></td>
                                <td><?php echo e($student['olympics']['region'] ?? 0); ?></td>
                                <td><?php echo e($student['olympics']['republic'] ?? 0); ?></td>
                                <td><?php echo e($student['lang']['ru'] ?? 0); ?></td>
                                <td><?php echo e($student['lang']['en'] ?? 0); ?></td>
                                <td><?php echo e($student['lang']['de'] ?? 0); ?></td>
                                <td><?php echo e($student['achievements'] ?? 0); ?></td>
                                <td><?php echo e($student['total_score'] ?? 0); ?> ball</td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::employee.teacher.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/teacher/rating/attached-students.blade.php ENDPATH**/ ?>