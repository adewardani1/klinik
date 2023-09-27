<?php

namespace App\Controllers;

use App\Models\PengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $pengeluaranModel;

    public function __construct()
    {
        if (session()->get('hak_akses') !== 'admin' &&  session()->get('hak_akses') !== 'pemeriksa') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
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

    public function tambah()
    {
        $data = [
            'title' => "Dashboard",
        ];

        return view('pages/pengeluaran/add', $data);
    }

    public function proses_tambah()
    {
        // Data yang akan diinsert ke dalam database
        $data = [
            'nama_pengeluaran' => $this->request->getVar('nama'),
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

    public function proses_edit($id_pengeluaran)
    {
        $dataToUpdatePelayanan = [
            'nama_pengeluaran' => $this->request->getVar('nama'),
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
