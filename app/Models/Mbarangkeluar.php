<?php

namespace App\Models;

use CodeIgniter\Model;

class Mbarangkeluar extends Model
{
    protected $table = 'barangkeluar';
    protected $primaryKey = 'nofakkeluar';
    protected $allowedFields = [
        'nofakkeluar',
        'tglkeluar',
        'keluarkdplg'
    ];
    public function cariData($cari)
    {
        return $this->table('barangkeluar')->join('detailkeluar', 'detailnofak=nofakkeluar')->join('barang', 'detailkdbrg=kdbrg')->join('pemasok', 'keluarkdpem=kdpem')->orlike('nofakkeluar', $cari)->orlike('namabrg', $cari);
    }
}
