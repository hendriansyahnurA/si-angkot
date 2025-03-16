<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #D0611B">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ '/admin/dashboard' }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SI-ANGKOT<sup>'</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ '/Dashboard' }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management Data :
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Data Master</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data SI-ANGKOT :</h6>
                <a class="collapse-item" href="{{ '/orangtua' }}">Data Orang Tua</a>
                <a class="collapse-item" href="{{ '/anak' }}">Data Anak</a>
                <a class="collapse-item" href="{{ '/driver' }}">Data Driver</a>
                <a class="collapse-item" href="{{ '/admin/alternatif' }}">Data Angkot</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Rekap Data :
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ '/admin/klasifikasi' }}">
            <i class="fas fa-fw fa-solid fa-folder"></i>
            <span>Rekap Data</span></a>
    </li>

    <hr class="sidebar-divider">
</ul>
