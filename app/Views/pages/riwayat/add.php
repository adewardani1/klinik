<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Tambah Riwayat Medis</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- <div class="d-flex justify-content-start">
                <a href="export_kas.php" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm mt-1"><i class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
            </div> -->
            <div class="table-responsive service">
                <form method="POST" action="../process_riwayat/<?= $detail['id_rm']; ?>">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keluhan</label>
                        <input type="text" name="keluhan" class="form-control" id="keluhan">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Diagnosa</label>
                        <input type="text" name="diagnosa" class="form-control" id="diagnosa">
                    </div>
                    <div class="mb-3">
                        <label class="" for="inlineFormCustomSelect">Obat</label>
                        <select class="custom-select" name="id_obat" id="inlineFormCustomSelect">
                            <?php
                            foreach ($data_obat as $list) : ?>
                                <option value="<?= $list['id_obat'] ?>"><?= $list['nama_obat'] ?></option>
                            <?php
                            endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                        <textarea type="text" name="keterangan" class="form-control" id="keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="" for="inlineFormCustomSelect">Pemeriksa</label>
                        <select class="custom-select" name="pemeriksa" id="inlineFormCustomSelect">
                            <?php
                            foreach ($data_petugas as $list) : ?>
                                <option value="<?= $list['id'] ?>"><?= $list['nama'] ?></option>
                            <?php
                            endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Biaya</label>
                        <input type="number" name="number" class="form-control" id="number">
                    </div>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>