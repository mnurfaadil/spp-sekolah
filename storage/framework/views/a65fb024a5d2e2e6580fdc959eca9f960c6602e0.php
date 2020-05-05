<?php $__env->startSection('title'); ?>
SPP | Kategori Pembayaran
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3><a href="">Tambah Periode <?php echo e($category[0]->nama); ?></a></h3>
            <p class="all-pro-ad">Tambahkan periode pembayaran disini</p>
            <hr>

            <div class="sparkline16-graph">
                <div class="date-picker-inner">

                    <div class="basic-login-inner">
                        <form action="<?php echo e(route('periode.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($category[0]->id); ?>">
                            <input type="hidden" name="id_data">
                            <div class="form-group data-custon-pick" id="data_4">
                                <label>Pilih Periode (mm/dd/yyyy)</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" name="calendar" value="06/01/2020">
                                </div>
                            </div>
                            <div class="form-group data-custon-pick">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                    <input type="nominal" class="form-control" name="nominal" value="<?php echo e($category[0]->besaran); ?>">
                                </div>
                            </div>
                            <div class="login-btn-inner">
                                <div class="inline-remember-me">
                                    <button class="btn btn-sm btn-primary pull-right login-submit-cs"
                                        type="submit">Submit</button>
                                    <label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
    <div class="hpanel hblue contact-panel contact-panel-cs responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="container-sm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="main-sparkline13-hd">
                                                <h3>Periode Pembayaran <?php echo e($category[0]->nama); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar">
                                        <select class="form-control dt-tb">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true"
                                        data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                        data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                        data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th data-field="state" data-checkbox="true"></th>
                                                <th data-field="id">No</th>
                                                <th data-field="date" data-editable="false">Terakhir Update</th>
                                                <th data-field="bulan" data-editable="false">Bulan</th>
                                                <th data-field="tahun" data-editable="false">Tahun</th>
                                                <th data-field="nominal" data-editable="false">Nominal</th>
                                                <th data-field="action" data-editable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no=1;
                                                $bulan=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];                                            
                                            ?>
                                            <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo e($no++); ?></td>
                                                <td><?php echo e($periode->updated_at); ?></td>
                                                <td><?php echo e($bulan[$periode->bulan]); ?></td>
                                                <td><?php echo e($periode->tahun); ?></td>
                                                <td>
                                                    <div style="text-align:right">
                                                    <?php echo e($periode->nominal); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align:center">
                                                <button class="btn btn-danger editable"
                                                title="Hapus periode <?php echo e($category[0]->nama); ?>" style="color:white" 
                                                onclick="event.preventDefault();destroy('<?php echo e(route('periode.destroy',[$periode,$category[0]->id])); ?>');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                    </div>
                                                </td>
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
        </div>
    </div>
</div>
<!-- Static Table End -->
<!-- hapus -->
<form id="destroy-form" method="POST">
    <?php echo method_field('DELETE'); ?>
    <?php echo csrf_field(); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<!-- x-editor CSS  -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/editor/select2.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/editor/datetimepicker.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/editor/bootstrap-editable.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/editor/x-editor-style.css')); ?>">
<!-- normalize CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/data-table/bootstrap-table.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/data-table/bootstrap-editable.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- data table JS
		============================================ -->
<script src="<?php echo e(asset('assets/js/data-table/bootstrap-table.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/tableExport.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/data-table-active.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/bootstrap-table-editable.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/bootstrap-editable.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/bootstrap-table-resizable.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/colResizable-1.5.source.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/data-table/bootstrap-table-export.js')); ?>"></script>
<!--  editable JS
		============================================ -->
<script src="<?php echo e(asset('assets/js/editable/jquery.mockjax.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/editable/mock-active.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/editable/select2.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/editable/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/editable/bootstrap-datetimepicker.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/editable/bootstrap-editable.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/editable/xediable-active.js')); ?>"></script>

    <!-- datapicker JS
		============================================ -->
    <script src="<?php echo e(asset('assets/js/datapicker/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datapicker/datepicker-active.js')); ?>"></script>

<script>
    function destroy(action) {
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, data pembayaran pada periode ini akan terhapus!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function (value) {
            if (value) {
                document.getElementById('destroy-form').setAttribute('action', action);
                document.getElementById('destroy-form').submit();
            } else {
                swal("Data kamu aman!");
            }
        });
    }
</script>

<?php $__env->stopPush(); ?>


<?php $__env->startPush('breadcrumb-left'); ?>
<button onclick="javascript:history.back()" class="btn btn-primary">Kembali</button>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-right'); ?>
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/financing')); ?>">Pembiayaan</a></li>
            <li class="breadcrumb-item"><a href=""><?php echo e($category[0]->nama); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Periode</li>
        </ol>
    </nav>
</div>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/master/financingcategory/periode.blade.php ENDPATH**/ ?>