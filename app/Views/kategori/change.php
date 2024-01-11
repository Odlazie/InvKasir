<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h3>Edit Data <?= $title; ?></h3>
            <a href="/kategori">Kembali</a>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" id="nama" name="nama-vendor" class="form-control form-control-border border-width-2 col-md-10" placeholder="Makanan" disabled required autofocus>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>