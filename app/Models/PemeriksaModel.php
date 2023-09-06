<?php

namespace App\Models;

use CodeIgniter\Model;

class PemeriksaModel extends Model
{
    protected $table      = 'pemeriksa';
    protected $primaryKey = 'id_pemeriksa';
    protected $allowedFields = ['username', 'password', 'hak_akses'];
}
