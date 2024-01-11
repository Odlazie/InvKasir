<?php

namespace App\Models;

use CodeIgniter\Model;

class m_pengguna extends Model
{
    protected $table            = 'tb_users_212412_';
    protected $primaryKey       = '212412_id'; //untuk bisa hapus maka pasang primarykey
    protected $allowedFields    = ['212412_username', '212412_nama', '212412_password', '212412_alamat', '212412_level'];

    public function getUsers($iduser = false)
    {
        if ($iduser == false) {
            return $this->findAll();
        }
        return $this->where(['212412_id' => $iduser])->first();
    }
    public function getPengguna($kolom = null)
    {
        if (empty($kolom)) {
            return $this->findAll();
        }
        return $this->builder($this->table)->where('212412_id', $kolom)->orWhere('212412_username', $kolom)->get(1)->getRow();
    }
    // public function getAdmin($kolom = null)
    // {
    //     if (empty($kolom)) {
    //         return $this->findAll();
    //     }
    //     return $this->builder($this->table)->where('212412_id', $kolom)->orWhere('212412_username', $kolom)->get(1)->getRow();
    // }
}
