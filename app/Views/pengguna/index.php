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
    <a href="/pengguna/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pengguna" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Akses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
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

<script>
    $(document).ready(function() {
        const table = $("#table-pengguna").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `<?= site_url(); ?>/pengguna/ajax`
            },
            lengthMenu: [
                [5],
                [5]
            ],
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'username'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'level'
                },
                {
                    render: function(data, type, row) {
                        let html = `<div class="text-center">`;
                        html += ` <a href="/pengguna/change/${row.id}" class="btn btn-success btn-sm mr-1"><i class="fas fa-edit"></i></a>`;
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.id + '"><i class="fas fa-trash"></i></button>';
                        html += `</div>`;
                        return html;
                    }
                }
            ],
            columnDefs: [{
                    targets: 0,
                    width: "5%"
                },
                {
                    targets: [0, -1],
                    orderable: false
                }
            ]
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
                        url: `<?= site_url(); ?>/pengguna/hapus`,
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