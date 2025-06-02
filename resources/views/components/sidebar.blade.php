<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('img/logo.png') }}" width="30px" height="30px" alt="">
            <a href="{{ route('admin.dashboard') }}">Tracer Study</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">TS</a>
        </div>
        <ul class="sidebar-menu">
            <!-- Dashboard Menu -->
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>
<<<<<<< HEAD

            <!-- Alumni Group -->
            <li class="menu-header">Alumni</li>
            <li class="nav-item dropdown {{ Request::is('admin/alumni/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-graduate"></i>
                    <span>Data Alumni</span></a>
=======
            </li>
            <li class="menu-header">Manajemen Data</li>
            <li class="{{ Request::is('admin/data-lulusan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-lulusan') }}"><i class="far fa-user"></i> <span>Data Lulusan </span></a>
            </li>
            <li class="{{ Request::is('admin/data-stakeholder ') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-stakeholder') }}"><i
                        class="fas fa-user"></i><span>Data Stakeholder</span></a>
            </li>
            <li class="menu-header">Survei</li>
            <li class="{{ Request::is('admin/pertanyaan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/pertanyaan') }}"><i class="fas fa-lightbulb"></i> <span>Pertanyaan</span></a>
            </li>
            <li class="{{ Request::is('admin/response-data') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/response-data') }}">
                    <i class="fas fa-chart-bar"></i><span>Response Data</span></a>
            </li>
            <li class="menu-header">Report</li>
            <li class="nav-item dropdown {{ $type_menu === 'admin/rekap-hasil-lulusan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file"></i>
                    <span>Rekap Hasil</span></a>
>>>>>>> 98c88e7d108fe195c687f331d04735baa5d98a64
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/alumni/data') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.alumni.data') }}">Data Alumni</a>
                    </li>
                    <li class="{{ Request::is('admin/alumni/generate-link') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.alumni.generate-link') }}">Generate Link Alumni</a>
                    </li>
                </ul>
            </li>

            <!-- Stakeholder Menu -->
            <li class="menu-header">Stakeholder</li>
            <li class="{{ Request::is('#') ? 'active' : '' }}">
                <a class="nav-link" href="#"><i class="far fa-user"></i> <span>Data
                        Stakeholder</span></a>
            </li>
            <li class="{{ Request::is('#') ? 'active' : '' }}">
                <a class="nav-link" href="#"><i class="fas fa-link"></i><span>Generate Link</span></a>
            </li>

            <!-- Report Menu -->
            <li class="menu-header">Report</li>
            <li class="nav-item dropdown {{ Request::is('#') || Request::is('#') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file"></i>
                    <span>Rekap Hasil</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('#') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Tracer Study Lulusan</a>
                    </li>
                    <li class="{{ Request::is('#') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Survey Kepuasan</a>
                    </li>
                </ul>
            </li>

            <!-- Rekap Belum Mengisi Menu -->
            <li class="nav-item dropdown {{ Request::is('#') || Request::is('#') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file"></i>
                    <span>Rekap Belum Mengisi</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('#') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Lulusan</a>
                    </li>
                    <li class="{{ Request::is('#') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Pengguna
                            Lulusan</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>