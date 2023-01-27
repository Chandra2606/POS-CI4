<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpemasok extends Model
{
    protected $table = 'pemasok';
    protected $primaryKey = 'kdpem';
    protected $allowedFields = ['kdpem', 'namapem', 'alamatpem', 'notlp'];
    public function cariData($cari)
    {
        return $this->table('pemasok')->like('namapem', $cari);
    }
}
