<?php $__env->startSection('content'); ?>
<div class="content-wrapper" style="padding: 20px;">
    <section class="content-header">
        <h1>BMI uchun ball olish imkoniyatlari</h1>
    </section>

    <section class="content">
        <div class="container-fluid my-4">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Ball olish uchun imkoniyatlar</h3>
                </div>
                <div class="card-body">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th>Imkoniyat turi</th>
                                <th>Faoliyat</th>
                                <th>Ball</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $count = $category->criterias->count();
                                ?>

                                <?php $__currentLoopData = $category->criterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $criteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if($index == 0): ?>
                                            <td rowspan="<?php echo e($count); ?>"> <?php echo e($category->name); ?> </td>
                                        <?php endif; ?>
                                        <td> <?php echo e($criteria->name); ?> </td>
                                        <td> <?php echo e($criteria->score); ?> ball</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/evaluation-criteria.blade.php ENDPATH**/ ?>