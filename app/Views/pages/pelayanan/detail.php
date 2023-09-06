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
                <form method="POST" action="<?= base_url(); ?>Pelayanan/save/<?= $detail['id_pelayanan']; ?>">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keluhan</label>
                        <textarea type="textarea" name="keluhan" class="form-control" id="keluhan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Diagnosa</label>
                        <input type="text" name="diagnosa" class="form-control" id="diagnosa">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Obat</label>
                        <input type="text" name="Obat" class="form-control" id="Obat">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Biaya</label>
                        <input type="number" name="biaya" class="form-control" id="biaya">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                        <textarea type="textarea" name="keterangan" class="form-control" id="keterangan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>