<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Stipendiya Yutuqlari</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Yutuq ma'lumotlarini kiritish shakli -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Yutuq ma'lumotlarini kiritish</h3>
                </div>
                <form action="<?php echo e(route('student.scholarship')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">
                            <!-- Yutuq turi -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="awardType"><i class="fas fa-trophy"></i> Yutuq turi</label>
                                    <select class="form-control" id="awardType" name="criteria_id" required>
                                        <option selected disabled>Yutuq turini tanlang:</option>
                                        <?php $__currentLoopData = $criterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($criteria->id); ?>"><?php echo e($criteria->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <?php if($errors->has('criteria_id')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('criteria_id')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Yutuq berilgan sana -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="awardDate"><i class="fas fa-calendar-alt"></i> Yutuq berilgan sana</label>
                                    <input type="date" class="form-control" id="awardDate" name="given_date" required>
                                    <?php if($errors->has('given_date')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('given_date')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Guvohnoma raqami -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="certificateNumber"><i class="fas fa-id-card"></i> Guvohnoma raqami</label>
                                    <input type="text" class="form-control" id="certificateNumber" name="certificate_number" placeholder="Guvohnoma raqamini kiriting" required>
                                    <?php if($errors->has('certificate_number')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('certificate_number')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Nomi -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="awardName"><i class="fas fa-file-alt"></i> Yutuq nomi</label>
                                    <input type="text" class="form-control" id="awardName" name="title" placeholder="Yutuq nomini kiriting" required>
                                    <?php if($errors->has('title')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Fayl yuklash -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="fileUpload"><i class="fas fa-upload"></i> Fayl yuklash</label>
                                    <input type="file" class="form-control-file" id="fileUpload" name="file" required>
                                    <?php if($errors->has('file')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('file')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Saqlash</button>
                    </div>
                </form>
            </div>

            <!-- Jadval: Yuklangan Stipendiya Yutuqlari Ro'yxati -->
            <div class="card card-primary mt-4">
                <div class="card-header">
                    <h3 class="card-title">Yuklangan Stipendiya Yutuqlari Ro'yxati</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Yutuq turi</th>
                                    <th>Berilgan sana</th>
                                    <th>Guvohnoma raqami</th>
                                    <th>Nomi</th>
                                    <th>Fayl nomi</th>
                                    <th>Holati</th>
                                    <th>Harakatlar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->criteria->name); ?></td>
                                    <td><?php echo e($item->given_date); ?></td>
                                    <td><?php echo e($item->certificate_number); ?></td>
                                    <td><?php echo e($item->title); ?></td>
                                    <td><?php echo $item->file->download_tag(); ?></td>
                                    <td><span class="badge badge-<?php echo e($item->status()['color']); ?>"><?php echo e($item->status()['name']); ?></span></td>
                                    
                                    <?php if($item->file->status == 'pending'): ?>
                                        <td>
                                            <form action="<?php echo e(route('student.scholarship.destroy')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> O'chirish</button>
                                            </form>
                                        </td>
                                    <?php elseif($item->file->status == 'rejected'): ?>
                                        <td>
                                            <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="<?php echo e($item->file->reject_reason); ?>">
                                                <i class="fa fa-eye fa-sm"></i>
                                            </button>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            Bu fayl uchun harakat imkonsiz
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/scholarship.blade.php ENDPATH**/ ?>