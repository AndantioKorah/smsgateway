<?php
  $params_exp_app = $this->general_library->getParams('PARAM_EXP_APP');
?>
<div class="row" style="margin-top: 50px;">
    <div class="col-12 text-center">
        <h3 href="<?=base_url('welcome')?>"><b><?=TITLES?></b></h3>
        <br>
    </div>
    <div class="col-12 text-center">
        <h3>WELCOME <strong><?=$this->general_library->getNamaUser();?></strong> !</h3>
        <img class="img-circle elevation-2" style="max-width: 150px; max-height: 150px;" src="<?=$this->general_library->getProfilePicture()?>" alt="User Image">
    </div>
    <div class="col-12 text-center">
        <h4 style="font-weight: bold;" id="live_date_time_welcome" class="nav-link"></h4>
    </div>
    <div class="col-12 text-center mt-3">
        <label><i class="fa fa-stopwatch"></i> Perhatikan Expire Date Aplikasi Anda:</label>
        <h4 style="font-weight: bold;" id="live_date_time_welcome" class="nav-link"><?=formatDate($params_exp_app['parameter_value'])?></h4>
        <label class="count_down_exp_app"></label>
    </div>
</div>