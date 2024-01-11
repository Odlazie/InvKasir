<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<!-- .content-header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Data Vendor</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Vendor</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <a href="/vendor/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="vendor" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Vendor</th>
                            <th>No. Telp</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div>

    <!-- Modal -->


</div><!-- /.container-fluid -->

<script>
    $(document).ready(function() {
        const table = $("#vendor").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `<?= site_url(); ?>/v_vendor/ajax`
            },
            lengthMenu: [
                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama'
                },
                {
                    data: 'telp'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'keterangan'
                },
                {
                    render: function(data, type, row) {
                        let html = `<div class="text-center">`;
                        html += ` <a href="/v_vendor/change/${row.id}" class="btn btn-success btn-sm mr-1"><i class="fas fa-edit"></i></a>`;
                        html += '<button class="btn btn-danger btn-sm hapus" data-id="' + row.id + '"><i class="fas fa-trash"></i></button>';
                        html += `</div">`;
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
                        url: `<?= site_url(); ?>/v_vendor/hapus`,
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