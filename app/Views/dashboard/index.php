<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="pesan" data-pesan="<?= session()->getFlashdata('pesan') ?>"></div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= esc($produk); ?></h3>

                        <p>Produk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <?php if (esc(aduh('212412_level') == 'Admin')) : ?>
                        <a href="/produk" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    <?php endif ?>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= esc($vendor); ?><sup style="font-size: 20px"></sup></h3>

                        <p>Vendor</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck-moving"></i>
                    </div>
                    <a href="/vendor" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= esc($transaksi); ?></h3>

                        <p>Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="/penjualan" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3><?= esc($users); ?></h3>

                        <p>Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="/pengguna" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row (main row) -->
        <div class="row">
            <div class="col-md-12">
                <!-- Total Penjualan -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Total Penjualan</h3>
                            <!-- <a href="javascript:void(0);">Lihat Laporan</a> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="laporan-penjualan" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<script src="/plugins/chart.js/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        let pesan = $('#pesan').data('pesan')
        if (pesan) {
            Swal.fire({
                title: pesan,
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
            })
        }
        $.getJSON(`<?= site_url(); ?>/dashboard/laporan`, function(data) {
            let label = []
            let total = []
            $(data).each(function(i) {
                label.push(data[i].bulan)
                total.push(data[i].total)
            })

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold',
            }

            var mode = 'index'
            var intersect = true

            var ctx = $('#laporan-penjualan')
            var salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        data: total,
                    }, ],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect,
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect,
                    },
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent',
                            },
                            ticks: $.extend({
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return value
                                    },
                                },
                                ticksStyle
                            ),
                        }, ],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: ticksStyle,
                        }, ],
                    },
                },
            })
        })
    })
</script>

<?= $this->endSection(); ?>