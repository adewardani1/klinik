<?php

namespace App\Models;

use CodeIgniter\Model;

class PelayananModel extends Model
{
    protected $table      = 'pasien';
    protected $primaryKey = 'id_pelayanan';
    protected $allowedFields = ['id_rm', 'nama_pasien', 'no_rm', 'check', 'biaya', 'keluhan', 'diagnosa', 'no_bpjs'];

    public function getPelayananDicoret()
    {
        // Mengambil data pelayanan yang sudah dicoret (misalnya yang memiliki status "dicoret")
        return $this->where('check', '1')->findAll();
    }
}
