<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Buat Laporan</h1>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-6">
                <div class="card-body">
                    <form action="/laporan/printLaporanPDF" method="post">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" formtarget="_blank" class="btn btn-primary">Buat Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>