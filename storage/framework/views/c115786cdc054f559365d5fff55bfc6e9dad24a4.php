
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rincian</title>
    <style>
.page_break { page-break-before: always; },
</style>
  </head>
  <body>
    <header class="clearfix">
      <div style="text-align: center">
      <h2>Rincian <?php echo e($rincian); ?></h2>
      </div>
      <div id="project" style="font-size:16px">
      </div>
    </header>
    <br>
    <hr>
    <main style="align-item:center;">
      <table style="font-size:14px;">
        <thead>
          <tr>
            <th width="30">NO</th>
            <th width="320">DESKRIPSI</th>
            <th width="170">JUMLAH</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $total =0;
        ?>
        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $total+=intval($data->kredit);
        ?>
        <tr>
          <td colspan="3"><hr></td>
          </tr>
          <tr>
            <td >
            <div style="text-align:center">
            <?php echo e($no++); ?>

            </div>
            </td>
            <td >
              <div style="word-wrap: break-word;">
              <?php echo e($data->description); ?>

              </div>
            <td class="unit">
              <div style="text-align:right">
              <?php echo e(number_format($data->kredit,0,',','.')); ?>

              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <tr>
          <td colspan="3"><hr></td>
          </tr>
          <tr>
            <td colspan="2">Total Tunggakan</td>
            <td class="total">
              <div style="text-align:right; font-size:16; font-weight:bold">
              Rp. <?php echo e(number_format($total,0,',','.')); ?>

              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <br>
    </main>
    <footer>
    <br>
    <br>
    <div style="widht:100%; text-align:right">
    <p>
    Sumedang, <?php echo e($tanggal); ?><br>
    Bendahara Sekolah
    </p>
    <br>
    <br>
    <p><span style="text-decoration: underline; font-weight:bold">
    <?php echo e($user); ?></span> <br>
    </p>
    </div>
    </footer>
  </body>
</html><?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/export/pengeluaran.blade.php ENDPATH**/ ?>