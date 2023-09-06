<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Data Pasien</h6>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="<?= base_url(); ?>Pelayanan/add">
                    <button class="btn btn-danger">Tambah Pasien +</button>
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
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">No. RM</th>
                            <th scope="col">Biaya</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_pelayanan as $list) : ?>
                            <tr <?= ($list['check']) ? 'style="text-decoration: line-through;"' : ''; ?>>
                                <td scope="col"><?= $no; ?></td>
                                <td scope="col"><?= $list['nama_pasien'] ?></td>
                                <td scope="col"><?= $list['no_rm'] ?></td>
                                <td scope="col"><?= $list['biaya'] ?></td>
                                <td scope="col">
                                    <a title="lihat" href="<?= base_url(); ?>Pelayanan/check/<?= $list['id_pelayanan']; ?>" style="display: inline;">
                                        <button class="btn btn-primary btn-sm">Coret</button>
                                    </a>
                                    <a title="lihat" href="<?= base_url(); ?>Pelayanan/detail/<?= $list['id_pelayanan']; ?>" style="display: inline;">
                                        <button class="btn btn-warning btn-sm">Detail</button>
                                    </a>
                                    <a title="lihat" href="<?= base_url(); ?>Pelayanan/delete_pelayanan/<?= $list['id_pelayanan']; ?>" style="display: inline;">
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <a title="lihat" href="<?= base_url(); ?>Pelayanan/confirm" style="display: inline;">
                    <button class="btn btn-danger btn-md">Selesai</button>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>