<?php

namespace App\Controllers;

use App\Libraries\Keranjang;
use App\Models\m_penjualan;
use App\Models\m_transaksi;
use Irsyadulibad\DataTables\DataTables;

class Penjualan extends BaseController
{
    protected $m_penjualan;
    protected $m_transaksi;
    public function __construct()
    {
        $this->m_penjualan = new m_penjualan();
        $this->m_transaksi = new m_transaksi();
        helper('form');
    }
    public function index(): string
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Penjualan'
        ];
        return view('penjualan/index', $data);
    }
    public function keranjang()
    {
        if ($this->request->isAJAX()) {
            $respon = [
                'invoice'   => $this->m_penjualan->invoice(),
                'keranjang' => Keranjang::keranjang(),
                'sub_total' => Keranjang::sub_total(),

            ];

            return $this->response->setJSON($respon);
        }
    }
    public function struk(): string
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Struk'
        ];
        return view('penjualan/struk', $data);
    }
    public function tambah()
    {
        if ($this->request->getMethod() == 'post') {
            $id   = $this->request->getPost('iditem', FILTER_SANITIZE_NUMBER_INT);
            $item = [
                'id'      => $id,
                'barcode' => $this->request->getPost('barcode', FILTER_SANITIZE_STRING),
                'nama'    => $this->request->getPost('nama', FILTER_SANITIZE_STRING),
                'harga'   => $this->request->getPost('harga', FILTER_SANITIZE_NUMBER_INT),
                'jumlah'  => $this->request->getPost('jumlah', FILTER_SANITIZE_NUMBER_INT),
                'stok'    => $this->request->getPost('stok', FILTER_SANITIZE_NUMBER_INT),
            ];
            $hasil = Keranjang::tambah($id, $item); // masukan item ke keranjang
            if ($hasil == 'error') {
                $respon = [
                    'status' => false,
                    'pesan'  => 'Item yang ditambahkan melebihi stok',
                ];
            } else {
                $respon = [
                    'status' => true,
                    'pesan'  => 'Item berhasil ditambahkan ke keranjang.',
                ];
            }

            return $this->response->setJSON($respon);
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $iditem = $this->request->getPost('iditem', FILTER_SANITIZE_NUMBER_INT);
            if (empty($iditem)) {
                // hapus session keranjang
                session()->remove('keranjang');
                $respon = [
                    'status' => true,
                    'pesan'  => 'Transaksi berhasil dibatalkan.',
                ];
            } else {
                $hapus = Keranjang::hapus($iditem);
                if ($hapus) {
                    $respon = [
                        'status' => true,
                        'pesan'  => 'Item berhasil dihapus dari keranjang.',
                    ];
                } else {
                    $respon = [
                        'status' => false,
                        'pesan'  => 'Gagal menghapus item dari keranjang',
                    ];
                }
            }

            return $this->response->setJSON($respon);
        }
    }
    public function ubah()
    {
        if ($this->request->getMethod() == 'post') {
            $id   = $this->request->getPost('item_id', FILTER_SANITIZE_NUMBER_INT);
            $item = [
                'jumlah' => $this->request->getPost('item_jumlah', FILTER_SANITIZE_NUMBER_INT),
                'diskon' => $this->request->getPost('item_diskon', FILTER_SANITIZE_NUMBER_INT),
                'total'  => $this->request->getPost('harga_setelah_diskon', FILTER_SANITIZE_NUMBER_INT),
            ];
            Keranjang::ubah($id, $item); // masukan item ke keranjang
            $respon = [
                'pesan' => 'Item berhasil diubah.',
            ];

            return $this->response->setJSON($respon);
        }
    }
    public function bayar()
    {
        if ($this->request->getMethod() == 'post') {
            // tambahkan record ke tabel penjualan
            $tunai     = $this->request->getPost('tunai', FILTER_SANITIZE_NUMBER_INT);
            $kembalian = $this->request->getPost('kembalian', FILTER_SANITIZE_NUMBER_INT);
            $data      = [
                '212412_invoice'      => $this->m_penjualan->invoice(),
                '212412_namapelanggan' => $this->request->getPost('namapelanggan'),
                '212412_total_harga'  => $this->request->getPost('subtotal', FILTER_SANITIZE_NUMBER_INT),
                '212412_diskon'       => $this->request->getPost('diskon', FILTER_SANITIZE_NUMBER_INT),
                '212412_total_akhir'  => $this->request->getPost('total_akhir', FILTER_SANITIZE_NUMBER_INT),
                '212412_tunai'        => str_replace('.', '', $tunai),
                '212412_kembalian'    => str_replace('.', '', $kembalian),
                '212412_ catatan'      => $this->request->getPost('catatan', FILTER_SANITIZE_STRING),
                '212412_tanggal'      => $this->request->getPost('tanggal', FILTER_SANITIZE_STRING),
                '212412_id_user'      => session('idweh'),
            ];

            $result = $this->m_penjualan->simpanPenjualan($data);

            if ($result['status']) {
                $respon = [
                    'status'      => $result['status'],
                    'pesan'       => 'Transaksi berhasil.',
                    'idpenjualan' => $result['id'],
                ];
            } else {
                $respon = [
                    'status' => $result['status'],
                    'pesan'  => 'Transaksi gagal',
                ];
            }

            return $this->response->setJSON($respon);
        }
    }
    public function invoice()
    {
        if ($this->request->isAJAX()) {
            return DataTables::use('tb_penjualan_212412_')
                ->select('tb_penjualan_212412_.212412_id as id, 212412_invoice as invoice, 212412_tanggal as tanggal, u.212412_nama as namakasir')
                ->join('tb_users_212412_ as u', 'u.212412_id = 212412_id_user')
                ->make();
        } else if ($this->request->getMethod() == 'get') {
            $data = [
                'title' => 'Daftar Invoice',
            ];
            echo view('penjualan/daftar_invoice', $data);
        }
    }
    public function cetak($id)
    {
        $transaksi = $this->m_transaksi->detailTransaksi($id);
        // jika id penjualan tidak ditemukan redirect ke halaman invoice dan tampilkan error
        if (empty($transaksi)) {
            return redirect()->to('/penjualan/invoice')->with('pesan', 'Invoice tidak ditemukan');
        }
        echo view('penjualan/cetak_termal', ['transaksi' => $transaksi]);
    }
}
