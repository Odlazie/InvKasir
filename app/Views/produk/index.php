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
                    <li class="breadcrumb-item"><a href="/dahsboard">Home</a></li>
                    <li class="breadcrumb-item active"><?= $title; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <a href="/produk/create" class="btn btn-primary mb-1"><i class="fas fa-plus"></i> Tambah <?= $title; ?></a>
    <button id="kategori-makanan" class="btn bg-teal mb-1">
        Kategori Makanan
    </button>
    <button id="kategori-minuman" class="btn bg-teal mb-1">
        Kategori Minuman
    </button>
    <button id="kategori-atk" class="btn bg-teal mb-1">
        Kategori Atk
    </button>
    <button class="btn btn-success mb-1 export-excel"><i class="fas fa-file-excel"></i> Export</button>
    <div class="card shadow mb-6">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabel_produk" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No. Produk </th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Kategori Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
<script src="/plugins/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        const table = $("#tabel_produk").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `<?= site_url(); ?>/produk/ajax`
            },
            lengthMenu: [
                [5, 10, 20],
                [5, 10, 20]
            ],
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'no_produk'
                },
                {
                    data: 'produk'
                },
                {
                    data: 'kategori'
                },
                {
                    data: 'harga',

                },
                {
                    data: 'stok'
                },

                {
                    render: function(data, type, row) {
                        let html = ` <a href="/produk/change/${row.produk_id}" class="btn btn-success btn-sm mr-1"><i class="fas fa-edit"></i></a>`;
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.produk_id + '"><i class="fas fa-trash"></i></button>';
                        return html;
                    }
                }
            ],
            columnDefs: [{
                    targets: 0,
                    width: "5%"
                },
                {
                    targets: 4,
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                },
                {
                    targets: 5,
                    render: $.fn.dataTable.render.number(',', '.', 0, )
                },
                {
                    targets: 6,
                    className: "text-center"
                },
                {
                    targets: [0, 6],
                    orderable: false
                },
                {
                    targets: [5, 6],
                    searchable: false

                }
            ],




        })
        // Event listener untuk tombol kategori makanan
        $("#kategori-makanan").on("click", function() {
            // Memfilter dan menampilkan hanya produk dengan kategori "makanan"
            table.search("makanan", true, false).draw();
        });
        $("#kategori-minuman").on("click", function() {
            // Memfilter dan menampilkan hanya produk dengan kategori "minuman"
            table.search("minuman", true, false).draw();
        });
        $("#kategori-atk").on("click", function() {
            // Memfilter dan menampilkan hanya produk dengan kategori "atk"
            table.search("atk", true, false).draw();
        });
        $(".export-excel").on("click", function() {
            location.href = `<?= site_url(); ?>/produk/download`
        })
        $('.content').on('click', '.hapus', function(e) {
            e.preventDefault()
            Swal.fire({
                title: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= site_url(); ?>/produk/hapus`,
                        data: {
                            id: $(this).data('id')
                        },
                        success: function(response) {
                            table.ajax.reload()
                            if (response.status) {
                                toastr.success(response.pesan, 'Sukses')
                            } else {
                                toastr.error(response.pesan, 'Gagal')
                            }
                        }
                    })
                }
            })
        })

    })
</script>



<?= $this->endSection(); ?>