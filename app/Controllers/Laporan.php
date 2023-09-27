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
        if (session()->get('hak_akses') !== 'admin' &&  session()->get('hak_akses') !== 'pemeriksa') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
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
        $ambilKunjungan = $this->riwayatModel->getKunjunganHariIni();

        // Menghitung usia pasien berdasarkan tanggal lahir
        foreach ($ambilKunjungan as &$kunjungan) {
            $tanggalLahir = new \DateTime($kunjungan['tanggal_lahir']);
            $today = new \DateTime();
            $usia = $today->diff($tanggalLahir)->y;
            $kunjungan['usia'] = $usia;
        }

        $jumlahPasienBPJS = $this->riwayatModel->hitungJumlahPasienBPJS();

        $data = [
            'data_kunjungan' => $ambilKunjungan,
            'kategori_kunjungan' => $jumlahPasienBPJS,
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
