<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h3>Data Kategori</h3>
            <a href="/kategori">Kembali</a>
            <div class="card">
                <div class="card-body">
                    <h5>Form Tambah Data Kategori</h5>
                    <form action="/kategori/save" method="post">
                        <?= csrf_field(); ?>
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input type="text" id="nama" name="nama-kategori" class="form-control form-control-border border-width-2 col-md-10" placeholder="Nama" required autofocus>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block col-md-4">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>