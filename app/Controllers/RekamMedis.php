<?php

namespace App\Controllers;

use App\Models\RekamModel;
use App\Models\RiwayatModel;
use App\Models\PelayananModel;
use App\Models\RiwayatObatModel;
use App\Models\AdminModel;
use App\Models\ObatModel;
use Dompdf\Dompdf;

class RekamMedis  extends BaseController
{
    protected $rekamModel, $riwayatModel, $pelayananModel, $riwayatObatModel, $adminModel, $obatModel;

    public function __construct()
    {
        if (session()->get('hak_akses') !== 'admin' &&  session()->get('hak_akses') !== 'pemeriksa') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->rekamModel = new RekamModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pelayananModel = new PelayananModel();
        $this->riwayatObatModel = new RiwayatObatModel();
        $this->adminModel = new AdminModel();
        $this->obatModel = new ObatModel();
    }

    public function index()
    {
        $ambilRM = $this->rekamModel->findAll();

        $data = [
            'datarm' => $ambilRM
        ];

        return view('pages/rm/view', $data);
    }

    public function tambah_rm()
    {
        return view('pages/rm/add');
    }

    public function proses_tambah_rm()
    {
        // Data yang akan diinsert ke dalam database
        $data = [
            'nama' => $this->request->getVar('nama'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'no_bpjs' => $this->request->getVar('no_bpjs'),
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

    public function riwayat($id_rm)
    {
        $data_list_riwayat = [];
        $list_riwayat = $this->riwayatModel->where(['id_rm' => $id_rm])->findAll();

        foreach ($list_riwayat as $riwayat) {
            // Masukkan data riwayat beserta nama obat ke dalam array
            $data_list_riwayat[] = [
                'id_riwayat' => $riwayat['id_riwayat'],
                'keluhan' => $riwayat['keluhan'],
                'diagnosa' => $riwayat['diagnosa'],
                'nama_pemeriksa' => $riwayat['nama_pemeriksa'],
                'obat' => $riwayat['obat'],
                'keterangan' => $riwayat['keterangan'],
            ];
        }

        $data = [
            'title' => 'Detail Jalan',
            'list_riwayat' => $data_list_riwayat,
            'detail_riwayat' => $this->rekamModel->where(['id_rm' => $id_rm])->first(),
        ];

        return view('/pages/riwayat/index', $data);
    }


    public function tambah_riwayat($id_rm)
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

    public function proses_riwayat($id_rm)
    {
        $jumlah_obat = $this->request->getVar('jumlah_obat');
        $keterangan_obat = '';

        // Loop melalui semua obat yang dipilih
        for ($i = 1; $i <= $jumlah_obat; $i++) {
            $id_obat = $this->request->getVar('obat_' . $i);
            $jumlah = $this->request->getVar('jumlah_obat_' . $i);

            // Mengurangi stok obat
            $this->obatModel->where('id_obat', $id_obat)->set('stok', 'stok - ' . $jumlah, FALSE)->update();

            // Ambil nama obat berdasarkan id_obat
            $obat = $this->obatModel->find($id_obat);
            if ($obat) {
                $nama_obat = $obat['nama_obat'];
                // Tambahkan data obat ke dalam keterangan_obat
                $keterangan_obat .= $jumlah . ' ' . $nama_obat . ', ';
            }
        }

        // Hilangkan koma dan spasi ekstra di akhir keterangan_obat
        $keterangan_obat = rtrim($keterangan_obat, ', ');

        // Data yang akan diinsert ke dalam database
        $this->riwayatModel->save([
            'id_rm' => $id_rm,
            'keluhan' => $this->request->getVar('keluhan'),
            'diagnosa' => $this->request->getVar('diagnosa'),
            'obat' => $keterangan_obat,
            'keterangan' => $this->request->getVar('keterangan')
        ]);

        $riwayat = $this->riwayatModel->where('id_rm', $id_rm)->first();
        $id_rm = $riwayat['id_rm'];
        return redirect()->to('RekamMedis/riwayat/' . $id_rm);
    }


    public function delete_rm($id_rm)
    {
        $this->pelayananModel->where('id_rm', $id_rm)->delete();
        $this->rekamModel->delete($id_rm);

        return redirect()->to('RekamMedis/index');
    }

    public function delete_riwayat($id_riwayat)
    {
        $riwayat = $this->riwayatModel->where('id_riwayat', $id_riwayat)->first();
        $id_rm = $riwayat['id_rm'];
        $this->riwayatModel->where('id_riwayat', $id_riwayat)->delete();

        return redirect()->to('RekamMedis/riwayat/' . $id_rm);
    }

    public function cetakPdf($idPasien)
    {
        // Load the Dompdf library from the service container
        $dompdf = new Dompdf();

        // Get data for your PDF
        $dataPasien = $this->rekamModel->find($idPasien);

        $list_riwayat = $this->riwayatModel->where(['id_rm' => $idPasien])->findAll();

        foreach ($list_riwayat as $riwayat) {
            // Masukkan data riwayat beserta nama obat ke dalam array
            $data_list_riwayat[] = [
                'id_riwayat' => $riwayat['id_riwayat'],
                'keluhan' => $riwayat['keluhan'],
                'diagnosa' => $riwayat['diagnosa'],
                'nama_pemeriksa' => $riwayat['nama_pemeriksa'],
                'obat' => $riwayat['obat'],
                'keterangan' => $riwayat['keterangan'],
            ];
        }

        // Create a view for your PDF content
        $html = view('pages/riwayat/riwayat_pasien_pdf.php', ['detail_riwayat' => $dataPasien, 'list_riwayat' => $list_riwayat]);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF (generate PDF)
        $dompdf->render();

        // Output the PDF to the browser
        $dompdf->stream("riwayat_pasien.pdf", ["Attachment" => false]);
    }
}
