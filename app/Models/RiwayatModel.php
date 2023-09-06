<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatModel extends Model
{
    protected $table      = 'riwayat_medis';
    protected $primaryKey = 'id_riwayat';
    protected $allowedFields = ['id_riwayat', 'id_rm', 'keluhan', 'diagnosa', 'obat', 'biaya'];
    protected $useTimestamps = true;
}
