<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>O'quv yili davomida erishgan yutuqlar</h1>
    </section>

    <!-- Card boshi -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Yutuq qo'shish</h3>
        </div>
        <div class="card-body">
            <form id="achievementForm" action="<?php echo e(route('student.achievement')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <!-- Yutuq turi -->
                    <div class="col-md-6 mb-3">
                        <label for="achievementType" class="form-label">
                            <i class="fas fa-trophy"></i> Yutuq turi
                        </label>
                        <select id="achievementType" class="form-control" name="type" required>
                            <option value="" disabled selected>Tanlang</option>
                            <option value="sport">Sport</option>
                            <option value="cultural">Ma'naviy-ma'rifiy ishlar</option>
                        </select>
                        <?php if($errors->has('type')): ?>
                        <span class="text-danger"><?php echo e($errors->first('type')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Darajasi -->
                    <div class="col-md-6 mb-3">
                        <label for="degree" class="form-label">
                            <i class="fas fa-layer-group"></i> Darajasi
                        </label>
                        <select id="level" class="form-control" name="criteria_id" required>
                            <option value="" disabled selected>Tanlang</option>
                            <?php $__currentLoopData = $criterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($criteria->id); ?>"><?php echo e($criteria->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('criteria_id')): ?>
                        <span class="text-danger"><?php echo e($errors->first('criteria_id')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Ishtirokchilar -->
                    <div class="col-md-6 mb-3">
                        <label for="participant" class="form-label">
                            <i class="fas fa-users"></i> Ishtirokchilar
                        </label>
                        <select id="participants" class="form-control" name="participant" required onchange="toggleTeamInputs()">
                            <option value="" disabled selected>Tanlang</option>
                            <option value="team">Jamoaviy</option>
                            <option value="individual">Yakkalik</option>
                        </select>
                        <?php if($errors->has('participant')): ?>
                        <span class="text-danger"><?php echo e($errors->first('participant')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- F.I.SH (agar jamoaviy tanlansa) -->
                    <div class="col-md-12 mb-3" id="teamMembers" style="display: none;">
                        <label for="teamMemberName" class="form-label">
                            <i class="fas fa-user"></i> F.I.SH
                        </label>
                        <input type="text" id="teamMemberName" class="form-control" name="team_members" placeholder="Ishtirokchilar ismi, sharifi">
                        
                        <?php if($errors->has('team_members')): ?>
                        <span class="text-danger"><?php echo e($errors->first('team_members')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- O'tkazilgan joyi -->
                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">
                            <i class="fas fa-map-marker-alt"></i> O'tkazilgan joyi
                        </label>
                        <select id="location" class="form-control" name="location_id" required>
                            <option value="" disabled selected>Tanlang</option>
                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                        <?php if($errors->has('location_id')): ?>
                        <span class="text-danger"><?php echo e($errors->first('location_id')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Hujjat turi -->
                    <div class="col-md-6 mb-3">
                        <label for="document_type" class="form-label">
                            <i class="fas fa-file-alt"></i> Hujjat turi
                        </label>
                        <select id="documentType" class="form-control" name="document_type" required>
                            <option value="" disabled selected>Tanlang</option>
                            <option value="certificate">Sertifikat</option>
                            <option value="diploma">Diplom</option>
                        </select>
                        <?php if($errors->has('document_type')): ?>
                        <span class="text-danger"><?php echo e($errors->first('document_type')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Fayl yuklash -->
                    <div class="col-md-12 mb-3">
                        <label for="uploadFile" class="form-label">
                            <i class="fas fa-file-upload"></i> Fayl yuklash
                        </label>
                        <input type="file" name="file" id="uploadFile" class="form-control" required>
                        <?php if($errors->has('file')): ?>
                        <span class="text-danger"><?php echo e($errors->first('file')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Saqlash tugmasi -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Jadval qismi -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Yutuqlar Ro'yxati</h3>
        </div>
        <div class="card-body p-4 table-responsive">
            <table class="table table-bordered table-hover table-responsive">
                <thead class="thead">
                    <tr>
                        <th>Yutuq turi</th>
                        <th>Darajasi</th>
                        <th>Ishtirokchilar</th>
                        <th>O'tkazilgan joyi</th>
                        <th>Hujjat turi</th>
                        <th>Fayl</th>
                        <th>Holati</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->type()); ?></td>
                        <td><?php echo e($item->criteria->name); ?></td>
                        <td><?php echo e($item->team_members()); ?></td>
                        <td><?php echo e($item->getLocation()); ?></td>
                        <td><?php echo e($item->document_type()); ?></td>
                        <td><?php echo $item->file->download_tag(); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($item->status()['color']); ?>"><?php echo e($item->status()['name']); ?></span>
                        </td>

                        <?php if($item->file->status == 'pending'): ?>
                        <td>
                            <form action="<?php echo e(route('student.achievement.destroy')); ?>" method="POST">
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
<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/achievement.blade.php ENDPATH**/ ?>