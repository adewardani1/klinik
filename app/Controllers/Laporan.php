<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\PengeluaranModel;

class Laporan extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $pengeluaranModel;

    public function __construct()
    {
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->pengeluaranModel = new PengeluaranModel();
    }

    public function diagnosa()
    {
        $ambilRiwayat = $this->riwayatModel->findAll();

        $diagnosaCount = []; // Array untuk menghitung jumlah diagnosa

        foreach ($ambilRiwayat as $riwayat) {
            $diagnosa = strtolower($riwayat['diagnosa']); // Ubah ke huruf kecil

            if (isset($diagnosaCount[$diagnosa])) {
                $diagnosaCount[$diagnosa]++;
            } else {
                $diagnosaCount[$diagnosa] = 1;
            }
        }

        // Urutkan diagnosa berdasarkan jumlah terbanyak
        arsort($diagnosaCount);

        // Ambil hanya 5 teratas
        $diagnosaCount = array_slice($diagnosaCount, 0, 5);


        $data = [
            'datarm' => $ambilRiwayat,
            'diagnosaCount' => $diagnosaCount,
        ];

        return view('pages/laporan/diagnosa', $data);
    }

    public function kunjungan()
    {
        // Ambil tanggal hari ini
        $today = date('Y-m-d ');
        $startOfDay = $today . ' 00:00:00';
        $endOfDay = $today . ' 23:59:59';

        // Query untuk mengambil data kunjungan hari ini
        $ambilKunjungan = $this->riwayatModel
            ->where('created_at >=', $startOfDay)
            ->where('created_at <=', $endOfDay)
            ->findAll();

        $data = [
            'data_kunjungan' => $ambilKunjungan,
        ];

        return view('pages/laporan/kunjungan', $data);
    }

    public function keuangan()
    {

        // Mengambil semua data
        $ambilRiwayat = $this->riwayatModel->findAll();
        $ambilPengeluaran = $this->pengeluaranModel->findAll();

        // Menghitung total biaya
        $totalBiaya = 0;
        foreach ($ambilRiwayat as $riwayat) {
            $totalBiaya += $riwayat['biaya'];
        }

        $totalPengeluaran = 0;
        foreach ($ambilPengeluaran as $pengeluaran) {
            $totalPengeluaran += $pengeluaran['jumlah'];
        }

        $keuntungan = $totalBiaya - $totalPengeluaran;

        $data = [
            'pemasukan' => $totalBiaya,
            'pengeluaran' => $totalPengeluaran,
            'keuntungan' => $keuntungan
        ];

        return view('pages/laporan/keuangan', $data);
    }
}
