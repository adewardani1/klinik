<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamModel extends Model
{
    protected $table      = 'rekam_medis';
    protected $primaryKey = 'id_rm';
    protected $allowedFields = ['nama', 'alamat', 'id_rm', 'no_rm', 'no_bpjs',];
}
