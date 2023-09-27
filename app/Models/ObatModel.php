<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table      = 'stok_obat';
    protected $primaryKey = 'id_obat';
    protected $allowedFields = ['id_rm', 'nama_obat', 'stok', 'jenis_obat'];

    public function getNamaObatById($id_obat)
    {
        return $this->select('nama_obat')->find($id_obat);
    }
}
