<div class="mobile-menu">
    <nav id="dropdown">
        <ul class="mobile-menu-nav">
            <li>
                <a title="Dashboard" class="icon-wrap" href="<?php echo e(url('/')); ?>" aria-expanded="false">
                    <span class="fa fa-home sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" title="Data Master" href="#" aria-expanded="false">
                    <span class="fa fa-diamond sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Master</span>
                </a>
                <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="Data Master Siswa" href="<?php echo e(route('students.index')); ?>"><span class="mini-sub-pro">Siswa</span></a></li>
                    <li><a title="Data Master Jurusan" href="<?php echo e(route('majors.index')); ?>"><span class="mini-sub-pro">Jurusan</span></a>
                    </li>
                    <li><a title="Data Master Kategori Pembiayaan" href="<?php echo e(url('financing')); ?>"><span class="mini-sub-pro">Kategori
                                Pembiayaan</span></a></li>
                </ul>
            </li>
            <li>
                <a title="Data Pembayaran" class="" href="<?php echo e(route('payment.index')); ?>" aria-expanded="false">
                    <span class="fa fa-credit-card sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Pembayaran</span>
                </a>
            </li>
            <li>
                <a title="Data Pemasukan" class="" href="<?php echo e(route('income.index')); ?>" aria-expanded="false">
                    <span class="educate-icon educate-department sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Pemasukan</span>
                </a>
            </li>
            <li>
                <a title="Data Pengeluaran" class="" href="<?php echo e(route('expense.index')); ?>" aria-expanded="false">
                    <span class="fa fa-tags sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Pengeluaran</span>
                </a>
            </li>
            <li>
                <a title="Rekapitulasi" class="" href="<?php echo e(route('rekap.index')); ?>" aria-expanded="false">
                    <span class="fa fa-files-o sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Rekap</span>
                </a>
            </li>
            <li>
                <a title="User Managemet" class="" href="<?php echo e(url('user')); ?>" aria-expanded="false">
                    <span class="fa fa-id-badge sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">User Management</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/layouts/navbar-mobile.blade.php ENDPATH**/ ?>