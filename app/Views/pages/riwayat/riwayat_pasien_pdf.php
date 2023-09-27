<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Riwayat Medis</title>
    <!-- Atur gaya cetakan -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            Riwayat Medis
        </div>
        <div>
            <h6>Nama Pasien: <?= $detail_riwayat['nama']; ?></h6>
            <h6>Tanggal Lahir: <?= $detail_riwayat['tanggal_lahir']; ?></h6>
            <h6>Alamat: <?= $detail_riwayat['alamat']; ?></h6>
            <h6>No RM: <?= $detail_riwayat['no_rm']; ?></h6>
            <h6>No BPJS: <?= $detail_riwayat['no_bpjs']; ?></h6>
            <?php
            $tanggal_lahir = new DateTime($detail_riwayat['tanggal_lahir']);
            $today = new DateTime();
            $umur = $today->diff($tanggal_lahir);
            ?>
            <h6>Umur: <?= $umur->y; ?> Tahun</h6>
        </div>
        <div class="table-responsive service">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Nama Pemeriksa</th>
                        <th>Obat</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($list_riwayat as $list) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $list['keluhan'] ?></td>
                            <td><?= $list['diagnosa'] ?></td>
                            <td><?= $list['nama_pemeriksa'] ?></td>
                            <td><?= $list['obat'] ?></td>
                            <td><?= $list['keterangan'] ?></td>
                        </tr>
                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>