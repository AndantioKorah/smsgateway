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
</aside>