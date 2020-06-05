<!-- Start Left menu area -->
<div class="left-sidebar-pro">
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="{{ url('/') }}"><img class="main-logo" src="{{ asset('assets/img/logo/logo.png') }}" alt="" /></a>
            <strong><a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/logosn.png') }}" alt="" /></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                @if(Auth::user()->role=="Sekolah")
                    <li>
                        @if(Request::is('home'))
                        <a title="Dashboard" href="{{ url('/') }}" style="background-color:#3498db;color:white">                        
                        @else
                        <a title="Dashboard" href="{{ url('/') }}" style="color:#3498db">                        
                        @endif
                            <span class="fa fa-home sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Dashboard</span>
                        </a>
                    </li>
                    
                    <li>
                        @if(Request::is('payment'))
                        <a title="Data Pembayaran" class="" href="{{ route('payment.index') }}" aria-expanded="false" style="background-color:#8e44ad;color:white">
                        @elseif(Request::is('payment/*'))
                        <a title="Data Pembayaran" class="" href="{{ route('payment.index') }}" aria-expanded="false" style="background-color:#8e44ad;color:white">
                        @else
                        <a title="Data Pembayaran" class="" href="{{ route('payment.index') }}" aria-expanded="false" style="color:#8e44ad">
                        @endif
                            <span class="fa fa-credit-card sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Pembayaran</span>
                        </a>
                    </li>
                    <li>
                        @if(Request::is('income'))
                        <a title="Data Pemasukan" class="" href="{{ route('income.index') }}" aria-expanded="false" style="background-color:#27ae60;color:white">
                        @else
                        <a title="Data Pemasukan" class="" href="{{ route('income.index') }}" aria-expanded="false" style="color:#27ae60;">
                        @endif
                            <span class="educate-icon educate-department sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Pemasukan</span>
                        </a>
                    </li>
                    <li>
                        @if(Request::is('expense'))
                        <a title="Data Pengeluaran" class="" href="{{ route('expense.index') }}" aria-expanded="false" style="background-color:orange;color:white">
                        @else
                        <a title="Data Pengeluaran" class="" href="{{ route('expense.index') }}" aria-expanded="false" style="color:orange;">
                        @endif
                            <span class="fa fa-tags sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Pengeluaran</span>
                        </a>
                    </li>
                    <li>
                        @if(Request::is('simpanan'))
                        <a title="Simpanan" class="" href="{{ url('simpanan') }}" aria-expanded="false" style="background-color:#891414;color:white">
                        @else
                        <a title="Simpanan" class="" href="{{ url('simpanan') }}" aria-expanded="false" style="color:#891414;">
                        @endif
                            <span class="fa fa-archive sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Simpanan</span>
                        </a>
                    </li>
                    <li>
                        @if(Request::is('rekap') || Request::is('export') || Request::is('rekap_bukbes')|| Request::is('rekap_Pemasukan')|| Request::is('rekap_Pengeluaran'))
                        <a title="Rekapitulasi" class="" href="{{ route('rekap.index') }}" aria-expanded="false" style="background-color:#eb3b5a;color:white">
                        @else
                        <a title="Rekapitulasi" class="" href="{{ route('rekap.index') }}" aria-expanded="false" style="color:#eb3b5a;">
                        @endif
                            <span class="fa fa-files-o sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Rekap</span>
                        </a>
                    </li>
                    <li>
                        @if(Request::is('user'))
                        <a title="User Managemet" class="" href="{{ url('user') }}" aria-expanded="false" style="background-color:#3498db;color:white">
                        @else
                        <a title="User Managemet" class="" href="{{ url('user') }}" aria-expanded="false" style="color:#3498db;">
                        @endif
                            <span class="fa fa-id-badge sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">User Management</span>
                        </a>
                    </li>
                    <li>
                        @if(Request::is('students'))
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="background-color:black;color:white">
                        @elseif(Request::is('majors'))
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="background-color:black;color:white">
                        @elseif(Request::is('angkatan'))
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="background-color:black;color:white">
                        @elseif(Request::is('financing'))
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="background-color:black;color:white">
                        @elseif(Request::is('financing/*'))
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="background-color:black;color:white">
                        @elseif(Request::is('angkatan'))
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="background-color:black;color:white">
                        @else
                        <a class="has-arrow" title="Data Master" href="#" aria-expanded="false" style="color:black;">
                        @endif
                            <span class="fa fa-diamond sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non "> Master</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a title="Data Master Siswa" href="{{ route('students.index') }}"><span class="mini-sub-pro">Siswa</span></a></li>
                            <li><a title="Data Master Jurusan" href="{{ route('majors.index') }}"><span class="mini-sub-pro">Jurusan</span></a></li>
                            <li><a title="Data Master Angkatan" href="{{ route('angkatan.index') }}"><span class="mini-sub-pro">Angkatan</span></a></li>
                            <li><a title="Data Master Kategori Pembiayaan" href="{{ url('financing') }}"><span class="mini-sub-pro">Kategori Pembiayaan</span></a></li>
                        </ul>
                    </li>
                    
                @else
                    <li>
                        <a title="Rekapitulasi" class="" href="{{ route('rekap.index') }}" aria-expanded="false" style="background-color:#eb3b5a;color:white">
                            <span class="fa fa-files-o sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non ">Rekap</span>
                        </a>
                    </li>
                @endif
                </ul>
            </nav>
        </div>
    </nav>
</div>
<!-- End Left menu area -->
