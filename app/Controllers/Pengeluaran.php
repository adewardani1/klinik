<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\PengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $pengeluaranModel;

    public function __construct()
    {
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->pengeluaranModel = new PengeluaranModel();
    }

    public function index()
    {
        $ambilPelayanan = $this->pelayananModel->findAll();

        $data = [
            'data_pelayanan' => $ambilPelayanan,
        ];

        return view('pages/pengeluaran/view', $data);
    }

    public function add()
    {
        $data = [
            'title' => "Dashboard",
        ];

        return view('pages/pengeluaran/add', $data);
    }

    public function process_add()
    {
        // Data yang akan diinsert ke dalam database
        $data = [
            'nama' => $this->request->getVar('nama'),
            'jumlah' => $this->request->getVar('jumlah'),
            'tanggal' => $this->request->getVar('tanggal'),
            'keterangan' => $this->request->getVar('keterangan'),
        ];

        // Memasukkan data ke dalam tabel
        $this->pengeluaranModel->insert($data);

        return view('pages/pengeluaran/add', $data);
    }
}
