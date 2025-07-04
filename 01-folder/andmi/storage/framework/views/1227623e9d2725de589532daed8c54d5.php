<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Topshiriq Yaratish</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Topshiriq yaratish</li>
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
                    <h3 class="card-title">Yangi Topshiriq Yaratish</h3>
                </div>
                <div class="card-body">
                    <form id="assignmentForm" action="<?php echo e(route('employee.teacher.tasks')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="studentSelect">Talabani tanlang:</label>
                            <select name="student_id" id="studentSelect" class="form-control" required>
                                <option value="" disabled selected>Talabani tanlang</option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>"><?php echo e($student->user->fio()); ?> (<?php echo e($student->level); ?>-kurs <?php echo e($student->direction->name); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('student_id')): ?>
                                <span class="text-danger"><?php echo e($errors->first('student_id')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="assignmentTitle">Topshiriq Nomi:</label>
                            <input name="title" type="text" id="assignmentTitle" class="form-control" placeholder="Topshiriq nomini kiriting" required>
                            <?php if($errors->has('title')): ?>
                                <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="assignmentDescription">Topshiriq Ta'rifi:</label>
                            <textarea name="description" id="assignmentDescription" class="form-control" rows="4" placeholder="Topshiriq ta'rifini kiriting" required></textarea>
                            <?php if($errors->has('description')): ?>
                                <span class="text-danger"><?php echo e($errors->first('description')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="assignmentFile">Fayl yuklash:</label>
                            <input name="file" type="file" id="assignmentFile" class="form-control-file" required>
                            <?php if($errors->has('file')): ?>
                                <span class="text-danger"><?php echo e($errors->first('file')); ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Yaratish</button>
                    </form>
                </div>
            </div>

            <!-- Yaratilgan topshiriqlar jadvai -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Yaratilgan topshiriqlar</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive table-bordered" id="assignmentTasks">
                        <thead>
                            <tr>
                                <th style="width: 3%;">#</th>
                                <th>Topshiriq Nomi</th>
                                <th>Talaba</th>
                                <th>Topshiriq ta'rifi</th>
                                <th>Fayl</th>
                                <th>Vaqti</th>
                                <th>Harakatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>

                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($item->title); ?></td>
                                <td><?php echo e($item->student->user->short_fio()); ?></td>
                                <td><?php echo e($item->description); ?></td>
                                <td><a href="<?php echo e(route('storage.download', ['uuid' => $item->file->uuid])); ?>" target="_blank"><?php echo e($item->file->name); ?></a></td>
                                <td><?php echo e(Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s')); ?></td>
                                <td>
                                    <form action="<?php echo e(route('employee.teacher.tasks.destroy')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> O'chirish</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts::employee.teacher.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/teacher/tasks.blade.php ENDPATH**/ ?>