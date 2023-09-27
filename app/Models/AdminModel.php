<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table      = 'petugas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'hak_akses', 'nama'];

    public function getPemeriksa()
    {
        // Mengambil data petugas dengan hak_akses 'pemeriksa'
        return $this->where('hak_akses', 'pemeriksa')->findAll();
    }
}
