<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Ixtro/DGU/Foydali model</h1>
    </section>

    <!-- Intellektual mulk yaratish shakli -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Intellektual Mulk Yaratish</h3>
        </div>
        <div class="card-body">
            <form id="inventionForm" action="<?php echo e(route('student.invention')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <!-- Talaba FIO -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="studentName"><i class="fas fa-user"></i> Talaba FIO</label>
                        <input type="text" id="studentName" name="student_name" class="form-control" placeholder="<?php echo e($user->fio()); ?>" disabled required>
                    </div>
                    <!-- Intellektual Mulk Nomi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="propertyTitle"><i class="fas fa-book"></i> Intellektual Mulk Nomi</label>
                        <input type="text" id="propertyTitle" name="title" class="form-control" placeholder="Intellektual mulk nomi" required>
                    </div>
                    <!-- Intellektual Mulk Turi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="propertyType"><i class="fas fa-file-alt"></i> Intellektual Mulk Turi</label>
                        <select id="propertyType" name="criteria_id" class="form-control" required>
                            <option value="" disabled selected>Tanlang...</option>
                            <?php $__currentLoopData = $criterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($criteria->id); ?>"><?php echo e($criteria->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!-- Intellektual Mulk Raqami -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="propertyNumber"><i class="fas fa-hashtag"></i> Intellektual Mulk Raqami</label>
                        <input type="text" id="propertyNumber" name="property_number" class="form-control" placeholder="12345" required>
                    </div>
                    <!-- Mualliflar soni -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="authorCount"><i class="fas fa-users"></i> Mualliflar soni</label>
                        <input type="number" id="authorCount" name="authors_count" class="form-control" placeholder="Mualliflar soni" required>
                    </div>
                    <!-- Mualliflar -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="authors"><i class="fas fa-user-friends"></i> Mualliflar</label>
                        <input type="text" id="authors" name="authors" class="form-control" placeholder="Samadov Fahriddin, Anvarov Oyatillo" required>
                        <small class="form-text text-muted">Masalan: Samadov, Anvarov Oyatillo, Diyorbek Turg'unboyev</small>
                    </div>
                    <!-- Nashr Parametrlari -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="publicationParams"><i class="fas fa-newspaper"></i> Nashr Parametrlari</label>
                        <input type="text" id="publicationParams" name="publish_params" class="form-control" placeholder="Nashr haqida ma'lumot" required>
                    </div>
                    <!-- O'quv yili -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="academicYear"><i class="fas fa-calendar"></i> O'quv yili</label>
                        <select class="form-control" id="academicYear" name="education_year">
                            <option value="" disabled selected>Tanlang</option>
                            <?php $__currentLoopData = $education_year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year->id); ?>"><?php echo e($year->name); ?></option>                                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!-- Fayl Yuklash -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="fileUpload"><i class="fas fa-upload"></i> Fayl Yuklash</label>
                        <input type="file" id="fileUpload" name="file" class="form-control-file" required>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Saqlash</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Jadval: Intellektual mulklar ro'yxati -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Yuklangan Intellektual Mulklar ro'yxati</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Talaba FIO</th>
                        <th>Intellektual Mulk Nomi</th>
                        <th>Turi</th>
                        <th>Raqami</th>
                        <th>Mualliflar soni</th>
                        <th>Mualliflar</th>
                        <th>Nashr Parametrlari</th>
                        <th>O'quv yili</th>
                        <th>Fayl nomi</th>
                        <th>Holati</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>        
                        <td><?php echo e($user->fio()); ?></td>
                        <td><?php echo e($item->title); ?></td>
                        <td><?php echo e($item->criteria->name); ?></td>
                        <td><?php echo e($item->property_number); ?></td>
                        <td><?php echo e($item->authors_count); ?></td>
                        <td><?php echo e($item->authors); ?></td>
                        <td><?php echo e($item->publish_params); ?></td>
                        <td><?php echo e($item->education_year->name); ?></td>
                        <td><?php echo $item->file->download_tag(); ?></td>
                        <td><span class="badge badge-<?php echo e($item->status()['color']); ?>"><?php echo e($item->status()['name']); ?></span></td>
                                    
                        <?php if($item->file->status == 'pending'): ?>
                            <td>
                                <form action="<?php echo e(route('student.invention.destroy')); ?>" method="POST">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/invention.blade.php ENDPATH**/ ?>