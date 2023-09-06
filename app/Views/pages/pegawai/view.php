<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Data Pegawai Administrasi</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="<?= base_url(); ?>RekamMedis/add_rm">
                    <button class="btn btn-danger">Tambah Petugas +</button>
                </a>
            </div>
            <div class="table-responsive service">
                <table class="table table-bordered table-hover  mt-3 text-nowrap css-serial">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pegawai</th>
                            <th scope="col">Username</th>
                            <th scope="col">Bagian</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $no = 1;
                        foreach ($data_admin as $list) : ?>
                            <tr>
                                <td scope="col"><?= $no; ?></td>
                                <td scope="col"><?= $list['nama'] ?></td>
                                <td scope="col"><?= $list['nama'] ?></td>
                                <td scope="col"><?= $list['hak_akses'] ?></td>
                                <td scope="col">
                                    <a title="lihat" href="<?= base_url(); ?>Pegawai/edit_admin/<?= $list['id']; ?>" style="display: inline;">
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </a>
                                    <form action="<?= base_url(); ?>Pegawai/hapus_admin/<?= $list['id']; ?>" method="post" class="d-inline">
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

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Data Pegawai Pemeriksa</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive service">
                <table class="table table-bordered table-hover  mt-3 text-nowrap css-serial">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pegawai</th>
                            <th scope="col">Username</th>
                            <th scope="col">Jadwal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $no = 1;
                        foreach ($data_pemeriksa as $list) : ?>
                            <tr>
                                <td scope="col"><?= $no; ?></td>
                                <td scope="col"><?= $list['nama'] ?></td>
                                <td scope="col"><?= $list['nama'] ?></td>
                                <td scope="col"><?= $list['hak_akses'] ?></td>
                                <td scope="col">
                                    <a title="lihat" href="<?= base_url(); ?>Pegawai/edit_admin/<?= $list['id']; ?>" style="display: inline;">
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </a>
                                    <form action="<?= base_url(); ?>Pegawai/hapus_pemeriksa/<?= $list['id']; ?>" method="post" class="d-inline">
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