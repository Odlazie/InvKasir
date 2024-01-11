<?php

namespace App\Models;

use CodeIgniter\Model;

class m_login extends Model
{
    protected $table            = 'tb_users_212412_';
    protected $primaryKey       = '212412_id';
    protected $allowedFields    = ['212412_nama'];

    function auth_admin($username, $password)
    {
        return $this->db->table('tb_users_212412_')->where([
            '212412_username' => $username,
            '212412_password' => $password
        ])->get()->getRowArray();
    }
}
