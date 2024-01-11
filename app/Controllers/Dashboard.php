<?php

namespace App\Controllers;

use App\Models\m_pengguna;
use App\Models\m_penjualan;
use App\Models\m_produk;
use App\Models\m_transaksi;
use App\Models\m_vendor;

class Dashboard extends BaseController
{
    protected $m_vendor;
    protected $m_pengguna;
    protected $m_produk;
    protected $m_transaksi;
    protected $m_penjualan;
    public function __construct()
    {
        $this->m_vendor = new m_vendor();
        $this->m_pengguna = new m_pengguna();
        $this->m_produk = new m_produk();
        $this->m_transaksi = new m_transaksi();
        $this->m_penjualan = new m_penjualan();
    }
    public function index()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        helper('fungsi');
        $data = [
            'title' => 'Dashboard',
            'vendor' => $this->m_vendor->countAllResults(),
            'users' => $this->m_pengguna->countAllResults(),
            'produk' => $this->m_produk->ResultProduk(),
            'transaksi' => $this->m_transaksi->countAllResults(),

        ];
        echo view('Dashboard/index', $data);
    }
    public function laporan()
    {
        $data = $this->m_penjualan->laporanPenjualan(date('Y'));
        return $this->response->setJSON($data);
    }
}
