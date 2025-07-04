<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Maqola yuklash</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Maqola yuklash formasi -->
        <div class="card card-primary mb-4">
            <div class="card-header">
                <h3 class="card-title">Ilmiy nashr qo'shish</h3>
            </div>
            <form action="<?php echo e(route('student.article')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="full_name"><i class="fas fa-user"></i> Talaba FIO</label>

                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo e($user->fio()); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="ilmiy_ish_nomi"><i class="fas fa-book"></i> Ilmiy ish nomi</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <?php if($errors->has('title')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="keywords"><i class="fas fa-key"></i> Kalit so'zlar</label>
                                <input type="text" class="form-control" id="keywords" name="keywords">
                                <?php if($errors->has('keywords')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('keywords')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="nashr_turi"><i class="fas fa-list-alt"></i> Ilmiy nashr turi</label>
                                <select id="nashr_turi" class="form-control" name="criteria_id" required>
                                    <?php $__currentLoopData = $criterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($criteria->id); ?>"><?php echo e($criteria->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('criteria_id')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('criteria_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="til"><i class="fas fa-language"></i> Til</label>
                                <select id="til" class="form-control" name="lang" required>
                                    <option value="uz">O'zbek tili</option>
                                    <option value="ru">Rus tili</option>
                                    <option value="en">Ingliz tili</option>
                                </select>
                                <?php if($errors->has('lang')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('lang')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="muallif_soni"><i class="fas fa-users"></i> Mualliflar soni</label>
                                <input type="number" class="form-control" id="muallif_soni" name="authors_count" min="1" required>
                                <?php if($errors->has('authors_count')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('authors_count')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="mualliflar"><i class="fas fa-user-friends"></i> Mualliflar</label>
                                <input type="text" class="form-control" id="mualliflar" name="authors" placeholder="Masalan: Samadov, Anvarov Oyatillo, Diyorbek Turg'unboyev">
                                <small class="form-text text-muted">Masalan: Samadov, Anvarov Oyatillo, Diyorbek
                                    Turg'unboyev</small>
                                <?php if($errors->has('authors')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('authors')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="doi"><i class="fas fa-link"></i> DOI</label>
                                <input type="text" class="form-control" id="doi" name="doi">
                                <?php if($errors->has('doi')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('doi')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="manba_nomi"><i class="fas fa-newspaper"></i> Manba (Jurnal) nomi</label>
                                <input type="text" class="form-control" id="manba_nomi" name="journal_name">
                                <?php if($errors->has('journal_name')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('journal_name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="ilmiy_baza"><i class="fas fa-database"></i> Xalqaro ilmiy bazalar</label>
                                <input type="text" class="form-control" id="ilmiy_baza" name="international_databases">
                                <?php if($errors->has('international_databases')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('international_databases')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nashr_yili"><i class="fas fa-calendar-alt"></i> Nashr yili</label>
                                <input type="number" class="form-control" id="nashr_yili" name="published_year" min="1900" max="2100">
                                <?php if($errors->has('published_year')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('published_year')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nashr_parametrlari"><i class="fas fa-cog"></i> Nashr parametrlari</label>
                                <input type="text" class="form-control" id="nashr_parametrlari" name="publish_params">
                                <?php if($errors->has('publish_params')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('publish_params')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="oquv_yili"><i class="fas fa-graduation-cap"></i> O'quv yili</label>
                                <select class="form-control" id="oquv_yili" name="education_year">
                                    <option value="" disabled selected>Tanlang</option>
                                    <?php $__currentLoopData = $education_year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($year->id); ?>"><?php echo e($year->name); ?></option>                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('education_year')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('education_year')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="file"><i class="fas fa-file-upload"></i> Fayl yuklash</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                        <?php if($errors->has('file')): ?>
                            <span class="text-danger"><?php echo e($errors->first('file')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Yuklash</button>
                </div>
            </form>
        </div>

        <!-- Yuklangan fayllar ro'yxati -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Yuklangan fayllar ro'yxati</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-responsive" style="">
                        <thead>
                            <tr>
                                <th>Talaba ism, familiyasi</th>
                                <th>Ilmiy ish nomi</th>
                                <th>Kalit so'zlar</th>
                                <th>Ilmiy nashr turi</th>
                                <th>Til</th>
                                <th>Mualliflar</th>
                                <th>DOI</th>
                                <th>Manba (Jurnal) nomi</th>
                                <th>Xalqaro ilmiy bazalar</th>
                                <th>Nashr yili</th>
                                <th>Nashr parametrlari</th>
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
                                <td><?php echo e($item->keywords); ?></td>
                                <td><?php echo e($item->criteria->name); ?></td>
                                <td><?php echo e($item->lang()); ?></td>
                                <td><?php echo e($item->authors); ?></td>
                                <td><?php echo e($item->doi); ?></td>
                                <td><?php echo e($item->journal_name); ?></td>
                                <td><?php echo e($item->international_databases); ?></td>
                                <td><?php echo e($item->published_year); ?></td>
                                <td><?php echo e($item->publish_params); ?></td>
                                <td><?php echo e($item->education_year->name); ?></td>
                                <td><?php echo $item->file->download_tag(); ?></td>
                                <td><span class="badge badge-<?php echo e($item->status()['color']); ?>"><?php echo e($item->status()['name']); ?></span></td>
                                    
                                <?php if($item->file->status == 'pending'): ?>
                                    <td>
                                        <form action="<?php echo e(route('student.article.destroy')); ?>" method="POST">
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts::student.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codearch/Backup/01-folder/andmi/resources/views/student/article.blade.php ENDPATH**/ ?>