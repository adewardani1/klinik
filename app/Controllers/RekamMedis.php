<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;
use App\Models\AdminModel;

class RekamMedis  extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel, $adminModel;

    public function __construct()
    {
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->obatModel = new ObatModel();
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $ambilRM = $this->rekamModel->findAll();
        $data = [
            'datarm' => $ambilRM
        ];

        return view('pages/rm/view', $data);
    }

    public function add_rm()
    {
        return view('pages/rm/add');
    }

    public function process_rm()
    {
        // Data yang akan diinsert ke dalam database
        $data = [
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
        ];

        // Memasukkan data ke dalam tabel
        $this->rekamModel->insert($data);

        // Mengambil ID dari data yang baru saja diinputkan
        $newId = $this->rekamModel->insertID();
        $no_rm = "RM" . $newId;

        // Update data dengan nomor RM yang sesuai
        $dataToUpdate = [
            'no_rm' => $no_rm,
        ];

        $this->rekamModel->update($newId, $dataToUpdate);

        return redirect()->to('RekamMedis/index');
    }

    public function delete_rm($id_rm)
    {

        $this->pelayananModel->where('id_rm', $id_rm)->delete();
        $this->rekamModel->delete($id_rm);

        return redirect()->to('RekamMedis/index');
    }

    public function riwayat($id_rm)
    {
        $data = [
            'title' => 'Detail Jalan',
            'list_riwayat' => $this->riwayatModel->where(['id_rm' => $id_rm])->findAll(),
            'detail_riwayat' => $this->rekamModel->where(['id_rm' => $id_rm])->first(),
        ];

        return view('/pages/riwayat/index', $data);
    }


    public function add_riwayat($id_rm)
    {
        // Ambil obat yang memiliki stok lebih dari 0
        $ambilObat = $this->obatModel->where('stok >', 0)->findAll();
        $ambilPetugas = $this->adminModel->findAll();

        $data = [
            'title' => 'Detail Pelaporan',
            'detail' => $this->rekamModel->where(['id_rm' => $id_rm])->first(),
            'data_obat' => $ambilObat,
            'data_petugas' => $ambilPetugas,
        ];

        return view('pages/riwayat/add', $data);
    }

    public function process_riwayat($id_rm)
    {

        $id_obat = $this->request->getVar('id_obat');

        // Mengurangi stok obat
        $this->obatModel->where('id_obat', $id_obat)->set('stok', 'stok - 1', FALSE)->update();

        // Data yang akan diinsert ke dalam database
        $this->riwayatModel->save([
            'id_rm' => $id_rm,
            'keluhan' => $this->request->getVar('keluhan'),
            'diagnosa' => $this->request->getVar('diagnosa'),
            'id_obat' => $id_obat,
        ]);

        $data = [
            'title' => 'Detail Pelaporan',
            'list_riwayat' => $this->riwayatModel->findAll($id_rm),
            'detail_riwayat' => $this->rekamModel->where(['id_rm' => $id_rm])->first(),
        ];

        return view('pages/riwayat/index', $data);
    }
}
