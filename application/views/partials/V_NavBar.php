<nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a style="font-weight: bold;" id="live_date_time" class="nav-link"></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Nofications</a>
        </div>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="tooltip" data-placement="bottom" title="<?=countDiffDateLengkap($params_exp_app['parameter_value'], date('Y-m-d H:i:s'), ['tahun', 'bulan', 'hari', 'jam', 'menit'])?>">
          <i class="fa fa-stopwatch"></i> <?=formatDate($params_exp_app['parameter_value'])?>
        </a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <img src="<?=$this->general_library->getProfilePicture()?>" style="height: 25px; width:25px; margin-right: 1px;" class="img-circle elevation-2" alt="User Image">
            <?=$this->general_library->getNamaUser()?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- <div class="dropdown-divider"></div> -->
            <a href="<?=base_url('apps/setting/expdate')?>" class="dropdown-item">
                <i class="fa fa-clock mr-2"></i> Extend Expire Date
            </a>
            <div class="dropdown-divider"></div>
            <?php if($this->general_library->getRole() == 'programmer' && $this->general_library->getNamaUser() == 'tiokors'){ ?>
              <a href="<?=base_url('apps/setting')?>" class="dropdown-item">
                  <i class="fa fa-cogs mr-2"></i> Pengaturan
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?=base_url('merchant')?>" class="dropdown-item">
                  <i class="fa fa-store mr-2"></i> Merchant
              </a>
            <?php } ?>
            <div class="dropdown-divider"></div>
              <a href="<?=base_url('user/setting')?>" class="dropdown-item">
                  <i class="fa fa-users mr-2"></i> Account
              </a>
            <div class="dropdown-divider"></div>
              <a href="<?=base_url('logout')?>" class="dropdown-item">
                  <i class="fa fa-sign-out-alt mr-2"></i> Keluar
              </a>
        </div>
      </li>
    </ul>
  </nav>