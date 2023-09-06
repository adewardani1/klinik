<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Tambah Riwayat Pasien</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- <div class="d-flex justify-content-start">
                <a href="export_kas.php" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm mt-1"><i class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
            </div> -->
            <div class="table-responsive service">
                <form method="POST" action="<?= base_url(); ?>Pelayanan/process_add">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" name="nama_pasien" class="form-control" id="nama_pasien">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NO BPJS</label>
                        <input type="text" name="no_bpjs" class="form-control" id="no_bpjs">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keluhan</label>
                        <textarea type="text" name="keluhan" class="form-control" id="keluhan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>