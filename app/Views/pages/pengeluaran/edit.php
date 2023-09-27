<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Catat Pengeluaran</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= base_url(); ?>Pengeluaran/proses_edit/<?= $detail_pengeluaran['id_pengeluaran']; ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Pengeluaran:</label>
                        <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm example" name='nama' value="<?= $detail_pengeluaran['nama_pengeluaran']; ?>">
                    </div>
                    <div class="col-sm-4">
                        <label>Total:</label>
                        <input class="form-control form-control-sm" type="number" placeholder="Jumlah" aria-label=".form-control-sm example" id="jumlah" name='jumlah' value="<?= $detail_pengeluaran['jumlah']; ?>">
                    </div>
                    <div class="col-sm-4">
                        <label>Tanggal Pengeluaran:</label>
                        <input class="form-control form-control-sm" type="date" aria-label=".form-control-sm example" name='tanggal' value="<?= $detail_pengeluaran['tanggal']; ?>">
                    </div>
                    <div class="col-sm-4">
                        <br>
                        <label>Keterangan:</label>
                        <input class="form-control form-control-sm" type="text" value="-" aria-label=".form-control-sm example" name='keterangan' value="<?= $detail_pengeluaran['keterangan']; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-info btn-lg btn-block mt-4" name='kirim'>Ubah</button>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection('content'); ?>