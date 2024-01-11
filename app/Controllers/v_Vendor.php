<?php

namespace App\Controllers;

use App\Models\m_vendor;
use Irsyadulibad\DataTables\DataTables;

class v_Vendor extends BaseController
{
    protected $m_vendor;
    public $rules = [
        'nama' => [
            'rules' => 'required|min_length[3]',
        ],
        'telp' => [
            'rules' => 'required|numeric|min_length[11]',
        ],
        'alamat' => [
            'rules' => 'required',
        ]
    ];
    public function __construct()
    {
        $this->m_vendor = new m_vendor();
    }
    public function index()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Vendor',

        ];
        return view('V_vendor/index', $data);
    }
    public function ajax()
    {
        if ($this->request->isAJAX()) {
            return DataTables::use('tb_vendor_212412_')
                ->select('212412_id as id, 212412_nama_vendor as nama, 212412_telp_vendor as telp, 212412_alamat_vendor as alamat, 212412_keterangan as keterangan ')
                ->make();
        }
    }
    public function create()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Data Vendor',

        ];
        return view('v_vendor/create', $data);
    }
    public function save()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }

        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $this->m_vendor->save([
            '212412_nama_vendor'     => $this->request->getVar('nama'),
            '212412_telp_vendor'     => $this->request->getVar('telp'),
            '212412_alamat_vendor'   => $this->request->getVar('alamat'),
            '212412_keterangan'      => $this->request->getVar('keterangan'),
        ]);
        return redirect()->to('/v_vendor')->with('pesan', 'Data Berhasil Ditambahkan.');
    }
    public function change($idvendor)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Edit Data Vendor',
            'dataVendor' => $this->m_vendor->find($idvendor),
        ];
        return view('v_vendor/change', $data);
    }
    public function update($idvendor)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $this->m_vendor->save([
            '212412_id' => $idvendor,
            '212412_nama_vendor' => $this->request->getVar('nama'),
            '212412_telp_vendor' => $this->request->getVar('telp'),
            '212412_alamat_vendor' => $this->request->getVar('alamat'),
            '212412_keterangan' => $this->request->getVar('keterangan'),
        ]);
        return redirect()->to('/v_vendor')->with('pesan', 'Data Berhasil Diubah.');
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);
            $role = session()->get('level');
            if ($this->m_vendor->find($id) && $role == 'Admin') {
                $this->m_vendor->delete($id);
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
