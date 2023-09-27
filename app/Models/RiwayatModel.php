<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatModel extends Model
{
    protected $table      = 'riwayat_medis';
    protected $primaryKey = 'id_riwayat';
    protected $allowedFields = ['id_riwayat', 'id_rm', 'keluhan', 'diagnosa', 'obat', 'biaya', 'keterangan', 'nama_pemeriksa'];
    protected $useTimestamps = true;

    public function ambilPasienHariIni()
    {
        $today = date('Y-m-d'); // Ambil tanggal hari ini
        $startOfDay = $today . ' 00:00:00';
        $endOfDay = $today . ' 23:59:59';
        $count = $this->select('riwayat_medis.*, rekam_medis.nama, rekam_medis.tanggal_lahir')
            ->join('rekam_medis', 'rekam_medis.id_rm = riwayat_medis.id_rm')
            ->where('riwayat_medis.created_at >=', $startOfDay)
            ->where('riwayat_medis.created_at <=', $endOfDay)
            ->countAllResults();
        return $count;
    }

    public function getKunjunganHariIni()
    {
        $today = date('Y-m-d');
        $startOfDay = $today . ' 00:00:00';
        $endOfDay = $today . ' 23:59:59';

        return $this->select('riwayat_medis.*, rekam_medis.nama, rekam_medis.tanggal_lahir')
            ->join('rekam_medis', 'rekam_medis.id_rm = riwayat_medis.id_rm')
            ->where('riwayat_medis.created_at >=', $startOfDay)
            ->where('riwayat_medis.created_at <=', $endOfDay)
            ->findAll();
    }

    public function hitungJumlahPasienBPJS()
    {
        $today = date('Y-m-d'); // Ambil tanggal hari ini

        // Hitung pasien yang memiliki nomor BPJS
        $countBPJS = $this->db->table('riwayat_medis')
            ->join('rekam_medis', 'rekam_medis.id_rm = riwayat_medis.id_rm')
            ->where('riwayat_medis.created_at >=', $today . ' 00:00:00')
            ->where('riwayat_medis.created_at <=', $today . ' 23:59:59')
            ->where('rekam_medis.no_bpjs !=', 0)
            ->countAllResults();

        // Hitung total pasien yang ada
        $countTotal = $this->db->table('riwayat_medis')
            ->join('rekam_medis', 'rekam_medis.id_rm = riwayat_medis.id_rm')
            ->where('riwayat_medis.created_at >=', $today . ' 00:00:00')
            ->where('riwayat_medis.created_at <=', $today . ' 23:59:59')
            ->countAllResults();

        // Hitung pasien yang tidak memiliki nomor BPJS
        $countNonBPJS = $countTotal - $countBPJS;

        return [
            'jumlah_bpjs' => $countBPJS,
            'jumlah_non_bpjs' => $countNonBPJS,
            'jumlah_total' => $countTotal,
        ];
    }
}
