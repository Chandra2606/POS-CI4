<?php

namespace App\Models;

use CodeIgniter\Model;

class Mbarang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'kdbrg';
    protected $allowedFields = ['kdbrg', 'namabrg', 'satuanbrg', 'hargabrg', 'stokbrg'];
    public function cariData($cari)
    {
        return $this->table('barang')->like('namabrg', $cari);
    }
}