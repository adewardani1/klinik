<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Edit Obat</h6>
        </div>
        <!-- Card Body -->


        <!-- Card Body -->
        <div class="card-body">
            <!-- <div class="d-flex justify-content-start">
                <a href="export_kas.php" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm mt-1"><i class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
            </div> -->
            <div class="table-responsive service">
                <form method="POST" action="<?= base_url(); ?>Obat/proses_edit/<?= $detail['id_obat']; ?>">
                    <div class="mb-3">
                        <label for="nama_obat" class="form-label">Nama Obat</label>
                        <input type="text" name="nama_obat" class="form-control" value="<?= $detail['nama_obat']; ?>" id="nama_obat" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_obat" class="form-label">Jenis Obat</label>
                        <input type="text" name="jenis_obat" value="<?= $detail['jenis_obat']; ?>" class="form-control" id="jenis_obat">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Obat</label>
                        <input type="text" name="stok" value="<?= $detail['stok']; ?>" class="form-control" id="stok">
                    </div>
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <input type="button" class="btn btn-danger" value="Kembali">
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>