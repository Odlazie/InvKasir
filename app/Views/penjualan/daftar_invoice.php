<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<!-- .content-header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= esc($title); ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?= esc($title); ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="pesan" data-pesan="<?= session('pesan') ?>"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabel-invoice" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let pesan = $(".pesan").data('pesan')
        if (pesan != '') {
            toastr.error(pesan)
        }
        const table = $("#tabel-invoice").DataTable({
            proseccing: true,
            serverSide: true,
            order: [
                [1, "desc"]
            ],
            ajax: {
                url: `<?= site_url(); ?>/penjualan/invoice`
            },
            //optional
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "all"]
            ],
            "columns": [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'invoice'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'namakasir'
                },
                {
                    render: function(data, type, row) {
                        let html = `<button class="btn btn-success btn-sm print" data-id='${row.id}'><i class="fas fa-print"></i></button>`;
                        return html;
                    }
                }
            ],
            columnDefs: [{
                    targets: 0,
                    width: "5%"
                },
                {
                    targets: [0, 4],
                    className: "text-center"
                },
                {
                    targets: [0, 4],
                    orderable: false
                },
                {
                    targets: [0, 2, 4],
                    searchable: false
                }
            ]
        });
        $(document).on('click', '.print', function(e) {
            window.open(`<?= site_url(); ?>/penjualan/cetak/` + $(this).data('id'))
        });
    });
</script>
<?= $this->endSection(); ?>