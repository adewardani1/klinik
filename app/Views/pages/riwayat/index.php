<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Riwayat Medis</h6>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="row m-2">
                <div class="col-md-6 border-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Nama Pasien</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <label>: <?= $detail_riwayat['nama']; ?></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Tanggal Lahir</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <label>: <?= $detail_riwayat['tanggal_lahir']; ?></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <label>: <?= $detail_riwayat['alamat']; ?></label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 border-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">No RM</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <label>: <?= $detail_riwayat['no_rm']; ?></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">No BPJS</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <label>: <?= $detail_riwayat['no_bpjs']; ?></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Umur</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <?php
                            $tanggal_lahir = new DateTime($detail_riwayat['tanggal_lahir']);
                            $today = new DateTime();
                            $umur = $today->diff($tanggal_lahir);
                            ?>
                            <label>: <?= $umur->y; ?> Tahun</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="<?= base_url(); ?>RekamMedis/tambah_riwayat/<?= $detail_riwayat['id_rm']; ?>">
                    <button class="btn btn-danger">Tambah Riwayat Medis</button>
                </a>
                <!--  tombol atau tautan di tampilan riwayat pasien -->
                <a href="<?= site_url('RekamMedis/cetakPdf/' . $detail_riwayat['id_rm']); ?>" target="_blank" class="btn btn-primary ml-2">Cetak PDF</a>
            </div>
            <div class="table-responsive service">
                <table class="table table-bordered table-hover mt-3 text-nowrap css-serial">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Keluhan</th>
                            <th scope="col">Diagnosa</th>
                            <th scope="col">Nama Pemeriksa</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($list_riwayat as $list) : ?>
                            <tr>
                                <td scope="col"><?= $no ?></td>
                                <td scope="col"><?= $list['keluhan'] ?></td>
                                <td scope="col"><?= $list['diagnosa'] ?></td>
                                <td scope="col"><?= $list['nama_pemeriksa'] ?></td>
                                <td scope="col"><?= $list['obat'] ?></td>
                                <td scope="col"><?= $list['keterangan'] ?></td>
                                <td scope="col">
                                    <form action="<?= base_url(); ?>RekamMedis/delete_riwayat/<?= $list['id_riwayat']; ?>" method="post" class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach;
                        ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
</div>

<?= $this->endSection('content'); ?>