<?php $__env->startSection('title'); ?>
SPP | Pembayaran
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <div class="container-sm">
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div style="float:right; margin-right:15px">
                                            <div class="row">
                                                <a href="<?php echo e(route('pdf.print.rekap.bulanan',[$financing->nama,$financing->id])); ?>" style="float:right"class=" btn btn-success" target="_blank">
                                                    <i class="fa fa-print"></i>&nbsp;Cetak
                                                </a>
                                            </div>
                                        </div>
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
                                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id">No</th>
                                        <th data-field="name">Nama</th>
                                        <th data-field="kelas">Kelas</th>
                                        <th data-field="total">Akumulasi Biaya</th>
                                        <th data-field="terbayar">Sudah dibayar</th>
                                        <th data-field="tunggakan">Sisa Pembayaran</th>
                                        <th data-field="banyak">Tunggakan</th>
                                        <th data-field="status">Status</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $besaran = intval($siswa->akumulasi);
                                            $terbayar = intval(($siswa->terbayar!=0)?$siswa->terbayar:0);
                                            $sisa = $besaran - $terbayar;
                                        ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo e($no++); ?></td>
                                        <td><?php echo e($siswa->nama); ?></td>
                                        <td><?php echo e($siswa->kelas); ?> - <?php echo e($siswa->jurusan); ?></td>
                                        <td>
                                            <div style="text-align:right">
                                                <?php echo e(number_format($siswa->akumulasi,0,',','.')); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:right">
                                                <?php echo e(number_format($siswa->terbayar,0,',','.')); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:right">
                                                <?php echo e(number_format($sisa,0,',','.')); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center">
                                                <?php if($siswa->bulan_tidak_bayar!=0): ?>
                                                <span class="badge" style="background-color:red"><?php echo e($siswa->bulan_tidak_bayar); ?> Bulan</span>
                                                <?php else: ?>
                                                <?php echo e($siswa->bulan_tidak_bayar); ?> Bulan
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center">
                                            <?php if($siswa->cekWaiting==0 && $siswa->bulan_tidak_bayar==0 && $sisa==0 && $siswa->akumulasi!=0): ?>
                                                <span class="badge" style="background-color:green">Lunas</span>
                                            <?php else: ?>
                                                <?php if($siswa->cekWaiting!=0 || $siswa->akumulasi==0): ?>
                                                    <span class="badge" style="background-color:yellow;color:black">Waiting</span>
                                                <?php elseif($siswa->cekWaiting!=0 && $siswa->cekWaiting!=$siswa->bulan_tidak_bayar||$sisa!=0): ?>
                                                    <span class="badge" style="background-color:red">Nunggak</span>
                                                <?php endif; ?>
                                                <?php if($siswa->bulan_tidak_bayar!=0 ): ?>
                                                    <span class="badge" style="background-color:red">Nunggak</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($financing->jenis=="Sekali Bayar"): ?>
                                                <?php if($financing->jenis=="Sekali Bayar" && $siswa->jenis_pembayaran=="Waiting"): ?>
                                                    <button class="btn btn-primary" onclick="addConfirm('<?php echo e($siswa->id); ?>','<?php echo e($siswa->nama); ?>')" title="Pilih Metode Pembayaran">
                                                        <i class="fa fa-info-circle"> Metode</i>
                                                    </button>
                                                <?php elseif($periode==0 && $financing->jenis=="Bayar per Bulan"): ?>
                                                    <a href="" class="btn btn-danger"
                                                    title="Harap isi periode" disabled><i class="fa fa-times"> Process</i></a>
                                                <?php elseif(true): ?>
                                                    <a href="<?php echo e(route('payment.monthly.show.detail',[$siswa->payment_id,$siswa->id, $financing->id])); ?>" class="btn btn-success"
                                                    title="Detail Pembayaran" style="color:white; background-color:green"><i class="fa fa-eye"> Detail</i></a>
                                                <?php elseif($siswa->jenis_pembayaran=="Cicilan" && $sisa!=0): ?>
                                                    <a href="<?php echo e(route('payment.show',1)); ?>" class="btn btn-warning"
                                                    title="Cetak Bukti Pembayaran" style="color:black; background-color:orange"><i class="fa fa-eye"> Rincian</i></a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('payment.show',1)); ?>" class="btn btn-success"
                                                    title="Cetak Bukti Pembayaran" style="color:white; background-color:green"><i class="fa fa-print"> Invoice</i></a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('payment.monthly.show.detail',[$siswa->payment_id,$siswa->id,$financing->id])); ?>" class="btn btn-success"
                                                title="Detail Pembayaran" style="color:white; background-color:green"><i class="fa fa-eye"> Detail</i></a>
                                            <?php endif; ?>
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
<!-- Static Table End -->

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalAddLabel">Pilih Metode Pembayaran Pembiayaan</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('payment.storeMethod')); ?>" role="form" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="financing_category_id" value="<?php echo e($financing->id); ?>">
                <input type="hidden" name="financing_category" value="<?php echo e($financing->nama); ?>">
                <input type="hidden" name="nominal" value="<?php echo e($financing->besaran); ?>">
                <input type="hidden" name="student_id" id="student_id_add" value="">
                <input type="hidden" name="student_name" id="student_name_add" value="">
                <input type="hidden" name="penerima" value="<?php echo e(Session::get('nama')); ?>">
                <div class="row mb-3">
                    <div class="col-md-3 col-sm-3">
                        Pembiayaan
                    </div>
                    :
                    <strong><span><?php echo e($financing->nama); ?></span></strong>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        Nominal Pembayaran
                    </div>
                    : <strong>Rp. <span ><?php echo e(number_format($financing->besaran,0,',','.')); ?></span></strong>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label col-md-4">Metode Pembayaran<kode>*</kode></label>
                    <div class="chosen-select-single mg-b-20">
                        <select class="chosen-select" name="metode_pembayaran" id="metode_pembayaran_add">
                            <option value="Tunai">Tunai</option>
                            <option value="Cicilan">Cicilan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog"
    aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalAddLabel">Ubah Kategori Pembiayaan</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" role="form" method="post">
                    <?php echo method_field('PUT'); ?>
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <label class="control-label col-md-2">Kategori</label>
                        <input name='nama' placeholder="Masukan ketegori pembiayaan" type='text' class='form-control'
                            id="nama" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Besaran Nominal (Rp.)</label>
                        <input name='besaran' placeholder="Masukan nominal pembayaran" type='number' min="0"
                            class='form-control' id="besaran" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal history -->
<div class="modal fade bd-example-modal-lg" id="modalHistory" tabindex="-1" role="dialog"
    aria-labelledby="modalHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="title_modal_history">History Perubahan Data</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3 col-sm-3">
                        Kategori Pembiayaan
                    </div>
                    :
                    <strong><span id="kategori_history_modal"></span></strong>
                </div>
                
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        Besaran Pembiayaan
                    </div>
                    : <strong>Rp. <span id="besaran_history_modal"></span></strong>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="static-table-list">
                            <table class="table" id="table_history">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu Update</th>
                                        <th>Besaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#table_history tbody tr').remove();">Close</button>
            </div>
        </div>
    </div>
</div>


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
<!-- forms CSS
============================================ -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/form/all-type-forms.css')); ?>">
<!-- chosen CSS
============================================ -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/chosen/bootstrap-chosen.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
    function closeModal()
    {
        $('.button_add').bind('click');
    }
    function addConfirm(id_siswa, nama) {
        $('#student_id_add').attr('value',id_siswa);
        $('#student_name_add').attr('value',nama);
        $('#modalAdd').modal();
    }

    function editConfirm() {
        $('#modalUpdate').modal();
    }

    function destroy(action) {
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
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

<!-- chosen JS
    ============================================ -->
<script src="<?php echo e(asset('assets/js/chosen/chosen.jquery.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/chosen/chosen-active.js')); ?>"></script>

<script>
function history(nama, besaran, link = "/"){

$('#kategori_history_modal').html(nama);
$('#besaran_history_modal').html(besaran);
$.ajax({
    type: "GET",
    dataType: "json",
    url: link,
    success: function (response) {
        $.each(response, function(i, item) {
            var $tr = $('<tr>').append(
                $('<td>').text(item.rowNumber),
                $('<td>').text(item.created_at),
                $('<td>').text('Rp. '+item.besaran)
            ).appendTo('#table_history');
        });
    },
    error: function (error) {
        alert(error);
    }
});
$('#modalHistory').modal();
}</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-left'); ?>
<div class="col-md-1" style="item-align:center">
<a href="<?php echo e(url('/payment')); ?>" class="btn btn-primary" href="#" title="Kembali"><i class="fa fa-arrow-left" ></i></a>
</div>
<div class="col-md-11">
    <div style="margin-left:15px;">
    <h4>Menu Pembayaran <?php echo e($financing->nama); ?></h4>
    <span class="all-pro-ad">Kategori Pembayaran : <strong><?php echo e($financing->jenis); ?></strong></span>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-right'); ?>
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo e(url('/payment')); ?>">Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e($financing->nama); ?></li>
        </ol>
    </nav>
</div>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/pembayaran/show.blade.php ENDPATH**/ ?>