<?php

namespace App\Models;

use CodeIgniter\Model;

class m_produk extends Model
{
    protected $table            = 'tb_produk_212412_';
    protected $primaryKey       = '212412_id'; //untuk bisa hapus maka pasang primarykey
    protected $allowedFields    = ['212412_no_produk', '212412_nama_produk', '212412_id_vendor', '212412_harga', '212412_stok', '212412_kategori'];

    public function allData($id = null)
    {
        $builder = $this->builder($this->table)
            ->select('tb_produk_212412_.212412_id as produk_id,212412_kategori as kategori, 212412_no_produk as no_produk, 212412_nama_produk as produk, 212412_id_vendor as vendor, 212412_harga as harga   , 212412_stok as stok, 212412_nama_vendor as namavendor')
            ->join('tb_vendor_212412_ AS vendor', 'vendor.212412_id = tb_produk_212412_.212412_id_vendor');
        if (empty($id)) {
            return $builder->get()->getResultArray(); // tampilkan semua data
        } else {
            // tampilkan data sesuai id/barcode
            return $builder->where('tb_produk_212412_.212412_id', $id)->orWhere('212412_no_produk', $id)->get(1)->getRow();
        }
        // ->Get()->getResultArray();

    }
    public function Detail()
    {
        $builder = $this->builder($this->table)
            ->select('tb_produk_212412_.212412_id as produk_id, 212412_no_produk as no_produk, 212412_nama_produk as produk,212412_harga as harga, 212412_stok as stok,212412_kategori as kategori');

        return $builder->get()->getResultObject(); // tampilkan semua data

    }
    public function barcodeModel($keyword)
    {
        return $this->builder($this->table)->select('212412_no_produk, 212412_nama_produk')
            ->like('212412_no_produk', $keyword)
            ->orLike('212412_nama_produk', $keyword)
            ->get()->getResult();
    }
    public function cekStokProduk($barcode)
    {
        return $this->builder('tb_produk_212412_')->select('212412_stok as stok')->where('212412_no_produk', $barcode)->get()->getRow();
    }


    public function getUser($iduser = false)
    {
        if ($iduser == false) {
            return $this->findAll();
        }
        return $this->select->where(['212412_id' => $iduser])->first();
    }
    public function insertData($data)
    {
        $builder = $this->db->table('tb_produk_212412_');
        $builder->insert($data);
    }
    public function ResultProduk()
    {
        return $this->db->table('tb_produk_212412_')
            ->countAllResults();
    }
    public function AllVendor()
    {
        return $this->db->table('tb_vendor_212412_')
            ->Get()->getResultArray();
    }

    public function hapusData($id)
    {
        return $this->db->table($this->table)->delete($id);
    }
}
