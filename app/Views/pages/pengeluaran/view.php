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
            <!-- <div class="d-flex justify-content-start">
                <a href="export_kas.php" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm mt-1"><i class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
            </div> -->
            <div class="table-responsive service">
                <table class="table table-bordered table-hover  mt-3 text-nowrap css-serial">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Keperluan</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_pengeluaran as $list) : ?>
                            <tr>
                                <td scope="col"><?= $no; ?></td>
                                <td scope="col"><?= $list['tanggal'] ?></td>
                                <td scope="col"><?= $list['nama'] ?></td>
                                <td scope="col"><?= $list['jumlah'] ?></td>
                                <td scope="col">
                                    <a title="lihat" href="<?= base_url(); ?>Pengeluaran/edit/<?= $list['id_pengeluaran']; ?>" style="display: inline;">
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </a>
                                    <form action="<?= base_url(); ?>Pengeluaran/delete/<?= $list['id_pengeluaran']; ?>" method="post" class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>