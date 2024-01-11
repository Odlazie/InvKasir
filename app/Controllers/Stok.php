<?php

namespace App\Controllers;

use App\Models\m_produk;


class Stok extends BaseController
{
    protected $m_produk;
    private $rules = [
        'stok' => ['rules' => 'required|numeric'],
    ];
    public function __construct()
    {
        $this->m_produk = new m_produk();
    }
    public function index()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Stok',
        ];
        return view('stok/index', $data);
    }
    public function change($idproduk)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Edit Stok',
            'dataProduk' => $this->m_produk->find($idproduk),
        ];
        return view('stok/change', $data);
    }
    public function update($idproduk)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $this->m_produk->update($idproduk, [
            '212412_no_produk' => $this->request->getVar('no_produk'),
            '212412_nama_produk' => $this->request->getVar('nama_produk'),
            '212412_stok' => str_replace('.', '', $this->request->getVar('stok')),
        ]);
        return redirect()->to('/stok')->with('pesan', 'Data Berhasil Diubah.');
    }
}
