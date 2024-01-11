<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">
</head>

<body onload="print()">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col text-center">
                <h1>Tokoh AKu</h1>
                <h2> Laporan Penjualan Periode</h2>
                <h3><?= $mulai; ?> Sampai Dengan <?= $akhir; ?></h3>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class=" table-responsive-md">
                    <table id="table-laporan" class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" width="5%">No</th>
                                <th scope="col" width="22%">Tanggal</th>
                                <th scope="col" width="21%">Produk</th>
                                <th scope="col" width="15%">Jumlah Pembelian</th>
                                <th scope="col">Harga Produk</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $totalHasil = 0;
                            $groupedData = array();
                            $calculatedTotal = array(); // Menyimpan total_akhir yang sudah dihitung

                            foreach ($penjualan as $row) {
                                $totalAkhir = $row['212412_total_akhir'];

                                if (!isset($groupedData[$totalAkhir])) {
                                    $groupedData[$totalAkhir] = array();
                                }

                                // Cek apakah total_akhir sudah dihitung sebelumnya
                                if (!isset($calculatedTotal[$totalAkhir])) {
                                    $calculatedTotal[$totalAkhir] = true; // Tandai bahwa total_akhir sudah dihitung
                                    $totalHasil += $totalAkhir;
                                }

                                $groupedData[$totalAkhir][] = $row;
                            }


                            foreach ($groupedData as $totalAkhir => $rows) {
                                $rowSpan = count($rows); // Menentukan nilai rowSpan untuk setiap total_akhir
                                $firstRow = true;

                                foreach ($rows as $row) :
                                    // dd($row);
                            ?>
                                    <tr>
                                        <?php
                                        if ($firstRow) {
                                        ?>
                                            <th scope="row" rowspan="<?= $rowSpan; ?>" class="text-center align-middle"><?= esc($no++); ?></th>
                                            <td rowspan="<?= $rowSpan; ?>" class="text-center align-middle"><?= esc($row['tanggal']); ?></td>
                                            <td class="text-center"><?= esc($row['produk']); ?></td>
                                            <td class="text-center"><?= esc($row['item']); ?></td>
                                            <td class="text-center">Rp <?= esc(rupiah($row['hargaProduk'])); ?></td>
                                            <td rowspan="<?= $rowSpan; ?>" class="text-sm-right align-middle">Rp <?= esc(rupiah($row['212412_total_akhir'])); ?></td>
                                        <?php
                                            $firstRow = false;
                                        } else {
                                        ?>
                                            <td class="text-center"><?= esc($row['produk']); ?></td>
                                            <td class="text-center"><?= esc($row['item']); ?></td>
                                            <td class="text-center">Rp <?= esc(rupiah($row['hargaProduk'])); ?></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                            <?php
                                endforeach;
                            }
                            ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total:</th>
                                <td class="text-right">Rp <?= esc(rupiah($totalHasil)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>