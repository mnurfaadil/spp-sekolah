<?php if(Session::has('error')): ?>
    <input type="hidden" id="status" value="<?php echo e(Session::get('error')); ?>">
    <script type='text/javascript'>
      window.onload = function(event) {
        let sts = document.getElementById('status').value;
        swal('Error!', sts, 'error')
      };
  </script> 
<?php endif; ?>

<?php if(Session::has('success')): ?>
  <input type="hidden" id="status" value="<?php echo e(Session::get('success')); ?>">
    <script type='text/javascript'>
      window.onload = function(event) {
        let sts = document.getElementById('status').value;
        swal('Succes!', sts, 'success')
      };
  </script> 
<?php endif; ?>
<?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/layouts/message.blade.php ENDPATH**/ ?>