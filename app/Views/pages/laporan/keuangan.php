<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Data Pengeluaran</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="<?= base_url(); ?>Pengeluaran/add">
                    <button class="btn btn-danger">Tambah Pengeluaran +</button>
                </a>
            </div>
            <div class="table-responsive service">
                <table class="table table-bordered table-hover  mt-3 text-nowrap css-serial">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Pemasukan</th>
                            <th scope="col">Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td scope="col">Rp <?= number_format($pemasukan, 0, ',', '.'); ?></td>
                            <td scope="col">Rp <?= number_format($pengeluaran, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                    <tr>
                        <th scope="col" colspan="2">Laba Bersih : Rp <?= number_format($keuntungan, 0, ',', '.'); ?></th>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>