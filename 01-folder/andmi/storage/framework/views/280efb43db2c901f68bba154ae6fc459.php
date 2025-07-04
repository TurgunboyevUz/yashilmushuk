<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Iqtidorli Talabalar Nomdor Stipendiyalari uchun Ariza</h1>
    </section>
    <section class="content">
        <div class="container my-4">
            <div class="card p-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Ariza uchun Kerakli Hujjatlar</h3>
                </div>
                <div class="card-body">
                    <form id="stipendiyaForm" action="<?php echo e(route('student.distinguished-scholarship')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <!-- Talabaning ma’lumotnomasi -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="obektivka">
                                <strong>1. Talabaning ma’lumotnomasi (obektivka)</strong>
                            </label>
                            <input type="file" id="obektivka" class="form-control-file mt-2" name="reference" required>
                            <?php if($errors->has('reference')): ?>
                            <span class="text-danger"><?php echo e($errors->first('reference')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Pasport nusxasi -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="pasport">
                                <strong>2. Pasport nusxasi (rangli)</strong>
                            </label>
                            <input type="file" id="pasport" class="form-control-file mt-2" name="passport" required>
                            <?php if($errors->has('passport')): ?>
                            <span class="text-danger"><?php echo e($errors->first('passport')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Reyting daftarchasi ko'chirma yoki HEMIS transkripti -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="reyt">
                                <strong>3. Reyting daftarchasidan ko‘chirma yoki HEMIS tizimidan transkript</strong>
                            </label>
                            <input type="file" id="reyt" name="rating_book" class="form-control-file mt-2" required>
                            <?php if($errors->has('rating_book')): ?>
                            <span class="text-danger"><?php echo e($errors->first('rating_book')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Dekanning kafolat xati -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="kafolatXati">
                                <strong>4. Dekanning kafolat xati</strong>
                            </label>
                            <input type="file" id="kafolatXati" name="dean_guarantee" class="form-control-file mt-2" required>
                            <?php if($errors->has('dean_guarantee')): ?>
                            <span class="text-danger"><?php echo e($errors->first('dean_guarantee')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Dekan tavsiyanomasi -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="dekanTavsiyanomasi">
                                <strong>5. Dekan tavsiyanomasi</strong>
                            </label>
                            <input type="file" id="dekanTavsiyanomasi" name="dean_recommendation" class="form-control-file mt-2" required>
                            <?php if($errors->has('dean_recommendation')): ?>
                            <span class="text-danger"><?php echo e($errors->first('dean_recommendation')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Fakultet bayonnomasidan ko‘chirma -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="fakultetBayonnoma">
                                <strong>6. Fakultet bayonnomasidan ko‘chirma</strong>
                            </label>
                            <input type="file" id="fakultetBayonnoma" name="faculty_statement" class="form-control-file mt-2" required>
                            <?php if($errors->has('faculty_statement')): ?>
                            <span class="text-danger"><?php echo e($errors->first('faculty_statement')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Kafedra mudiri tavsiyanomasi -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="kafedraTavsiyanomasi">
                                <strong>7. Kafedra mudiri tavsiyanomasi</strong>
                            </label>
                            <input type="file" id="kafedraTavsiyanomasi" name="department_recommendation" class="form-control-file mt-2" required>
                            <?php if($errors->has('department_recommendation')): ?>
                            <span class="text-danger"><?php echo e($errors->first('department_recommendation')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Ilmiy rahbarining xulosasi -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="ilmiyRahbarXulosa">
                                <strong>8. Ilmiy rahbarining xulosasi</strong>
                            </label>
                            <input type="file" id="ilmiyRahbarXulosa" name="supervisor_conclusion" class="form-control-file mt-2" required>
                            <?php if($errors->has('supervisor_conclusion')): ?>
                            <span class="text-danger"><?php echo e($errors->first('supervisor_conclusion')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Ilmiy (ijodiy) ishlar ro‘yxati -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="ijodiyIshlar">
                                <strong>9. Ilmiy (ijodiy) ishlar ro‘yxati (2-ilova)</strong>
                            </label>
                            <input type="file" id="ijodiyIshlar" name="list_of_works" class="form-control-file mt-2" required>
                            <?php if($errors->has('list_of_works')): ?>
                            <span class="text-danger"><?php echo e($errors->first('list_of_works')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Diplom, sertifikat va faxriy yorliqlar -->
                        <div class="form-group mb-4 p-3 border rounded">
                            <label for="diplomlar">
                                <strong>10. Diplom, sertifikat va faxriy yorliqlar</strong>
                            </label>
                            <input type="file" id="diplomlar" name="certificates" class="form-control-file mt-2" required>
                            <?php if($errors->has('certificates')): ?>
                            <span class="text-danger"><?php echo e($errors->first('certificates')); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Jo'natish tugmasi -->
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-m">
                                <i class="fas fa-check"></i> Jo'natish </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Responsive Jadval qo'shish -->
        <div class="card mt-4 table-responsive">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Stipendiya Arizalari Ro'yxati</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Talaba nomi</th>
                            <th>Pasport nusxasi</th>
                            <th>Reyting daftarchasi</th>
                            <th>Fakultet bayonnomasi</th>
                            <th>Kafedra mudiri tavsiyanomasi</th>
                            <th>Ariza holati</th>
                            <th>Harakatlar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 1; ?>

                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item[0]->user->fio()); ?></td>
                            <td><?php echo $item[0]->download_tag(); ?></td>
                            <td><?php echo $item[1]->download_tag(); ?></td>
                            <td><?php echo $item[2]->download_tag(); ?></td>
                            <td><?php echo $item[3]->download_tag(); ?></td>

                            <td><span class="badge badge-<?php echo e($item[0]->status()['color']); ?>"><?php echo e($item[0]->status()['name']); ?></span></td>
                            <?php if($item[0]->status == 'pending'): ?>
                            <td>
                                <form action="<?php echo e(route('student.distinguished-scholarship.destroy')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <input type="hidden" name="id" value="<?php echo e($key); ?>">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> O'chirish</button>
                                </form>
                            </td>
                            <?php elseif($item[0]->status == 'rejected'): ?>
                            <td>
                                <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="<?php echo e($item[0]->reject_reason); ?>">
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
                        <!-- Qo'shimcha talabalar ma'lumotlari qo'shiladi -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/distinguished-scholarship.blade.php ENDPATH**/ ?>