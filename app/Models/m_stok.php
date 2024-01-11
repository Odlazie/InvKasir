<?php

namespace App\Models;

use CodeIgniter\Model;

class m_stok extends Model
{

    public function allData()
    {
        return $this->db->table('tb_stok_212412_')
            ->join('tb_produk_212412_', 'tb_produk_212412_.212412_id=tb_stok_212412_.212412_id_produk', 'left')
            ->join('tb_vendor_212412_', 'tb_vendor_212412_.212412_id=tb_stok_212412_.212412_id_vendor', 'left')
            ->Get()->getResultArray();
    }
    // public function insertData($no_produk, $nama_produk, $id_vendor, $harga, $stok, $kategori)
    // {
    //     $sql = "INSERT INTO tb_produk_212412_(212412_no_produk,212412_nama_produk,212412_id_vendor,212412_harga,212412_stok,212412_kategori)VALUES('$no_produk', '$nama_produk', '$id_vendor', '$harga', '$stok', '$kategori')";
    //     $query = $this->db->query($sql);
    //     return $query;
    // }
    public function insertData($data)
    {
        $builder = $this->db->table('tb_stok_212412_');
        $builder->insert($data);
    }
    public function AllVendor()
    {
        return $this->db->table('tb_vendor_212412_')
            ->Get()->getResultArray();
    }
    public function AllProduk()
    {
        return $this->db->table('tb_produk_212412_')
            ->Get()->getResultArray();
    }
}
