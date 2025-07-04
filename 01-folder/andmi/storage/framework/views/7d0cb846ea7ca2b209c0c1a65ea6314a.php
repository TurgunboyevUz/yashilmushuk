<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Profilni tahrirlash</h1>
    </section>

    <div class="card mt-3">
        <div class="card-body">
            <form id="profileForm" action="<?php echo e(route('employee.inspeksiya.edit-profile')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">Ismi</label>
                        <input type="text" id="firstName" class="form-control" value="<?php echo e($user->name); ?>" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">Familiya</label>
                        <input type="text" id="lastName" class="form-control" value="<?php echo e($user->surname); ?>" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="login" class="form-label">Login</label>
                        <input type="text" id="login" class="form-control" value="<?php echo e($user->hemis_id); ?>" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="passport" class="form-label">Pasport raqami</label>
                        <input type="text" id="passport" class="form-control" value="<?php echo e($user->passport_number); ?>" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" id="email" class="form-control" value="<?php echo e($user->email); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Xodim telefoni (+998 xx xxx-xx-xx)</label>
                        <input name="phone" type="tel" id="phone" class="form-control" value="<?php echo e($user->phone); ?>">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Saqlash
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts::employee.inspeksiya.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/inspeksiya/edit-profile.blade.php ENDPATH**/ ?>