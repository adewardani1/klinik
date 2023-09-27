<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;
use App\Models\JadwalModel;
use App\Models\PengeluaranModel;

class Dashboard extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel, $adminModel, $jadwalModel, $pengeluaranModel;

    public function __construct()
    {
        if (session()->get('hak_akses') !== 'admin' &&  session()->get('hak_akses') !== 'pemeriksa') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->obatModel = new ObatModel();
        $this->adminModel = new AdminModel();
        $this->jadwalModel = new JadwalModel();
        $this->pengeluaranModel = new PengeluaranModel();
    }

    public function index()
    {
        $ambilPasienHariIni = $this->riwayatModel->ambilPasienHariIni();
        $ambilPetugas = $this->adminModel->where('hak_akses !=', 'admin')->findAll();
        $ambilJadwal =  $this->jadwalModel->findAll();

        // URL ke file .txt untuk menyimpan catatan 
        $file_url = WRITEPATH . 'catatan.txt';

        // Membaca isi file .txt
        $catatan = file_get_contents($file_url);

        $data_jadwal = []; // Set nilai default berupa array kosong

        foreach ($ambilJadwal as $jadwal_item) {
            $data_jadwal[$jadwal_item['id_pegawai']][$jadwal_item['hari']] = $jadwal_item['jam'];
        }

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
            'title' => "Dashboard",
            'data_pegawai' => $ambilPetugas,
            'jadwal' => $data_jadwal,
            'jumlah_pasien' => $ambilPasienHariIni,
            'penghasilan' => $keuntungan,
            'catatan' => $catatan,
        ];

        return view('dashboard', $data);
    }

    public function simpan_catatan()
    {
        $catatan = $this->request->getPost('catatan');
        $file_path = WRITEPATH . 'catatan.txt';

        // Menyimpan catatan ke dalam file .txt
        $result = file_put_contents($file_path, $catatan);

        if ($result !== false) {
            return redirect()->to('Dashboard/index')->with('success', 'Catatan berhasil disimpan.');
        } else {
            return redirect()->to('Dashboard/index')->with('error', 'Gagal menyimpan catatan.');
        }
    }

    public function simpan_jadwal()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() == 'post') {
            $pegawai_id = $request->getPost('pegawai_id');
            $hari = $request->getPost('hari');
            $shift = $request->getPost('shift'); // Ambil nilai shift

            // Lakukan validasi jika pegawai sudah memiliki jadwal di hari ini
            $existingJadwal = $this->jadwalModel->where('id_pegawai', $pegawai_id)
                ->where('hari', $hari)
                ->first();

            if ($existingJadwal) {
                // Pegawai sudah memiliki jadwal di hari ini, lakukan update
                $this->jadwalModel->update($existingJadwal['id_jadwal'], [
                    'jam' => $shift,
                ]);
            } else {
                // Pegawai belum memiliki jadwal di hari ini, lakukan insert
                $data = [
                    'id_pegawai' => $pegawai_id,
                    'hari' => $hari,
                    'jam' => $shift,
                ];

                $this->jadwalModel->insert($data);
            }

            // Return respons jika diperlukan
            return $this->response->setJSON(['message' => 'Data tersimpan']);
        }
    }
}
