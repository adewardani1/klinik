<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">DATA DIAGNOSA</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive service">
                <table class="table table-bordered table-hover mt-3 text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">DIAGNOSA</th>
                            <th scope="col">JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        foreach ($diagnosaCount as $diagnosa => $jumlah) : ?>
                            <tr>
                                <td scope="col"><?= $no; ?></td>
                                <td scope="col"><?= $diagnosa; ?></td>
                                <td scope="col"><?= $jumlah; ?></td>
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