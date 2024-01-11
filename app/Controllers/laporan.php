<?php

namespace App\Controllers;

use App\Models\m_penjualan;
use App\Models\m_produk;
use Dompdf\Dompdf;
use Dompdf\Options;

class laporan extends BaseController
{
    protected $m_penjualan;
    protected $m_produk;
    public function __construct()
    {
        $this->m_penjualan = new m_penjualan();
        $this->m_produk = new m_produk();
    }
    public function index()
    {
        $data = [
            'title' => 'Laporan'
        ];
        return view('laporan/index', $data);
    }

    public function printLaporanPDF()
    {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        $data = [
            'mulai' => $startDate,
            'akhir' => $endDate,
            'title' => $startDate . ' s/d ' . $endDate,
            'penjualan' => $this->m_penjualan->getLaporanPenjualan($startDate, $endDate)
        ];
        return view('laporan/pdflaporan', $data);
    }
}
