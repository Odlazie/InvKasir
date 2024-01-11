<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data <?= $title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <a href="/kategori/create" class="btn btn-primary mb-1"><i class="fas fa-plus"></i> Tambah <?= $title; ?></a>
    <div class="card shadow mb-6">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-kategori" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</a></th>
                            <th>Nama <?= $title; ?></th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Makanan</td>
                            <td class="text-center">
                                <a href="/kategori/change" class="btn btn-success btn-sm mr-1"><i class="fas fa-edit"></i></a>
                                <a href="/kategori/delete" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>atk</td>
                            <td class="text-center">
                                <a href="/kategori/change" class="btn btn-success btn-sm mr-1"><i class="fas fa-edit"></i></a>
                                <a href="/kategori/delete" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>




            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->



<?= $this->endSection(); ?>