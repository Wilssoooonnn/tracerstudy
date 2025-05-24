<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
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
            <li class="menu-header">Lulusan</li>
            <li class="{{ Request::is('admin/data-lulusan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-lulusan') }}"><i class="far fa-user"></i> <span>Data
                        Lulusan</span></a>
            </li>
            <li class="{{ Request::is('admin/generate-link-lulusan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/generate-link-lulusan') }}"><i
                        class="fas fa-link"></i><span>Generate
                        Link</span></a>
            </li>
            <li class="menu-header">Stakeholder</li>
            <li class="{{ Request::is('admin/data-stakeholder') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data-stakeholder') }}"><i class="far fa-user"></i> <span>Data 
                    Stakeholder</span></a>
            </li>
            <li class="{{ Request::is('admin/generate-link-penggunalulusan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/generate-link-penggunalulusan') }}"><i 
                    class="fas fa-link"></i><span>Generate Link</span></a>
            </li>
            <li class="menu-header">Report</li>
            <li class="nav-item dropdown {{ $type_menu === 'admin/rekap-hasil-lulusan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file"></i>
                    <span>Rekap Hasil</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/rekap-hasil-lulusan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/rekap-hasil-lulusan') }}">Tracer Study Lulusan</a>
                    
                    </li>
                    <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('transparent-sidebar') }}">Survey Kepuasan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === '#' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file"></i>
                    <span>Rekap Belum Mengisi</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('layout-default-layout') }}">Tracer Study Lulusan</a>
                    </li>
                    <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('transparent-sidebar') }}">Survey Kepuasan</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>