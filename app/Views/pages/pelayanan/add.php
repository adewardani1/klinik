<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Tambah Pasien</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive service">
                <form method="POST" action="<?= base_url(); ?>Pelayanan/process_add">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                        <input type="text" name="nama_pasien" class="form-control" id="nama_pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                        <input class="form-control" type="date" aria-label=".form-control-sm example" name='tanggal' id="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pasien" class="form-label">Jenis Pasien</label>
                        <select class="form-control" id="jenis_pasien">
                            <option value="non_bpjs">Non-BPJS</option>
                            <option value="bpjs">BPJS</option>
                        </select>
                    </div>
                    <div class="mb-3" id="no_bpjs_input" style="display: none;">
                        <label for="no_bpjs" class="form-label">NO BPJS</label>
                        <input type="text" name="no_bpjs" class="form-control" id="no_bpjs">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keluhan</label>
                        <textarea type="text" name="keluhan" class="form-control" id="keluhan" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-info">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('jenis_pasien').addEventListener('change', function() {
        var jenis_pasien = this.value;
        var no_bpjs_input = document.getElementById('no_bpjs_input');

        if (jenis_pasien === 'bpjs') {
            no_bpjs_input.style.display = 'block';
        } else {
            no_bpjs_input.style.display = 'none';
        }
    });
</script>


<?= $this->endSection('content'); ?>