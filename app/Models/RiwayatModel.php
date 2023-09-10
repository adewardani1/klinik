<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatModel extends Model
{
    protected $table      = 'riwayat_medis';
    protected $primaryKey = 'id_riwayat';
    protected $allowedFields = ['id_riwayat', 'id_rm', 'keluhan', 'diagnosa', 'id_obat', 'biaya', 'keterangan'];
    protected $useTimestamps = true;

    public function ambilPasienHariIni()
    {
        $today = date('Y-m-d'); // Ambil tanggal hari ini
        $count = $this->where('created_at', $today)->countAllResults(); // Ganti 'created_at' dengan kolom yang sesuai
        return $count;
    }

    public function hitungJumlahPasienBPJS()
    {
        $today = date('Y-m-d'); // Ambil tanggal hari ini

        // Hitung pasien yang memiliki nomor BPJS
        $countBPJS = $this->db->table('riwayat_medis')
            ->join('rekam_medis', 'rekam_medis.id_rm = riwayat_medis.id_rm')
            ->where('riwayat_medis.created_at >=', $today . ' 00:00:00')
            ->where('riwayat_medis.created_at <=', $today . ' 23:59:59')
            ->where('rekam_medis.no_bpjs IS NOT NULL')
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
