<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'kdplg';
    protected $allowedFields = ['kdplg', 'namaplg', 'alamatplg', 'notlp'];
    public function cariData($cari)
    {
        return $this->table('pelanggan')->like('namaplg', $cari);
    }
}
