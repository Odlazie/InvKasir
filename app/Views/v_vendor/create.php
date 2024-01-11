<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h3>Data Vendor</h3>
            <a href="/v_vendor">Kembali</a>
            <div class="card">
                <div class="card-body">
                    <h5>Form Tambah Data Vendor</h5>
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="card-body col-md-5">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fas fa-ban"></i>Data Vendor</h6>
                                <?= session()->getFlashdata('errors'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form action="/v_vendor/save" method="post">
                        <?= csrf_field(); ?>
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Vendor</label>
                                    <input type="text" id="nama" name="nama" class="form-control form-control-border border-width-2 col-md-10 " placeholder="Nama Vendor" autofocus value="<?= old('nama') ?>">

                                </div>
                                <div class="form-group">
                                    <label>No Telphone</label>
                                    <input type="text" id="nope" name="telp" class="form-control form-control-border border-width-2 col-md-10  " placeholder="No Telphone" autofocus value="<?= old('telp') ?>">

                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control form-control-border border-width-2 col-md-10" placeholder="Alamat" autofocus value="<?= old('alamat') ?>">

                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" id="keteragan" name="keterangan" class="form-control form-control-border border-width-2 col-md-10" placeholder="Keterangan" autofocus value="<?= old('keterangan') ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block col-md-3 m-3">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>