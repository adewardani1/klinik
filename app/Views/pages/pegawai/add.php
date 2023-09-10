<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Tambah Pegawai</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- <div class="d-flex justify-content-start">
                <a href="export_kas.php" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm mt-1"><i class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
            </div> -->
            <div class="table-responsive service">
                <form method="POST" action="<?= base_url(); ?>Obat/proses_tambah">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Pegawai</label>
                        <input type="text" name="nama_obat" class="form-control" id="nama_obat">
                    </div>
                    <div class="mb-3">
                        <label for="bagian" class="form-label">Bagian</label>
                        <select class="form-control" id="jenis_pasien">
                            <option value="admin">Administrasi</option>
                            <option value="pemeriksa">Pemeriksa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn btn-info">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>