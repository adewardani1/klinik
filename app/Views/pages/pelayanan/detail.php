<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Detail Riwayat Pasien</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive service">
                <form method="POST" action="<?= base_url(); ?>Pelayanan/simpan_detail/<?= $detail['id_pelayanan']; ?>">
                    <div class="mb-3">
                        <label class="form-label ">Keluhan</label>
                        <textarea name="keluhan" class="form-control <?= (validation_show_error('keluhan')) ? 'is-invalid' : ''; ?>" id="keluhan"><?= $detail['keluhan']; ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('keluhan'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diagnosa</label>
                        <input type="text" name="diagnosa" class="form-control <?= (validation_show_error('diagnosa')) ? 'is-invalid' : ''; ?>" id="diagnosa" value="<?= $detail['diagnosa']; ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('diagnosa'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pemeriksa</label>
                        <select class="form-control" id="id_pemeriksa" name="id_pemeriksa">
                            <?php foreach ($data_pemeriksa as $pemeriksa) : ?>
                                <option value="<?= $pemeriksa['id']; ?>" <?php if ($pemeriksa['id'] == $detail['id_pemeriksa']) echo 'selected'; ?>>
                                    <?= $pemeriksa['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= validation_show_error('id_pemeriksa'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_obat" class="form-label">Jumlah Obat</label>
                        <input type="number" name="jumlah_obat" class="form-control" id="jumlah_obat" value="<?= $jumlahDataObat; ?>">
                    </div>
                    <div id="obat-container"></div>
                    <div class="mb-3">
                        <label class="form-label">Biaya</label>
                        <input type="text" name="biaya" class="form-control" id="biaya" value="<?= 'Rp. ' . number_format($detail['biaya'], 0, ',', '.'); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan"><?= $detail['keterangan']; ?></textarea>
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
        // Ambil nilai biaya saat halaman dimuat
        var biaya = <?= $detail['biaya']; ?>;

        var formattedBiaya = 'Rp. ' + biaya.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Tampilkan nilai yang telah diformat pada input biaya
        $('#biaya').val(formattedBiaya);

        // Ketika input biaya berubah, perbarui tampilan sesuai format
        $('#biaya').on('input', function() {
            var inputBiaya = $(this).val();
            var numericBiaya = inputBiaya.replace(/\D/g, ''); // Hapus semua karakter non-digit
            formattedBiaya = 'Rp. ' + numericBiaya.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(formattedBiaya);
        });

        // Saat pengiriman formulir, hapus format "Rp."
        $('form').submit(function() {
            var inputBiaya = $('#biaya').val();
            var numericBiaya = inputBiaya.replace(/\D/g, ''); // Hapus semua karakter non-digit
            $('#biaya').val(numericBiaya);
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Mengambil data obat-obatan yang sudah diseleksi dari PHP
        var selectedObatArray = <?= json_encode($selectedObat); ?>;
        var detail_obat = <?= json_encode($detail_obat); ?>;

        // Ketika nilai input jumlah obat berubah
        $('#jumlah_obat').change(function() {
            generateObatInputs();
        });

        // Fungsi untuk meng-generate elemen input dan select
        function generateObatInputs() {
            var jumlahObat = $('#jumlah_obat').val(); // Ambil nilai jumlah obat
            $('#obat-container').empty();

            // Buat elemen input dan select untuk setiap obat yang dipilih
            for (var i = 1; i <= jumlahObat; i++) {
                var inputJumlahObat = '<div class="col-md-6 mb-3"><label for="jumlah_obat_' + i + '" class="form-label">Jumlah Obat ' + i + '</label><input type="number" name="jumlah_obat_' + i + '" class="form-control" id="jumlah_obat_' + i + '"></div>';
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

            // Jika detail_obat ada, isi kembali opsi select sesuai dengan nilai yang ada di detail_obat
            if (detail_obat.length > 0) {
                detail_obat.forEach(function(obat, index) {
                    $('#obat_' + (index + 1)).val(obat.id_obat); // Atur nilai select
                    $('#jumlah_obat_' + (index + 1)).val(obat.jumlah_obat); // Atur nilai input jumlah obat
                });
            }
        }

        // Panggil fungsi saat halaman dimuat
        generateObatInputs();
    });
</script>
<?= $this->endSection('content'); ?>