<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table      = 'obat';
    protected $primaryKey = 'id_obat';
    protected $allowedFields = ['id_rm', 'nama_obat', 'stok', 'jenis_obat'];
}
