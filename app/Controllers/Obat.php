<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;

class Obat extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel;

    public function __construct()
    {
        if (session()->get('hak_akses') !== 'admin' &&  session()->get('hak_akses') !== 'pemeriksa') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->obatModel = new ObatModel();
    }

    public function index()
    {
        $ambilObat = $this->obatModel->findAll();

        $data = [
            'data_obat' => $ambilObat,
        ];

        return view('pages/obat/view', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => "Tambah Obat",
        ];

        return view('pages/obat/add', $data);
    }


    public function edit($id_obat)
    {
        $data = [
            'title' => "Edit Obat",
            'detail' => $this->obatModel->where(['id_obat' => $id_obat])->first(),
        ];

        return view('pages/obat/edit', $data);
    }

    public function proses_edit($id_obat)
    {
        // Mengupdate data
        $dataObat = [
            'nama_obat' => $this->request->getVar('nama_obat'),
            'jenis_obat' => $this->request->getVar('jenis_obat'),
            'stok' => $this->request->getVar('stok'),
        ];

        $this->obatModel->update($id_obat, $dataObat);

        return redirect()->to('Obat/index');
    }

    public function proses_tambah()
    {
        // Data yang akan diinsert ke dalam database
        $this->obatModel->save([
            'nama_obat' => $this->request->getVar('nama_obat'),
            'jenis_obat' => $this->request->getVar('jenis_obat'),
            'stok' => $this->request->getVar('stok'),
        ]);

        return redirect()->to('Obat/index');
    }

    public function proses_hapus($id_obat)
    {
        $this->obatModel->where('id_obat', $id_obat)->delete();

        return redirect()->to('Obat/index');
    }
}
