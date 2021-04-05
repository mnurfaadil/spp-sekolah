<div class="mobile-menu">
    <nav id="dropdown">
        <ul class="mobile-menu-nav">
            <li>
                <a title="Dashboard" class="icon-wrap" href="{{ url('/') }}" aria-expanded="false">
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
                    <li><a title="Data Master Siswa" href="{{ route('students.index') }}"><span class="mini-sub-pro">Siswa</span></a></li>
                    <li><a title="Data Master Jurusan" href="{{ route('majors.index') }}"><span class="mini-sub-pro">Jurusan</span></a></li>
                    <li><a title="Data Master Angkatan" href="{{ route('angkatan.index') }}"><span class="mini-sub-pro">Angkatan</span></a></li>
                    <li><a title="Data Master Kategori Pembiayaan" href="{{ url('financing') }}"><span class="mini-sub-pro">Kategori
                    <li><a title="Data Master Kategori Pembiayaan" href="{{ url('registrasi') }}"><span class="mini-sub-pro">Registrasi Pembayaran
                                Pembiayaan</span></a></li>
                </ul>
            </li>
            <li>
                <a title="Data Pembayaran" class="" href="{{ route('payment.index') }}" aria-expanded="false">
                    <span class="fa fa-credit-card sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Pembayaran</span>
                </a>
            </li>
            <li>
                <a title="Data Pembayaran" class="" href="{{ route('history.index') }}" aria-expanded="false">
                    <span class="educate-icon educate-library icon-wrap" aria-hidden="true"></span>
                    <span class="mini-click-non ">Histori</span>
                </a>
            </li>
            <li>
                <a title="Data Pemasukan" class="" href="{{ route('income.index') }}" aria-expanded="false">
                    <span class="educate-icon educate-department sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Pemasukan</span>
                </a>
            </li>
            <li>
                <a title="Data Pengeluaran" class="" href="{{ route('expense.index') }}" aria-expanded="false">
                    <span class="fa fa-tags sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Pengeluaran</span>
                </a>
            </li>
            <li>
                <a title="Simpanan" class="" href="{{ url('simpanan') }}" aria-expanded="false">
                    <span class="fa fa-id-badge sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Simpanan</span>
                </a>
            </li>
            <li>
                <a title="Rekapitulasi" class="" href="{{ route('rekap.index') }}" aria-expanded="false">
                    <span class="fa fa-files-o sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">Rekap</span>
                </a>
            </li>
            <li>
                <a title="User Managemet" class="" href="{{ url('user') }}" aria-expanded="false">
                    <span class="fa fa-id-badge sub-icon-mg" aria-hidden="true"></span>
                    <span class="mini-click-non ">User Management</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
