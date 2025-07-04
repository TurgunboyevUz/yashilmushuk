<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Topshiriqlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Berilgan topshiriqlar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Topshiriqlar ro'yxati -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Berilgan Topshiriqlar</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
			<?php if(count($data) == 0): ?>
			    <h5 align="center">Berilgan topshiriqlar mavjud emas.</h5>
			<?php endif; ?>
                        <?php $i = 1; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="fas fa-file-alt"></i> <?php echo e($i++); ?>. <?php echo e($item->title); ?></h5>
                                    <a href="<?php echo e(route('storage.download', ['uuid' => $item->file->uuid])); ?>" class="btn btn-sm btn-success" download><i class="fas fa-download"></i> Yuklab Olish</a>
                                </div>
                                <p class="mb-1"><?php echo e($item->description); ?></p>
                                <small class="text-muted">Topshiriq yuklangan sana: <?php echo e($item->created_at->format('H:i d-m-Y')); ?></small>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/assignments.blade.php ENDPATH**/ ?>