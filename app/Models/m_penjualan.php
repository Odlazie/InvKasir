<?php

namespace App\Models;

use App\Models\m_transaksi;
use App\Models\m_produk;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;

class m_penjualan extends Model
{
    protected $table            = 'tb_penjualan_212412_';
    protected $primaryKey       = '212412_id'; //untuk bisa hapus maka pasang primarykey
    protected $allowedFields    = [
        '212412_invoice',
        '212412_namapelanggan',
        '212412_total_harga',
        '212412_diskon',
        '212412_total_akhir',
        '212412_tunai',
        '212412_kembalian',
        '212412_catatan',
        '212412_tanggal',
        '212412_id_user',
    ];


    public function invoice()
    {
        $date = date('Y-m-d');

        // Ambil invoice terakhir sesuai tanggal hari ini
        $lastInvoice = $this->builder($this->table)
            ->selectMax('212412_invoice')
            ->where('212412_tanggal', $date)
            ->get()
            ->getRow();

        // Buat format invoice baru
        if (empty($lastInvoice->{"212412_invoice"})) {
            $no = '0001';
        } else {
            $data = substr($lastInvoice->{"212412_invoice"}, -4); // Ambil 4 angka terakhir
            $angka = (int) $data + 1;
            $no = sprintf("%'.04d", $angka);
        }

        return "INV" . date('ymd') . $no;
    }

    public function getVendor($idvendor = false)
    {
        if ($idvendor == false) {
            return $this->findAll();
        }
        return $this->where(['212412_id' => $idvendor])->first();
    }
    public function simpanPenjualan(array $post)
    {
        try {
            $item = new m_produk();
            $transaksi = new m_transaksi();

            $db = \Config\Database::connect();
            $db->transException(true)->transBegin();
            $this->save($post); // simpan transaksi ke tabel penjualan
            $id_penjualan = $this->insertID; // mengambil id penjualan
            $keranjang = session('keranjang'); // menampung session keranjang
            $data = [];

            foreach ($keranjang as $val) {
                $itemTransaksi = [
                    '212412_id_penjualan'  => $id_penjualan,
                    '212412_id_produk'       => $val['id'],
                    '212412_harga_item'    => $val['harga'],
                    '212412_jumlah_item'   => $val['jumlah'],
                    '212412_diskon_item'   => $val['diskon'],
                    '212412_subtotal'      => $val['total'],
                    'created_at'    => date("Y-m-d H:i:s"),
                    'updated_at'    => date("Y-m-d H:i:s"),
                ];
                array_push($data, $itemTransaksi);

                // update stok item sesuai idnya
                $item->set('212412_stok', '212412_stok-' . $val['jumlah'], false);
                $item->where('212412_id', $val['id']);
                $item->update();
            }

            $transaksi->insertBatch($data); // tambahkan ke tabel transaksi

            if ($db->transStatus() === FALSE || $transaksi->affectedRows() === 0) {
                $db->transRollback();
                throw new \Exception($db->error()['message'] ?? 'Gagal melakukan transaksi atau data tidak berhasil dimasukkan.');
            } else {
                // kosongkan keranjang
                unset($_SESSION['keranjang']);
                return ['status' => $db->transCommit(), 'id' => $id_penjualan];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }
    public function laporanPenjualan($tahun)
    {
        return $this->builder('tb_bln_thn_212412_')
            ->select('bulan')
            ->selectCount('212412_jumlah_item', 'total')
            ->join('tb_transaksi_212412_', 'date_format(created_at, "%m-%Y") = bln_thn', 'left')
            ->where('tahun', $tahun)
            ->groupBy('bln_thn')
            ->get()
            ->getResult();
    }
    // public function penjualanByDate($startDate, $endDate)
    // {
    //     return $this->where('212412_tanggal >=', $startDate)
    //         ->where('212412_tanggal <=', $endDate)
    //         ->select('*')
    //         ->selectCount('212412_jumlah_item', 'totalItem')
    //         ->join('tb_transaksi_212412_ a', '212412_id = a.212412_id_penjualan')
    //         ->join('tb_produk_212412_ b', 'b.212412_id = 212412_id_produk')
    //         ->selectSum('tb_penjualan_212412_.212412_total_akhir', 'total')
    //         ->groupBy('212412_kategori')
    //         ->get()
    //         ->getResultArray();
    // }
    public function getLaporanPenjualan($startDate, $endDate)
    {
        return $this->select('212412_tanggal as tanggal, b.212412_nama_produk as produk, 212412_jumlah_item as item, 212412_total_akhir, 212412_harga_item as hargaProduk')
            ->join('tb_transaksi_212412_ a', '212412_id = a.212412_id_penjualan', 'left')
            ->join('tb_produk_212412_ b', 'b.212412_id = 212412_id_produk', 'left')
            ->where('tb_penjualan_212412_.212412_tanggal >=', $startDate)
            ->where('tb_penjualan_212412_.212412_tanggal <=', $endDate)
            ->get()->getResultArray();
    }
}
