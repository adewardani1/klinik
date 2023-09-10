<?php

namespace App\Controllers;

use App\Models\PengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $pengeluaranModel;

    public function __construct()
    {
        $this->pengeluaranModel = new PengeluaranModel();
    }

    public function index()
    {
        $ambilPengeluaran = $this->pengeluaranModel->findAll();

        $data = [
            'data_pengeluaran' => $ambilPengeluaran,
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

        return redirect()->to('Pengeluaran/index');
    }

    public function edit($id_pengeluaran)
    {
        $ambilPengeluaran = $this->pengeluaranModel->where('id_pengeluaran', $id_pengeluaran)->first();

        $data = [
            'detail_pengeluaran' => $ambilPengeluaran,
        ];

        return view('pages/pengeluaran/edit', $data);
    }

    public function process_edit($id_pengeluaran)
    {

        $dataToUpdatePelayanan = [
            'nama' => $this->request->getVar('nama'),
            'jumlah' => $this->request->getVar('jumlah'),
            'tanggal' => $this->request->getVar('tanggal'),
            'keterangan' => $this->request->getVar('keterangan'),
        ];

        $this->pengeluaranModel->update($id_pengeluaran, $dataToUpdatePelayanan);

        return redirect()->to('Pengeluaran/index');
    }

    public function delete($id_pengeluaran)
    {
        $this->pengeluaranModel->where('id_pengeluaran', $id_pengeluaran)->delete();

        return redirect()->to('Pengeluaran/index');
    }
}
