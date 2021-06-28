<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card card-navy collapsed-card">
            <div class="card-header card_header" style="cursor: pointer;" data-card-widget="collapse">
                <h3 class="card-title">EXPIRE DATE APPLICATION</h3>
            </div>
            <div class="card-body">
                <form id="form_expire" action="<?=base_url('parameter/C_Parameter/updateExpDateApp')?>" method="post">
                    <div class="row">
                        <div class="col-12">
                            <label>Tanggal Expire Aplikasi</label>
                            <input readonly class="form-control form-control-sm" value="<?=formatDate($parameter_exp['parameter_value'])?>" />
                            <input class="form-control form-control-sm" style="display: none;" value="PARAM_EXP_APP" name="parameter_name" />
                        </div>
                        <div class="col-12 text-center">
                            <br>
                            <label>Update To:</label><br>
                            <label><i class="fa fa-arrow-down"></i></label>
                        </div>
                        <div class="col-12">
                            <label>Tanggal Expire Baru</label>
                            <input type="date" class="form-control form-control-sm" name="parameter_value" value="<?=date('Y-m-d')?>" />
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12">
                            <label>Username Programmer</label>
                            <input class="form-control form-control-sm" name="username" />
                        </div>
                        <div class="col-12">
                            <label>Password</label>
                            <input class="form-control form-control-sm" type="password" name="password" />
                        </div>
                        <div class="col-12">
                            <label>Second Password</label>
                            <input class="form-control form-control-sm" type="password" name="second_password" />
                        </div>
                        <div class="col-9"></div>
                        <div class="col-3 mt-2 text-right">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row mt-3">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card card-navy collapsed-card">
            <div class="card-header card_header" style="cursor: pointer;" data-card-widget="collapse">
                <h3 class="card-title">BIOS SERIAL NUMBER</h3>
            </div>
            <div class="card-body">
                <form id="form_bios_serial_number" action="<?=base_url('parameter/C_Parameter/updateExpDateApp')?>" method="post">
                    <div class="row">
                        <div class="col-12">
                            <label>BIOS SERIAL NUMBER</label>
                            <input type="input" class="form-control form-control-sm" name="parameter_value" />
                            <input class="form-control form-control-sm" style="display: none;" value="PARAM_BIOS_SERIAL_NUMBER" name="parameter_name" />
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12">
                            <label>Username Programmer</label>
                            <input class="form-control form-control-sm" name="username" />
                        </div>
                        <div class="col-12">
                            <label>Password</label>
                            <input class="form-control form-control-sm" type="password" name="password" />
                        </div>
                        <div class="col-12">
                            <label>Second Password</label>
                            <input class="form-control form-control-sm" type="password" name="second_password" />
                        </div>
                        <div class="col-9"></div>
                        <div class="col-3 mt-2 text-right">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row mt-3">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card card-navy collapsed-card">
            <div class="card-header card_header" style="cursor: pointer;" data-card-widget="collapse">
                <h3 class="card-title">BACK DATE SETTING</h3>
            </div>
            <div class="card-body">
                <form id="form_bios_back_date_setting" action="<?=base_url('parameter/C_Parameter/updateExpDateApp')?>" method="post">
                    <div class="row">
                        <div class="col-12">
                            <label>LAST LOGIN</label>
                            <input type="input" class="form-control form-control-sm datetimepickerthis" readonly value="<?=$parameter_last_login['parameter_value']?>" name="parameter_value" />
                            <input type="input" class="form-control form-control-sm" style="display:none;" readonly value="<?=$parameter_last_login['parameter_value']?>" name="old_parameter_value" />
                            <input class="form-control form-control-sm" style="display: none;" value="PARAM_LAST_LOGIN" name="parameter_name" />
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12">
                            <label>Username Programmer</label>
                            <input class="form-control form-control-sm" name="username" />
                        </div>
                        <div class="col-12">
                            <label>Password</label>
                            <input class="form-control form-control-sm" type="password" name="password" />
                        </div>
                        <div class="col-12">
                            <label>Second Password</label>
                            <input class="form-control form-control-sm" type="password" name="second_password" />
                        </div>
                        <div class="col-9"></div>
                        <div class="col-3 mt-2 text-right">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<script>
    $(function(){
        <?php if($this->session->flashdata('message') && $this->session->flashdata('message') != '0'){ ?>
            errortoast('<?=$this->session->flashdata('message')?>')
        <?php } ?>
        <?php if($this->session->flashdata('message') == '0'){ ?>
            successtoast('UPDATE BERHASIL')
        <?php } ?>
    })
</script>