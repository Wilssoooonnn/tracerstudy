<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('img/logo.png') }}" width="30px" height="30px" alt="">
            <a href="index.html">Tracer Study</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">TS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>
            </li>
            <li class="menu-header">Manajemen Data</li>
            <li class="{{ Request::is('admin/data-lulusan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-lulusan') }}"><i class="far fa-user"></i> <span>Data Lulusan </span></a>
            </li>
            <li class="{{ Request::is('admin/data-stakeholder ') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-stakeholder') }}"><i
                        class="fas fa-user"></i><span>Data Stakeholder</span></a>
            </li>
            <li class="{{ Request::is('admin/profesi ') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/profesi') }}"><i
                        class="fas fa-user-cog"></i><span>Pengelolaan Profesi</span></a>
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
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/rekap-hasil-lulusan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/rekap-hasil-lulusan') }}">Tracer Study Lulusan</a>
                    
                    </li>
                    <li class="{{ Request::is('admin/rekap-hasil-surveykepuasan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/rekap-hasil-surveykepuasan') }}">Survey Kepuasan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'admin/rekap-belum-mengisi-lulusan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file"></i>
                    <span>Rekap Belum Mengisi</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/rekap-belum-mengisi-lulusan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/rekap-belum-mengisi-lulusan') }}">Lulusan</a>
                    </li>
                    <li class="{{ Request::is('admin/rekap-belum-mengisi-pengguna') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/rekap-belum-mengisi-pengguna') }}">Pengguna Lulusan</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>