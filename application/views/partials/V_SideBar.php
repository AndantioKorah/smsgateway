<style>
  /* .image{
    width: 5px !important;
    height: 100px !important;
  } */
  .main-sidebar{
    position: fixed !important;
    /* margin-top: 50px; */
  }
</style>
<?php
  $role = $this->general_library->getRole();
?>

<aside class="main-sidebar elevation-4 sidebar-light-navy">
  <!-- Brand Logo -->
  <a href="<?=base_url('welcome')?>" class="brand-link navbar-navy">
    <img src="<?=base_url('assets/img/logo-putih-biru.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
    <span class="brand-text font-weight-light text-light"><?=TITLES?></span>
  </a>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?=$this->general_library->getProfilePicture()?>" style="height: 33px;" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?=base_url('user/setting')?>" class="d-block"><?=$this->general_library->getNamaUser();?></a>
      </div>
    </div>
    <?php 
      if($this->general_library->isNotAppExp()){
    ?>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <?php if($role != 'kasir'){ ?>
        <!-- <li class="nav-item">
          <a href="<?=base_url('admin/dashboard')?>" class="nav-link <?=$active == 'dashboard' ? 'active' : ''?>">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li> -->
        <li class="nav-item has-treeview <?=$parent_active == 'master_barang' ? 'menu-open' : ''?>">
          <a href="#" class="nav-link <?=$parent_active == 'master_barang' ? 'active' : ''?>">
            <i class="nav-icon fas fa-box-open"></i>
            <p>
              Master Barang
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=base_url('admin/barang/kategori')?>" class="nav-link <?=$active == 'kategori_barang' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('admin/barang/sub-kategori')?>" class="nav-link <?=$active == 'sub_kategori_barang' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('admin/barang/item')?>" class="nav-link <?=$active == 'item_barang' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Item</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?=base_url('admin/barang/stock')?>" class="nav-link <?=$active == 'stock_barang' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock</p>
              </a>
            </li> -->
          </ul>
        </li>
        <li class="nav-item has-treeview <?=$parent_active == 'jenis_transaksi' ? 'menu-open' : ''?>">
          <a href="#" class="nav-link <?=$parent_active == 'jenis_transaksi' ? 'active' : ''?>">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Master Jenis Transaksi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=base_url('master/transaksi/pengeluaran')?>" class="nav-link <?=$active == 'master_pengeluaran' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengeluaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('master/transaksi/pembelian')?>" class="nav-link <?=$active == 'master_pembelian' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Pembelian</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?=$parent_active == 'laporan' ? 'menu-open' : ''?>">
          <a href="#" class="nav-link <?=$parent_active == 'laporan' ? 'active' : ''?>">
            <i class="nav-icon fas fa-file"></i>
            <p>
              Laporan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=base_url('laporan/rekap/harian')?>" class="nav-link <?=$active == 'rekap_harian' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Harian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('laporan/transaksi')?>" class="nav-link <?=$active == 'laporan_transaksi' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Transaksi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('laporan/penjualan')?>" class="nav-link <?=$active == 'laporan_penjualan' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('laporan/pembayaran')?>" class="nav-link <?=$active == 'laporan_pembayaran' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Pembayaran</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?=$parent_active == 'user_management' ? 'menu-open' : ''?>">
          <a href="#" class="nav-link <?=$parent_active == 'user_management' ? 'active' : ''?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=base_url('roles')?>" class="nav-link <?=$active == 'roles' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Role</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('users')?>" class="nav-link <?=$active == 'users' ? 'active' : ''?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('transaksi/pembelian')?>" class="nav-link <?=$active == 'transaksi_pembelian' ? 'active' : ''?>">
            <i class="fas fa-shopping-cart nav-icon"></i>
            <p>Pembelian</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('transaksi/pengeluaran')?>" class="nav-link <?=$active == 'transaksi_pengeluaran' ? 'active' : ''?>">
            <i class="fas fa-share-square nav-icon"></i>
            <p>Pengeluaran</p>
          </a>
        </li>
        <?php } ?>
        <?php if($role != 'admin'){ ?>
        <li class="nav-item">
          <a href="<?=base_url('kasir')?>" class="nav-link <?=$active == 'kasir' ? 'active' : ''?>">
            <i class="fas fa-cash-register nav-icon"></i>
            <p>Kasir</p>
          </a>
        </li>
        <?php } ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  <?php } ?>
</aside>