<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;

class Pegawai extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel, $adminModel;

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
    }

    public function index()
    {
        $ambilAdmin = $this->adminModel->findAll();

        $data = [
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

    public function proses_tambah()
    {
        // Data yang akan diinsert ke dalam database
        $dataPegawai = [
            'nama' => $this->request->getVar('nama_pegawai'),
            'hak_akses' => $this->request->getVar('bagian'),
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
        ];

        // Memasukkan data ke dalam tabel
        $this->adminModel->insert($dataPegawai);

        return redirect()->to('Pegawai/index');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Detail Jalan',
            'data_admin' => $this->adminModel->where(['id' => $id])->first(),
        ];

        return view('/pages/pegawai/edit', $data);
    }

    public function hapus($id)
    {
        $this->adminModel->where('id', $id)->delete();

        return redirect()->to('Pegawai/index');
    }
}
