<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <h1 class="m-0">Periode <?= $title; ?></h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    <a href="" class="btn btn-primary mb-3"><i class="fas fa-file-pdf"></i></a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-laporan" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th>Invoice</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $totalHasil = 0;
                        foreach ($penjualan as $row) : ?>
                            <tr>
                                <th><?= $no++; ?></th>
                                <td class="text-center"><?= $row['212412_invoice']; ?></td>
                                <td class="text-right">Rp <?= esc(rupiah($row['212412_total_akhir'])); ?></td>
                            </tr>
                            <?php $totalHasil += $row['212412_total_akhir'] ?>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-center">Total Penghasilan</td>
                            <td class="text-right">Rp <?= esc(rupiah($totalHasil)); ?></td>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection();; ?>