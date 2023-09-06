<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Data Kunjungan</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive service">
                <table class="table table-bordered table-hover  mt-3 text-nowrap css-serial">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Usia</th>
                            <th scope="col">Diagnosa</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_kunjungan as $list) : ?>
                            <tr>
                                <td scope="col"><?= $no; ?></td>
                                <td scope="col"><?= $list['id_rm'] ?></td>
                                <td scope="col"><?= $list['id_rm'] ?></td>
                                <td scope="col"><?= $list['diagnosa'] ?></td>
                                <td scope="col"><?= $list['id_obat'] ?></td>
                                <td scope="col"><?= $list['biaya'] ?></td>
                            </tr>
                        <?php
                            $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="py-3 justify-content-between">
                <p class="m-0 font-weight-bold text-info">Umum :</p>
                <p class="m-0 font-weight-bold text-info">BPJS :</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>