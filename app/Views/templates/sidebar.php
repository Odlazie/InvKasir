<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-navy">
  <!-- Brand Logo -->
  <a href="/dashboard" class="brand-link">
    <i class="fab fa-shopify fa-3x text-info"></i>
    <span class="brand-text font-weight-light ">Tokoh Aku</span>
  </a>
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/dist/img/avatar.jpg" class="img-circle elevation-2 avatar">
      </div>
      <div class="info">
        <a href="javascript:void(0)" class="d-block"><?= esc(aduh('212412_nama')); ?> <?= esc(aduh('212412_level')); ?></a>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard </p>
          </a>
        </li>
        <?php if (esc(aduh('212412_level') == 'Admin')) : ?>
          <li class="nav-item">
            <a href="/v_vendor" class="nav-link">
              <i class="nav-icon fas fa-truck-moving"></i>
              <p> Vendor </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p> Master Data <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/produk" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/stok/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stok</p>
                </a>
              </li>
            </ul>
          <?php endif ?>
          </li>
          <li class="nav-item">
            <a href="/penjualan" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p> Transaksi </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/penjualan/invoice" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p> Histori Transaksi </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/laporan" class="nav-link">
              <i class="nav-icon fas fa-scroll"></i>
              <p> Laporan Penjualan </p>
            </a>
          </li>
          <?php if (esc(aduh('212412_level') == 'Admin')) : ?>
            <li class="nav-header">Administrator Site </li>
            <li class="nav-item">
              <a href="/pengguna" class="nav-link">
                <i class="nav-icon fas fa-user-alt"></i>
                <p>Pengguna </p>
              </a>

            </li>
          <?php endif ?>
          <li class="nav-item">
            <a href="/login/logut" class="nav-link" data-toggle="modal" data-target="#logoutModal">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Log Out </p>
            </a>

          </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>