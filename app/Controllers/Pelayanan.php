<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\ObatModel;
use App\Models\AdminModel;
use App\Models\RiwayatObatModel;

class Pelayanan extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $obatModel, $adminModel, $riwayatObatModel;
    protected $helpers = ['form'];

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
        $this->riwayatObatModel = new RiwayatObatModel();
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

    public function tambah()
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

    public function proses_tambah()
    {
        if (!$this->validate([
            'nama_pasien' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi dan tidak boleh kosong!'
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi dan tidak boleh kosong!'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi dan tidak boleh kosong!'
                ]
            ],
            'keluhan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi dan tidak boleh kosong!'
                ]
            ],
        ])) {
            return redirect()->to('Pelayanan/add/')->withInput();
        }
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
        $ambilPemeriksa = $this->adminModel->getPemeriksa();
        $ambilObat = $this->obatModel->where('stok >', 0)->findAll();
        $dataPelayanan = $this->pelayananModel->where(['id_pelayanan' => $id_pelayanan])->first();
        $riwayatObat = $this->riwayatObatModel->where(['id_pelayanan' => $id_pelayanan])->findAll();

        $selectedObat = []; // Inisialisasi array untuk menyimpan id obat

        // Loop untuk mengambil id obat yang sudah dipilih sebelumnya
        foreach ($riwayatObat as $obat) {
            $selectedObat[] = $obat['id_obat'];
        }

        $data = [
            'title' => 'Detail Pelaporan',
            'detail' => $dataPelayanan,
            'detail_obat' => $riwayatObat,
            'data_obat' => $ambilObat,
            'data_pemeriksa' => $ambilPemeriksa,
            'jumlahDataObat' => count($riwayatObat),
            'selectedObat' => $selectedObat, // Mengirimkan data obat yang sudah dipilih sebelumnya ke tampilan
        ];

        return view('pages/pelayanan/detail', $data);
    }

    public function simpan_detail($id_pelayanan)
    {
        if (!$this->validate([
            'keluhan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi dan tidak boleh kosong!'
                ]
            ],
            'diagnosa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi dan tidak boleh kosong!'
                ]
            ],
        ])) {
            return redirect()->to('Pelayanan/detail/' . $id_pelayanan)->withInput();
        }

        // Ambil jumlah obat dari form
        $jumlahObat = $this->request->getVar('jumlah_obat');
        // Lakukan loop untuk menyimpan setiap obat yang dipilih
        for ($i = 1; $i <= $jumlahObat; $i++) {
            $dataObat = [
                'id_pelayanan' => $id_pelayanan,
                'id_obat' => $this->request->getVar('obat_' . $i), // Ambil obat 
                'jumlah_obat' => $this->request->getVar('jumlah_obat_' . $i), // Ambil jumlah obat 
            ];

            // Simpan data obat ke dalam database
            $this->riwayatObatModel->saveObat($dataObat, $id_pelayanan); //
        }

        // Simpan data lainnya seperti keluhan, diagnosa, biaya, d1an keterangan
        $this->pelayananModel->save([
            'id_pelayanan' => $id_pelayanan,
            'keluhan' => $this->request->getVar('keluhan'),
            'id_pemeriksa' => $this->request->getVar('id_pemeriksa'),
            'diagnosa' => $this->request->getVar('diagnosa'),
            'biaya' => $this->request->getVar('biaya'),
            'keterangan' => $this->request->getVar('keterangan'),
        ]);

        return redirect()->to('Pelayanan/index');
    }

    public function tambah_antrian($id_rm)
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

    public function hapus_pelayanan($id_pelayanan)
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

    public function konfirm()
    {
        // Ambil data pelayanan yang sudah dicoret
        $data_pelayanan_dicoret = $this->pelayananModel->getPelayananDicoret();

        // Loop melalui data pelayanan yang dicoret dan masukkan ke dalam detail riwayat
        foreach ($data_pelayanan_dicoret as $pelayanan) {
            // Dapatkan data obat berdasarkan id pelayanan dari model riwayatObatModel
            $data_obat = $this->riwayatObatModel->where('id_pelayanan', $pelayanan['id_pelayanan'])->findAll();

            // Loop melalui data obat untuk menggabungkan jumlah obat dan nama obat
            $jumlahObatNamaObat = '';
            foreach ($data_obat as $obat) {
                $nama_obat = $this->obatModel->where('id_obat', $obat['id_obat'])->first();
                if ($nama_obat) {
                    $nama_obat = $nama_obat['nama_obat'];
                } else {
                    $nama_obat = 'Nama Obat Tidak Ditemukan'; // Handle jika id_obat tidak ada di obatModel
                }
                $jumlahObatNamaObat .= $obat['jumlah_obat'] . ' ' . $nama_obat . ', ';

                // Kurangi stok obat berdasarkan id_obat
                $this->obatModel->where('id_obat', $obat['id_obat'])
                    ->set('stok', 'stok - ' . $obat['jumlah_obat'], false)
                    ->update();
            }
            // Hilangkan koma dan spasi di akhir string
            $jumlahObatNamaObat = rtrim($jumlahObatNamaObat, ', ');

            // Dapatkan nama pemeriksa berdasarkan ID pemeriksa
            $nama_pemeriksa = $this->adminModel->find($pelayanan['id_pemeriksa']);
            if ($nama_pemeriksa) {
                $nama_pemeriksa = $nama_pemeriksa['nama'];
            } else {
                $nama_pemeriksa = 'Nama Pemeriksa Tidak Ditemukan';
            }

            $data_detail_riwayat = [
                'id_rm' => $pelayanan['id_rm'],
                'keluhan' => $pelayanan['keluhan'],
                'diagnosa' => $pelayanan['diagnosa'],
                'nama_pemeriksa' => $nama_pemeriksa,
                'obat' => $jumlahObatNamaObat, // Simpan teks jumlah obat + nama obat
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
