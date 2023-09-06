<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Edit Anggota</h6>
        </div>
        <!-- Card Body -->

        <div class="row ml-5 mb-2 mt-3">
            <form method="POST" name="edit">
                <table class="table mt-3 text-nowrap css-serial">
                    <tr>
                        <td><b>Nama Anggota </b></td>
                        <td><input type="text" name="nama" value="<?php echo $data_admin['nama']; ?>" requireds /></td>
                    </tr>
                    <tr>
                        <td><b>Alamat</b></td>
                        <td><input type="text" name="alamat" value="" requireds /></td>
                    </tr>
                </table>
                <br>
                <button type="submit" class="btn btn-info" name='edit'>Simpan</button>&nbsp;<input type="reset" class="btn btn-danger" value="Kembali">
                <br><br>
            </form>
        </div>

    </div>
</div>

<?= $this->endSection('content'); ?>