<?php

namespace App\Controllers;

use App\Models\m_login;

class login extends BaseController
{
    protected $m_login;
    private $rules = [
        'username' => ['rules' => 'required'],
        'password' => ['rules' => 'required']
    ];
    public function __construct()
    {
        $this->m_login = new m_login();
    }

    public function index()
    {
        return view('login/index');
    }
    public function log()
    {
        $username     = $this->request->getPost('212412_username');
        $password     = $this->request->getPost('212412_password');

        $cek_admin    = $this->m_login->auth_admin($username, $password,);
        if ($cek_admin) {
            session()->set([
                'log' => true,
                'idweh' => $cek_admin['212412_id'],
                'nama' => $cek_admin['212412_nama'],
                'level' => $cek_admin['212412_level'],
                'username' => $cek_admin['212412_username'],
                'password' => $cek_admin['212412_password'],
            ]);
            session()->setFlashdata('pesan', 'Selamat Datang, ' . $username);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('gagal', 'Login Gagal');
            session()->setFlashdata('salah', 'Username atau Password salah ');
            return redirect()->to('/login');
        }
    }
    public function logout()
    {
        session()->remove(['log', 'username', 'password']);
        return redirect()->to('/login');
    }
}
