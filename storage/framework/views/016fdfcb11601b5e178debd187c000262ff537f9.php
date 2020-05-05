<?php $__env->startSection('title-html'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<table class="table1">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Akumulasi Biaya</th>
        <th>Terbayar</th>
        <th>Sisa Pembayaran</th>
        <th>Tunggakan</th>
    </tr>
<?php
$total = [0,0,0,0];
?>
<?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $besaran = intval($data->akumulasi);
    $terbayar = intval(($data->terbayar!=0)?$data->terbayar:0);
    $sisa = $besaran - $terbayar;
    $total[0] += $besaran;
    $total[1] += $terbayar;
    $total[2] += $sisa;
    $total[3] += intval($data->bulan_tidak_bayar);
?>
    <tr>
        <td><?php echo e($no++); ?></td>
        <td style="text-align:left;"><?php echo e($data->nama); ?></td>
        <td><?php echo e($data->kelas); ?>&nbsp;-&nbsp;<?php echo e($data->jurusan); ?></td>
        <td style="text-align:right"><?php echo e(number_format($data->akumulasi,0,',','.')); ?></td>
        <td style="text-align:right"><?php echo e(number_format($data->terbayar,0,',','.')); ?></td>
        <td style="text-align:right"><?php echo e(number_format($sisa,0,',','.')); ?></td>
        <td><?php echo e($data->bulan_tidak_bayar); ?> Bulan</td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <tr class="footer-section">
        <th colspan="3" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;"><?php echo e(number_format($total[0],0,',','.')); ?></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;"><?php echo e(number_format($total[1],0,',','.')); ?></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;"><?php echo e(number_format($total[2],0,',','.')); ?></th>
        <th class="footer-right"><?php echo e($total[3]); ?> Bulan</th>
    </tr>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('export.layout.landscape', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/export/coba.blade.php ENDPATH**/ ?>