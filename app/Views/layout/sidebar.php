<ul class="navbar-nav bg-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>Dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Klinik Guntoro</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>Dashboard">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>Pelayanan">
            <i class="fa-solid fa-notes-medical"></i>
            <span>Pelayanan</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>RekamMedis">
            <i class="fa-solid fa-book"></i>
            <span>Rekam Medis</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>Obat">
            <i class="fa-solid fa-tablets"></i>
            <span>Data Obat</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>Pegawai">
            <i class="fa-solid fa-user"></i>
            <span>Data Pegawai</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>Pengeluaran">
            <i class="fa-solid fa-share-from-square"></i>
            <span>Data Pengeluaran</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages-2" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Laporan</span>
        </a>
        <div id="collapsePages-2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">COMPONENTS:</h6>
                <a class="collapse-item" href="<?= base_url(); ?>Laporan/kunjungan">Data Kunjungan Pasien</a>
                <a class="collapse-item" href="<?= base_url(); ?>Laporan/keuangan">Keuangan</a>
                <a class="collapse-item" href="<?= base_url(); ?>Laporan/diagnosa">Diagnosis Teratas</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>