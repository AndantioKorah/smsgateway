<div class="row p-3">
    <div class="col-md-12">
        <h3>Generate Code</h3>
    </div>
    <div class="col-md-12"><hr></div>
    <div class="col-md-12">
        <form id="form_generate_code">
            <div class="row">
                <div class="col-md-12">
                    <label>Pilih Merchant:</label>
                    <select class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_merchant" id="id_m_merchant">
                        <option value="0" disabled selected>Pilih Merchant</option>
                        <?php if($list_merchant){ foreach($list_merchant as $l){ ?>
                            <option value="<?=$l['id']?>"><?='('.$l['kode_merchant'].') '.$l['nama_merchant']?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-12">
                    <label>Expire Date Baru:</label>
                    <input id="new_exp_date" type="date" name="exp_date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>" />
                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-sm text-right btn-navy">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#form_generate_code').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url('merchant/C_Merchant/createNewCode')?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let res = JSON.parse(data)
                if(res['code'] == '0'){
                    successtoast('Kode berhasil dibuat dan telah dikirim melalui NiKitaBOT')
                    $('#generate_code_modal').modal('hide')
                } else {
                    errortoast(res['message'])
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>
