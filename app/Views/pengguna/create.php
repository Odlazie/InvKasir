<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h3>Tambah Data Pelanggan</h3>
            <a href="/pengguna">Kembali</a>
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="card-body col-md-5">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h6><i class="icon fas fa-ban"></i>Data Pengguna</h6>
                        <?= session()->getFlashdata('errors'); ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form action="/pengguna/save" method="post">
                        <?= csrf_field(); ?>
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama </label>
                                    <input type="text" id="nama" name="nama" class="form-control form-control-border border-width-2 col-md-10" placeholder="Nama" required autofocus value="<?= old('nama') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Username </label>
                                    <input type="text" id="Username" name="username" class="form-control form-control-border border-width-2 col-md-10" placeholder="Username" required autofocus value="<?= old('username') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="nope" name="password" class="form-control form-control-border border-width-2 col-md-10" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control form-control-border border-width-2 col-md-10" placeholder="Alamat" required autofocus value="<?= old('alamat') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Hak Akses</label>
                                    <select name="level" id="level" class="form-control col-md-10 ">
                                        <option>Pilih Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Kasir">Kasir</option>
                                    </select>
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