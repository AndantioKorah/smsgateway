<style>
    .custom_form_control_generate_code {
        display: inline-block;
        margin: 1.2rem auto;
        border: none;
        padding: 0;
        width: 9ch;
        background: repeating-linear-gradient(90deg, #878c92 0, #878c92 1ch, transparent 0, transparent 1.5ch) 0 100%/ 9ch 2px no-repeat;
        font: 4.2rem 'Ubuntu Mono', monospace;
        color: #001f3f;
        letter-spacing: 0.5ch;
    }
    .custom_form_control_generate_code:focus {
        outline: none;
        color: #001f3f;
        background: repeating-linear-gradient(90deg, #001f3f 0, #001f3f 1ch, transparent 0, transparent 1.5ch) 0 100%/ 9ch 2px no-repeat;
    }
</style>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="col-md-12 text-center">
                <h6>EXPIRE DATE SAAT INI:</h6>
                <h3><?=formatDate($parameter_exp['parameter_value'])?></h3>
            </div>
            <div class="col-md-12 mt-4 text-center">
                <form id="form_extend" method="post" action="<?=base_url('parameter/C_Parameter/validateGeneratedCode')?>">
                    <h6>Masukkan Generate Code untuk menambah Expire Date :</h6>
                    <input type="number" autocomplete="off" maxlength='6' class="custom_form_control_generate_code" name="generate_code" />
                    <br><button type="submit" class="btn btn-navy"><i class="fa fa-paper-plane"></i> Validasi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
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