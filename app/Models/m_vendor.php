<?php

namespace App\Models;

use CodeIgniter\Model;

class m_vendor extends Model
{
    protected $table            = 'tb_vendor_212412_';
    protected $primaryKey       = '212412_id'; //untuk bisa hapus maka pasang primarykey
    protected $allowedFields    = ['212412_nama_vendor', '212412_telp_vendor', '212412_alamat_vendor', '212412_keterangan'];




    public function getVendor($idvendor = false)
    {
        if ($idvendor == false) {
            return $this->findAll();
        }
        return $this->where(['212412_id' => $idvendor])->first();
    }
}
