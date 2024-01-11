<?php

namespace App\Controllers;


use App\Models\m_produk;
use Irsyadulibad\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Produk extends BaseController
{
    protected $m_produk;
    private $rules = [
        'no_produk' => ['rules' => 'required|alpha_numeric|is_unique[tb_produk_212412_.212412_no_produk,212412_id,{id}]|min_length[3]'],
        'nama_produk' => ['rules' => 'required|min_length[5]'],
        'harga' => ['rules' => 'required|numeric'],
        'stok' => ['rules' => 'required|numeric'],
        'kategori' => ['rules' => 'required'],
        'id_vendor' => ['rules' => 'required'],
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
            'title' => 'Produk',
        ];
        return view('produk/index', $data);
    }
    public function ajax()
    {
        if ($this->request->isAJAX()) {
            return DataTables::use('tb_produk_212412_')
                ->select('tb_produk_212412_.212412_id as produk_id, 212412_kategori as kategori, 212412_no_produk as no_produk, 212412_nama_produk as produk, 212412_id_vendor as vendor, 212412_harga as harga, 212412_stok as stok, 212412_nama_vendor as namavendor')
                ->join('tb_vendor_212412_ AS vendor', 'vendor.212412_id = tb_produk_212412_.212412_id_vendor')
                ->make();
        }
    }
    public function detail()
    {
        $barcode = $this->request->getGet('barcode', FILTER_SANITIZE_SPECIAL_CHARS);
        $data    = $this->m_produk->allData($barcode);
        if (!empty($data)) {
            return $this->response->setJSON($data);
        }
    }
    public function barcode()
    {
        $keyword = $this->request->getGet('term', FILTER_SANITIZE_SPECIAL_CHARS);
        $data    = $this->m_produk->barcodeModel($keyword);

        $barcode = [];
        foreach ($data as $item) {
            array_push($barcode, [
                'label' => "{$item->{'212412_no_produk'}} - {$item->{'212412_nama_produk'}}",
                'value' => $item->{'212412_no_produk'},
            ]);
        }

        return $this->response->setJSON($barcode);
    }
    public function cekStok()
    {
        $barcode = $this->request->getGet('barcode');
        $respon  = $this->m_produk->cekStokProduk($barcode);

        return $this->response->setJSON($respon);
    }

    public function create()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Data Produk',
            'vendor' => $this->m_produk->AllVendor()

        ];
        return view('produk/create', $data);
    }
    public function save()
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $data = [
            '212412_no_produk' => $this->request->getVar('no_produk'),
            '212412_nama_produk' => $this->request->getVar('nama_produk'),
            '212412_id_vendor' => $this->request->getVar('id_vendor'),
            '212412_harga' => str_replace('.', '', $this->request->getVar('harga')),
            '212412_stok' => str_replace('.', '', $this->request->getVar('stok')),
            '212412_kategori' => $this->request->getVar('kategori'),
        ];
        $this->m_produk->insertData($data);
        return redirect()->to('/produk');
    }

    public function change($idproduk)
    {
        if (session()->get('log') != TRUE) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Edit Data Produk',
            'dataProduk' => $this->m_produk->find($idproduk),
            'vendor' => $this->m_produk->AllVendor(),
        ];
        return view('produk/change', $data);
    }
    public function update($idproduk)
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
        $this->m_produk->update($idproduk, [
            '212412_no_produk' => $this->request->getVar('no_produk'),
            '212412_nama_produk' => $this->request->getVar('nama_produk'),
            '212412_id_vendor' => $this->request->getVar('id_vendor'),
            '212412_harga' => str_replace('.', '', $this->request->getVar('harga')),
            '212412_stok' => str_replace('.', '', $this->request->getVar('stok')),
            '212412_kategori' => $this->request->getVar('kategori'),

        ]);
        return redirect()->to('/produk')->with('pesan', 'Data berhasil diubah');
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);
            $role = session()->get('level');
            if ($this->m_produk->find($id) && $role == 'Admin') {
                $this->m_produk->delete($id);
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
    public function download()
    {
        // Instansiasi Spreadsheet
        $spreadsheet = new Spreadsheet();
        // styling
        $style = [
            'font'      => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($style); // tambahkan style
        $spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(30); // setting tinggi baris
        // setting lebar kolom otomatis
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        // set kolom head
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'No. Produk')
            ->setCellValue('C1', 'Nama Produk')
            ->setCellValue('D1', 'Kategori')
            ->setCellValue('E1', 'Harga')
            ->setCellValue('F1', 'Stok');
        $row = 2;
        // looping data item
        foreach ($this->m_produk->Detail() as $key => $data) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $data->no_produk)
                ->setCellValue('C' . $row, $data->produk)
                ->setCellValue('D' . $row, $data->kategori)
                ->setCellValue('E' . $row, $data->harga)
                ->setCellValue('F' . $row, $data->stok);
            $row++;
        }
        // tulis dalam format .xlsx
        $writer   = new Xlsx($spreadsheet);
        $namaFile = 'Daftar_Stok_Produk_' . date('d-m-Y');
        // Redirect hasil generate xlsx ke web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $namaFile . '.xlsx');
        $writer->save('php://output');
        exit;
    }
}
