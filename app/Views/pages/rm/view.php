<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Rekam Medis</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="<?= base_url(); ?>RekamMedis/tambah_rm">
                    <button class="btn btn-danger">Tambah Rekam Medis +</button>
                </a>
            </div>
            <div>
                <br>
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
            </div>
            <div class="table-responsive service">
                <table class="table table-bordered mt-3 text-nowrap css-serial">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">No RM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No BPJS</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $no = 1;
                        foreach ($datarm as $list) : ?>
                            <tr>
                                <td scope="col"><?= $no ?></td>
                                <td scope="col"><?= $list['no_rm'] ?></td>
                                <td scope="col"><?= $list['nama'] ?></td>
                                <td scope="col"><?= $list['alamat'] ?></td>
                                <td scope="col"><?= $list['no_bpjs'] ?></td>
                                <td scope="col">
                                    <a title="edit" href="<?= base_url(); ?>Pelayanan/tambah_antrian/<?= $list['id_rm']; ?>" style="display: inline;">
                                        <button class="btn btn-primary btn-sm">Tambah</button>
                                    </a>
                                    <a title="lihat" href="<?= base_url(); ?>RekamMedis/riwayat/<?= $list['id_rm']; ?>" style="display: inline;">
                                        <button class="btn btn-warning btn-sm">Riwayat</button>
                                    </a>
                                    <form action="<?= base_url(); ?>RekamMedis/delete_rm/<?= $list['id_rm']; ?>" method="post" class="d-inline">
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

<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<?= $this->endSection('content'); ?>