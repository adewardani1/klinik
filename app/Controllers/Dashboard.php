<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;
use App\Models\PemeriksaModel;
use App\Models\JadwalModel;

class Dashboard extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel, $pemeriksaModel, $jadwalModel;

    public function __construct()
    {
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->obatModel = new ObatModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        $ambilPemeriksa = $this->pemeriksaModel->findAll();
        $ambilJadwal =  $this->jadwalModel->findAll();

        $data_jadwal = []; // Set nilai default berupa array kosong
        // Ubah struktur data jadwal menjadi lebih sesuai dengan format yang dibutuhkan di view
        foreach ($ambilJadwal as $jadwal_item) {
            $data_jadwal[$jadwal_item['id_pegawai']][$jadwal_item['hari']] = $jadwal_item['jam'];
        }

        $data = [
            'title' => "Dashboard",
            'data_pegawai' => $ambilPemeriksa,
            'jadwal' => $data_jadwal,
        ];

        return view('dashboard', $data);
    }



    // public function simpan_jadwal()
    // {
    //     $request = \Config\Services::request();

    //     if ($request->getMethod() == 'post') {
    //         $pegawai_id = $request->getPost('pegawai_id');
    //         $hari = $request->getPost('hari');
    //         $shift = $request->getPost('shift'); // Ambil nilai shift

    //         // Lakukan validasi jika diperlukan

    //         $data = [
    //             'id_pegawai' => $pegawai_id,
    //             'hari' => $hari,
    //             'jam' => $shift,
    //         ];

    //         $this->jadwalModel->insert($data);

    //         // Return respons jika diperlukan
    //         return $this->response->setJSON(['message' => 'Data tersimpan']);
    //     }
    // }

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
