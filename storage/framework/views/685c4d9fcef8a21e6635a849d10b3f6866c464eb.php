<?php $__env->startSection('title'); ?>
SPP | Cicilan Pembayaran
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3>Form Pembayaran</h3>
            <p class="all-pro-ad">Masukan pembayaran disini</p>
            <hr>

            <div class="sparkline16-graph">
                <div class="date-picker-inner">

                    <div class="basic-login-inner">
                        <form action="<?php echo e(route('payment.details.cicilan.store')); ?>" method="post" id="form-bayar">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="financing_category_id" value="<?php echo e($payments->financing_category_id); ?>">
                            <input type="hidden" name="student_id" value="<?php echo e($payments->student_id); ?>">
                            <input type="hidden" name="payment_id" value="<?php echo e($payments->id); ?>">
                            <div class="form-group data-custon-pick" id="data_4">
                                <label>Tanggal Pembayaran</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" name="calendar" value="<?php echo e($date); ?>" readonly title="Tanggal pembayaran otomatis hari ini">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" min="0" class="form-control" name="nominal"
                                        placeholder="Masukan nominal">
                                </div>
                            </div>
                            <div class="login-btn-inner">
                                <div class="inline-remember-me">
                                    <?php if($payment_details->last() !== null && $payment_details->last()->status=="Lunas"): ?>
                                    <div class="alert alert-info" role="alert">
                                        <strong>Info!</strong> Pembayaran telah lunas.
                                    </div>
                                    <?php else: ?>
                                    <button class="btn btn-sm btn-primary pull-right login-submit-cs"
                                        id="btn-form-bayar">Submit</button>
                                    <label>
                                    <?php endif; ?>
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
                                            <span class="">NIS :
                                                <strong><?php echo e($datas[0]->nis); ?></strong></span><br>
                                            <span class="">Nama :
                                                <strong><?php echo e($datas[0]->nama); ?></strong></span><br>
                                            <span class="">Kelas &nbsp;: <strong><?php echo e($datas[0]->kelas); ?> -
                                                    <?php echo e($datas[0]->major->nama); ?></strong></span>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="float:right;">
                                                <a href="<?php echo e(route('financing.periode',$financing->id)); ?>"
                                                    style="color:white" class=" btn btn-success" title="Cetak kwitansi">
                                                    <i class="fa fa-print"></i>&nbsp; Cetak</a>

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
                                                <th data-field="id">
                                                    <div style="text-align: center">
                                                    No
                                                    </div>
                                                </th>
                                                <th data-field="tanggal">
                                                    <div style="text-align: center">
                                                    Tanggal Pembayaran
                                                    </div>
                                                </th>
                                                <th data-field="nominal">
                                                    <div style="text-align: center">
                                                    Nominal
                                                    </div>
                                                </th>
                                                <th data-field="total">
                                                    <div style="text-align: center">
                                                    Penerima
                                                    </div>
                                                </th>
                                                <th data-field="cetak">
                                                    <div style="text-align: center">
                                                    Cetak
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total=0;
                                            ?>
                                            <?php $__currentLoopData = $payment_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $total+=intval($data->nominal);
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div style="text-align: center">
                                                    <?php echo e($no++); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: center">
                                                    <?php echo e($data->created_at); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: right">
                                                    <?php echo e(number_format($data->nominal,0,',','.')); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: center">
                                                    <?php echo e($data->user->name); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: center;">
                                                    <a href="#" style="color:white;margin-top:0"class=" btn btn-success" target="_blank" title="Cetak bukti pembayaran">
                                                <i class="fa fa-print"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $sisa=intval($financing->besaran)-$total;
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="container-sm" style="margin-top:10px">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div style="float:right; margin-right:20%">
                                                    <div class="row">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:18px;">
                                                                                <strong><?php echo e(number_format($financing->besaran,0,',','.')); ?></strong></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Telah dibayar</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td style="border-bottom: 1px solid #000;">
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:18px;">
                                                                                <strong><?php echo e(number_format($total,0,',','.')); ?></strong></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tunggakan</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <?php if($sisa!=0): ?>
                                                                            <span class="" style="font-size:24px;color:red">
                                                                            <?php else: ?>
                                                                            <span class="" style="font-size:24px;color:green">
                                                                            <?php endif; ?>
                                                                                <strong><?php echo e(number_format($sisa,0,',','.')); ?></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Static Table End -->
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
    $(document).ready(function () {
        $('#btn-form-bayar').on('click', function () {
            event.preventDefault();
            swal({
                title: 'Apakah anda yakin?',
                text: 'Data yang sudah dimasukan tidak dapat diubah!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function (value) {
                if (value) {
                    let form = $('#form-bayar').serializeArray();
                    if (form[5].value>0) {
                        document.getElementById('form-bayar').submit();
                    } else {
                        swal({
                            text: 'Nominal Kosong! Transaksi dibatalkan',
                            icon: 'warning',
                            buttons: ["Yes!"],
                        });
                    }
                } else {
                    swal("Transaksi di batalkan!");
                }
            });
        });
    });

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-left'); ?>
<div class="col-md-1" style="item-align:center">
<a class="btn btn-primary" href="<?php echo e(route('payment.show',$financing->id)); ?>" title="Kembali"><i class="fa fa-arrow-left" ></i></a>
</div>
<div class="col-md-11">
    <div style="margin-left:15px;">
    <h4>Cicilan <?php echo e($financing->nama); ?></h4>
    <span class="all-pro-ad">Kategori Pembayaran : <strong><?php echo e($financing->jenis); ?></strong></span>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-right'); ?>
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/payment')); ?>">Pembayaran</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('payment.show',$financing->id)); ?>"><?php echo e($financing->nama); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
</div>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/pembayaran/cicilan.blade.php ENDPATH**/ ?>