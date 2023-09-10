<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;
use App\Models\AdminModel;

class Pelayanan extends BaseController
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
        $ambilPelayanan = $this->pelayananModel->findAll();

        // Lakukan perubahan nilai 'check' untuk setiap baris pelayanan
        foreach ($ambilPelayanan as &$pelayanan) {
            if (!$pelayanan['check']) {
                $pelayanan['check'] = false;
            } else {
                $pelayanan['check'] = true;
            }
        }

        $data = [
            'data_pelayanan' => $ambilPelayanan,
        ];

        return view('pages/pelayanan/view', $data);
    }

    public function add()
    {

        $ambilObat = $this->obatModel->findAll();
        $ambilPetugas = $this->adminModel->findAll();

        $data = [
            'title' => 'Detail Pelaporan',
            'data_obat' => $ambilObat,
            'data_petugas' => $ambilPetugas,
        ];

        return view('pages/pelayanan/add', $data);
    }

    public function process_add()
    {

        // Data yang akan diinsert ke dalam database rekam model
        $data = [
            'id_rm' => NULL,
            'nama' => $this->request->getVar('nama_pasien'),
            'no_bpjs' => $this->request->getVar('no_bpjs'),
            'alamat' => $this->request->getVar('alamat'),
            'tanggal_lahir' => $this->request->getVar('tanggal'),
        ];

        // Memasukkan data ke dalam tabel
        $this->rekamModel->insert($data);

        // Mengambil ID dari data yang baru saja diinputkan
        $newIdRM = $this->rekamModel->insertID();

        // Data yang akan diinsert ke dalam database
        $data = [
            'id_rm' => $newIdRM,
            'nama_pasien' => $this->request->getVar('nama_pasien'),
            'no_bpjs' => $this->request->getVar('no_bpjs'),
            'keluhan' => $this->request->getVar('keluhan'),

        ];

        // Memasukkan data ke dalam tabel
        $this->pelayananModel->insert($data);

        // Mengambil ID dari data yang baru saja diinputkan
        $newId = $this->pelayananModel->insertID();
        $no_rm = "RM" . $newId;

        // Update data dalam model pelayanan
        $dataToUpdatePelayanan = [
            'no_rm' => $no_rm,
        ];
        $this->pelayananModel->update($newId, $dataToUpdatePelayanan);

        // Update data dalam model rekam
        $dataToUpdateRekam = [
            'no_rm' => $no_rm,
        ];
        $this->rekamModel->update($newIdRM, $dataToUpdateRekam);

        return redirect()->to('Pelayanan/index');
    }

    public function detail($id_pelayanan)
    {

        $ambilObat = $this->obatModel->findAll();
        $ambilPetugas = $this->adminModel->findAll();

        $data = [
            'title' => 'Detail Pelaporan',
            'detail' => $this->pelayananModel->where(['id_pelayanan' => $id_pelayanan])->first(),
            'data_obat' => $ambilObat,
            'data_petugas' => $ambilPetugas,
        ];

        return view('pages/pelayanan/detail', $data);
    }

    public function save($id_pelayanan)
    {
        $this->pelayananModel->save([
            'id_pelayanan' => $id_pelayanan,
            'keluhan' => $this->request->getVar('keluhan'),
            'diagnosa' => $this->request->getVar('diagnosa'),
            'id_obat' => $this->request->getVar('id_obat'),
            'biaya' => $this->request->getVar('biaya'),
            'keterangan' => $this->request->getVar('keterangan'),
        ]);

        return redirect()->to('Pelayanan/index');
    }

    public function add_pelayanan($id_rm)
    {

        $ambilRM = $this->rekamModel->where('id_rm', $id_rm)->first();
        // Data yang akan diinsert ke dalam database
        $this->pelayananModel->save([
            'id_rm' => $ambilRM['id_rm'],
            'nama_pasien' => $ambilRM['nama'],
            'no_rm' => $ambilRM['no_rm'],
        ]);

        return redirect()->to('Pelayanan/index');
    }

    public function delete_pelayanan($id_pelayanan)
    {

        $this->pelayananModel->where('id_pelayanan', $id_pelayanan)->delete();

        return redirect()->to('Pelayanan/index');
    }

    public function check($id_pelayanan)
    {
        $pelayanan = $this->pelayananModel->find($id_pelayanan);
        if ($pelayanan) {
            $updatedCheck = !$pelayanan['check']; // Mengubah nilai 'coret' dari false menjadi true atau sebaliknya

            $this->pelayananModel->update($id_pelayanan, ['check' => $updatedCheck]);

            return redirect()->to(base_url("Pelayanan/index"));
        } else {
            // Jika data tidak ditemukan
        }
    }

    public function confirm()
    {
        // Ambil data pelayanan yang sudah dicoret
        $data_pelayanan_dicoret = $this->pelayananModel->getPelayananDicoret();

        // Loop melalui data pelayanan yang dicoret dan masukkan ke dalam detail riwayat
        foreach ($data_pelayanan_dicoret as $pelayanan) {
            $data_detail_riwayat = [
                'id_rm' => $pelayanan['id_rm'],
                'keluhan' => $pelayanan['keluhan'],
                'diagnosa' => $pelayanan['diagnosa'],
                'id_obat' => $pelayanan['id_obat'],
                'biaya' => $pelayanan['biaya'],
                'keterangan' => $pelayanan['keterangan'],
            ];

            // Simpan data ke dalam detail riwayat
            $this->riwayatModel->insert($data_detail_riwayat);

            // Hapus data pelayanan yang sudah dicoret
            $this->pelayananModel->delete($pelayanan['id_pelayanan']);
        }

        // Redirect atau berikan pesan notifikasi setelah selesai
        return redirect()->to('Pelayanan/index');
    }
}
