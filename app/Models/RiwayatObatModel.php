<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatObatModel extends Model
{
    protected $table      = 'obat';
    protected $allowedFields = ['id_pelayanan', 'id_obat', 'jumlah_obat'];

    public function saveObat($dataObat, $id_pelayanan)
    {
        // Cek apakah data sudah ada untuk id_pelayanan berdasarkan $id_pelayanan
        $existingData = $this->where('id_pelayanan', $id_pelayanan)
            ->where('id_obat', $dataObat['id_obat'])
            ->first();

        if ($existingData) {
            //hapus semua data yang lama berdsarkan id pelayanan
            $this->where('id_pelayanan', $id_pelayanan)->delete();
            // Kemudian lakukan insert untuk menggantinya dengan data yang baru
            $this->insert($dataObat);
        } else {
            // Jika data belum ada, lakukan insert
            $this->insert($dataObat);
        }
    }
}
