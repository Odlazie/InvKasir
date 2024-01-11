<?php

namespace App\Controllers;

use App\Models\m_pengguna;
use Irsyadulibad\DataTables\DataTables;

class Pengguna extends BaseController
{
    protected $m_pengguna;
    private $rules = [
        'nama'     => ['rules' => 'required'],
        'username' => ['rules' => 'required|alpha_numeric|is_unique[tb_users_212412_.212412_username,212412_id,{id}]'],
        'password' => ['rules' => 'required|alpha_numeric|min_length[8]'],
        'alamat' => ['rules' => 'required'],
        'level'     => ['rules' => 'required']
    ];
    public function __construct()
    {
        $this->m_pengguna =  new m_pengguna();
    }
    public function index()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Pengguna',
        ];
        return view('pengguna/index', $data);
    }
    public function ajax()
    {
        if ($this->request->isAJAX()) {
            return DataTables::use('tb_users_212412_')
                ->select('212412_id as id, 212412_username as username, 212412_nama as nama, 212412_alamat as alamat, 212412_level as level ')
                ->make();
        }
    }
    public function create()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Data Pengguna'
        ];
        return view('pengguna/create', $data);
    }
    public function save()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $this->m_pengguna->save([
            '212412_username' => $this->request->getVar('212412_username'),
            '212412_nama' => $this->request->getVar('212412_nama'),
            '212412_alamat' => $this->request->getVar('212412_alamat'),
            '212412_password' => $this->request->getVar('212412_password'),
            '212412_level' => $this->request->getVar('212412_level'),
        ]);
        return redirect()->to('/pengguna')->with('pesan', 'Data Berhasil Ditambahkan');
    }
    public function change($iduser)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Edit Data Pengguna',
            'dataUsers' => $this->m_pengguna->getUsers($iduser)
        ];
        return view('pengguna/change', $data);
    }
    public function update($iduser)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $this->m_pengguna->save([
            '212412_id' => $iduser,
            '212412_username' => $this->request->getVar('username'),
            '212412_nama' => $this->request->getVar('nama'),
            '212412_alamat' => $this->request->getVar('alamat'),
            '212412_password' => $this->request->getVar('password'),
            '212412_level' => $this->request->getVar('level'),
        ]);
        return redirect()->to('/pengguna')->with('pesan', 'Data Behasil Diubah');
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);
            $role = session()->get('level');
            if ($this->m_pengguna->find($id) && $role == 'Admin') {
                $this->m_pengguna->delete($id);
                $respon = [
                    'status' => true,
                    'pesan' => 'Data berhasil dihapus :)'
                ];
            } else {
                $respon = [
                    'status' => false,
                    'pesan' => 'Gagal menghapus data'
                ];
            }
            return $this->response->setJSON($respon);
        }
    }
}
