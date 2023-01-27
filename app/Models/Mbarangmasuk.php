<?php

namespace App\Models;

use CodeIgniter\Model;

class Mbarangmasuk extends Model
{
    protected $table = 'barangmasuk';
    protected $primaryKey = 'nofakmasuk';
    protected $allowedFields = [
        'nofakmasuk',
        'tglmasuk',
        'masukkdpem'
    ];
    public function cariData($cari)
    {
        return $this->table('barangmasuk')->join('detailmasuk', 'detailnofak=nofakmasuk')->join('barang', 'detailkdbrg=kdbrg')->join('pemasok', 'masukkdpem=kdpem')->orlike('nofakmasuk', $cari)->orlike('namabrg', $cari);
    }
}
