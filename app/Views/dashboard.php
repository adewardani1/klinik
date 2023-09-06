<?= $this->extend('/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
    <!-- <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol> -->
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jumlah Pasien Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2>10</h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-solid fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Penghasilan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2>10</h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Catatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <div class="form-group">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Jadwal Shift
                </div>
                <div class="table-responsive service">
                    <div class="card-body">
                        <table class="table table-bordered table-hover mt-3 text-nowrap css-serial custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Pegawai</th>
                                    <th scope="col">Senin</th>
                                    <th scope="col">Selasa</th>
                                    <th scope="col">Rabu</th>
                                    <th scope="col">Kamis</th>
                                    <th scope="col">Jumat</th>
                                    <th scope="col">Sabtu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_pegawai as $pegawai) : ?>
                                    <tr>
                                        <td><?= $pegawai['nama']; ?></td>
                                        <?php for ($day = 1; $day <= 6; $day++) : ?>
                                            <td>
                                                <select class="form-control" aria-label="Default select example" data-id="<?= $pegawai['id']; ?>" data-hari="<?= $day; ?>">
                                                    <option value="0" <?= (isset($jadwal[$pegawai['id']][$day]) && $jadwal[$pegawai['id']][$day] == 0) ? 'selected' : ''; ?>>NO SHIFT</option>
                                                    <option value="1" <?= (isset($jadwal[$pegawai['id']][$day]) && $jadwal[$pegawai['id']][$day] == 1) ? 'selected' : ''; ?>>Reguler Office Hours (08.00 - 22.00)</option>
                                                    <option value="2" <?= (isset($jadwal[$pegawai['id']][$day]) && $jadwal[$pegawai['id']][$day] == 2) ? 'selected' : ''; ?>>Reguler Shift (06.00 - 08.00)</option>
                                                    <option value="3" <?= (isset($jadwal[$pegawai['id']][$day]) && $jadwal[$pegawai['id']][$day] == 3) ? 'selected' : ''; ?>>Shift Malam (17.00 - 22.00)</option>
                                                </select>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menggunakan jQuery untuk mendeteksi perubahan pilihan dan mengirimkan data
        $(document).ready(function() {
            $('select').change(function() {
                var selectedOption = $(this).find(':selected');
                var pegawaiId = $(this).data('id'); // Mengambil data-id dari elemen select
                var shiftValue = selectedOption.val(); // Mengambil nilai (value) dari opsi yang dipilih
                var hari = $(this).data('hari'); // Mengambil data-hari dari elemen select

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '<?= base_url('Dashboard/simpan_jadwal'); ?>',
                    method: 'post',
                    data: {
                        pegawai_id: pegawaiId,
                        hari: hari,
                        shift: shiftValue, // Mengirim value shift ke server
                    },
                    success: function(response) {
                        // Berikan respons jika diperlukan
                        console.log(response);
                    }
                });
            });
        });
    </script>


    <?= $this->endSection('content'); ?>