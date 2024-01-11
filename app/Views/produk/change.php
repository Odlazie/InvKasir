<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h3><?= $title; ?></h3>
            <a href="/Produk">Kembali</a>
            <div class="card">
                <div class="card-body">
                    <h5>Form Tambah <?= $title; ?></h5>
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="card-body col-md-5">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fas fa-ban"></i>Data Produk</h6>
                                <?= session()->getFlashdata('errors'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form action="/produk/update/<?= $dataProduk['212412_id']; ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>No. Produk</label>
                                    <input type="text" id="barcode" name="no_produk" class="form-control form-control-border border-width-2 col-md-10" placeholder="" value="<?= $dataProduk['212412_no_produk']; ?>" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" id="nama" name="nama_produk" class="form-control form-control-border border-width-2 col-md-10" placeholder="Nama Produk" value="<?= $dataProduk['212412_nama_produk']; ?>" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control col-md-10">
                                        <option <?= $dataProduk['212412_kategori'] == 'Makanan' ? 'selected' : ''; ?> value="Makanan">Makanan</option>
                                        <option <?= $dataProduk['212412_kategori'] == 'Minuman' ? 'selected' : ''; ?> value="Minuman">Minuman</option>
                                        <option <?= $dataProduk['212412_kategori'] == 'Atk' ? 'selected' : ''; ?> value="Atk">Atk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <select name="id_vendor" id="Vendor" class="form-control col-md-10  ">
                                        <?php foreach ($vendor as $ds) : ?>
                                            <option value="<?= $ds['212412_id']; ?>" <?= ($ds['212412_id'] == $dataProduk['212412_id_vendor']) ? 'selected' : ''; ?>>
                                                <?= $ds['212412_nama_vendor']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="int" id="Harga" name="harga" class="form-control form-control-border border-width-2 col-md-10" placeholder="" value="<?= $dataProduk['212412_harga']; ?>" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="int" id="stok" name="stok" class="form-control form-control-border border-width-2 col-md-10" placeholder="1000" value="<?= $dataProduk['212412_stok']; ?>" required autofocus>
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
<script src="/plugins/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        let auto_numeric = new AutoNumeric('#Harga', {
            decimalCharacter: ",",
            decimalPlaces: 0,
            digitGroupSeparator: ".",
        });
        let ss = new AutoNumeric('#stok', {
            decimalCharacter: ",",
            decimalPlaces: 0,
            digitGroupSeparator: ".",
        });
    });
</script>
<?= $this->endSection(); ?>