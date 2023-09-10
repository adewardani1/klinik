<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;
use App\Models\PemeriksaModel;

class Pegawai extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel, $pemeriksaModel, $adminModel;

    public function __construct()
    {
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->obatModel = new ObatModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $ambilPemeriksa = $this->pemeriksaModel->findAll();
        $ambilAdmin = $this->adminModel->findAll();

        $data = [
            'data_pemeriksa' => $ambilPemeriksa,
            'data_admin' => $ambilAdmin,
        ];

        return view('pages/pegawai/view', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => "Dashboard",
        ];

        return view('pages/pegawai/add', $data);
    }


    public function edit_admin($id)
    {
        $data = [
            'title' => 'Detail Jalan',
            'data_admin' => $this->adminModel->where(['id' => $id])->first(),
        ];

        return view('/pages/pegawai/edit', $data);
    }

    public function edit_pemeriksa($id)
    {
        $data = [
            'title' => 'Detail Jalan',
            'data_pegawai' => $this->rekamModel->where(['id' => $id])->first(),
        ];

        return view('/pages/riwayat/index', $data);
    }

    public function hapus_pemeriksa($id)
    {
        $this->pemeriksaModel->where('id', $id)->delete();

        return redirect()->to('Pegawai/index');
    }

    public function hapus_admin($id)
    {
        $this->adminModel->where('id', $id)->delete();

        return redirect()->to('Pegawai/index');
    }
}
