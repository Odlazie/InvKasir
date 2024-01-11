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
    <div class="card shadow mb-6">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-stok" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No. Produk </th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Vendor</th>
                            <th scope="col">Jumlah Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
</div><!-- /.container-fluid -->
<script src="/plugins/autoNumeric.min.js"></script>
<script>
    $(document).ready(() => {
        const ajaxUrl = `<?= site_url(); ?>/produk/ajax`;

        const renderRowNumber = (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1;

        const renderEditButton = (data, type, {
            produk_id
        }) => `
        <div class="text-center">
            <a href="/stok/change/${produk_id}" class="btn btn-success btn-sm mr-1">
                <i class="fas fa-edit"></i>
            </a>
        </div>
    `;

        const initializeDataTable = () => {
            const table = $("#table-stok").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: ajaxUrl
                },
                lengthMenu: [
                    [5],
                    [5]
                ],
                columns: [{
                        render: renderRowNumber
                    },
                    {
                        data: 'no_produk'
                    },
                    {
                        data: 'produk'
                    },
                    {
                        data: 'namavendor'
                    },
                    {
                        data: 'stok'
                    },
                    {
                        render: renderEditButton
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        width: "5%"
                    },
                    {
                        targets: -1,
                        orderable: false
                    },
                    {
                        targets: 4,
                        render: $.fn.dataTable.render.number(',', '.', 0, )
                    }
                ],
            });
        };

        initializeDataTable();
    });
</script>

<?= $this->endSection(); ?>