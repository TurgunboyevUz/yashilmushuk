<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">O'quv Yili Davomida Erishgan Boshqa Yutuqlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Boshqa Yutuqlar</li>
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
                            <h3 class="card-title">Barcha Yutuqlar</h3>
                            <div class="ml-auto d-flex">
                                <button id="zipDownload" class="btn btn-success" data-url="<?php echo e(route('storage.zip')); ?>"  data-name="achievements">
                                    <i class="fas fa-file-archive"></i> ZIP Yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table id="achievementsTable" class="table table-bordered table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;"><input type="checkbox" id="checkAll"></th>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 7%;">Rasmi</th>
                                            <th>Talaba FIO</th>
                                            <th>Yutuq Turi</th>
                                            <th>Darajasi</th>
                                            <th>Ishtirokchilar</th>
                                            <th>O'tkazilgan Joyi</th>
                                            <th>Hujjat Turi</th>
                                            <th>Fayl</th>
                                            <th>Holati</th>
                                            <th>Harakatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $id = 1;
                                        ?>

                                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><input type="checkbox" class="checkItem" data-uuid="<?php echo e($item->uuid); ?>"></td>
                                            <td><?php echo e($id++); ?></td>
                                            <td><img src="<?php echo e($item->user->picture_path()); ?>" alt="User" class="img-circle" style="height: 30px;"></td>
                                            <td><?php echo e($item->user->fio()); ?></td>
                                            <td><?php echo e($item->achievement->type()); ?></td>
                                            <td><?php echo e($item->achievement->criteria->name); ?></td>
                                            <td><?php echo e($item->achievement->team_members()); ?></td>
                                            <td><?php echo e($item->achievement->getLocation()); ?></td>
                                            <td><?php echo e($item->achievement->document_type()); ?></td>
                                            <td><?php echo $item->download_tag(); ?></td>
                                            <td><span class="badge badge-<?php echo e($item->status()['color']); ?>"><?php echo e($item->status()['name']); ?></span></td>
                                            <?php if($item->status == 'pending'): ?>
                                            <td>
                                                <button class="btn btn-sm btn-success confirmAction" data-id="<?php echo e($item->achievement->id); ?>" data-url="<?php echo e(route('employee.teacher.achievement.review')); ?>" ><i class="fas fa-check"></i></button>
                                                <button class="btn btn-sm btn-danger cancelAction" data-id="<?php echo e($item->achievement->id); ?>" data-url="<?php echo e(route('employee.teacher.achievement.reject')); ?>" ><i class="fas fa-ban"></i></button>
                                            </td>
                                            <?php elseif($item->status == 'rejected'): ?>
                                            <td>
                                                <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="<?php echo e($item->reject_reason); ?>">
                                                    <i class="fa fa-eye fa-sm"></i>
                                                </button>
                                            </td>
                                            <?php else: ?>
                                            <td>Bu fayl uchun harakat imkonsiz</td>
                                            <?php endif; ?>
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

<?php echo $__env->make('layouts::employee.teacher.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/teacher/achievement.blade.php ENDPATH**/ ?>