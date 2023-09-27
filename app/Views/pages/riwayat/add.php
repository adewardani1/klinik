<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Tambah Riwayat Medis</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive service">
                <form method="POST" action="RekamMedis/proses_riwayat/<?= $detail['id_rm']; ?>">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control" id="keluhan" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Diagnosa</label>
                        <input type="text" name="diagnosa" class="form-control" id="diagnosa" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_obat" class="form-label">Jumlah Obat</label>
                        <input type="number" name="jumlah_obat" class="form-control" id="jumlah_obat" required>
                    </div>
                    <div id="obat-container"></div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Biaya</label>
                        <input type="number" name="biaya" class="form-control" id="biaya" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ketika nilai input jumlah obat berubah
        $('#jumlah_obat').change(function() {
            generateObatInputs();
        });

        // Fungsi untuk meng-generate elemen input dan select
        function generateObatInputs() {
            var jumlahObat = $('#jumlah_obat').val(); // Ambil nilai jumlah obat
            // Kosongkan div tempat elemen-elemen input obat dan jumlahnya
            $('#obat-container').empty();

            // Buat elemen input dan select untuk setiap obat yang dipilih
            for (var i = 1; i <= jumlahObat; i++) {
                var inputJumlahObat = '<div class="col-md-6 mb-3"><label for="jumlah_obat_' + i + '" class="form-label">Jumlah Obat ' + i + '</label><input type="number" name="jumlah_obat_' + i + '" class="form-control" id="jumlah_obat_' + i + '" required></div>';

                var selectObat = '<div class="col-md-6 mb-3"><label for="obat_' + i + '" class="form-label">Obat ' + i + '</label><select class="custom-select" name="obat_' + i + '" id="obat_' + i + '">';

                <?php foreach ($data_obat as $list) : ?>
                    // Buat opsi select sesuai dengan jumlah_obat
                    var idObat = <?= $list['id_obat'] ?>;
                    var option = '<option value="' + idObat + '">' + '<?= $list['nama_obat'] ?>' + '</option>';
                    selectObat += option;
                <?php endforeach; ?>

                selectObat += '<option value="">Pilih Obat</option>';
                selectObat += '</select></div>';

                // Tambahkan elemen input dan select ke dalam container
                $('#obat-container').append('<div class="row">' + selectObat + inputJumlahObat + '</div>');
            }
        }
        generateObatInputs();
    });
</script>

<?= $this->endSection('content'); ?>