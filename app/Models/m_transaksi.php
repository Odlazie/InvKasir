<?php

namespace App\Models;

use CodeIgniter\Model;

class m_transaksi extends Model
{
    protected $table      = 'tb_transaksi_212412_';
    protected $primaryKey = '212412_id_transaksi';

    protected $allowedFields = [
        '212412_id_penjualan',
        '212412_id_produk',
        '212412_harga_item',
        '212412_jumlah_item',
        '212412_diskon_item',
        '212412_subtotal',
    ];


    protected $useTimestamps = true;

    public function detailTransaksi($id = null)
    {
        if ($id) {
            return $this->builder($this->table)
                ->select('212412_harga_item AS harga, 212412_jumlah_item AS jumlah, 212412_diskon_item as diskon_item, 212412_subtotal as subtotal, p.212412_invoice as invoice, p.212412_total_harga as total_harga, p.212412_diskon as diskon, p.212412_total_akhir as total_akhir, p.212412_tunai as tunai, p.212412_kembalian as kembalian, p.212412_catatan as catatan, p.212412_namapelanggan as pelanggan,  i.212412_nama_produk AS item, u.212412_nama AS kasir, p.212412_tanggal as tanggal')
                ->join('tb_penjualan_212412_ p', 'p.212412_id = 212412_id_penjualan')
                ->join('tb_produk_212412_ i', 'i.212412_id = 212412_id_produk')
                ->join('tb_users_212412_ u', 'u.212412_id = 212412_id_user')
                ->where('212412_id_penjualan', $id, true)
                ->get()->getResultArray();
        }
    }
}
