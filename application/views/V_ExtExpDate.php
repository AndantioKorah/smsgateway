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
    <div class="col-md-12 text-center">
        <label><i class="fa fa-info-circle"></i> Pastikan perangkat Anda terhubung dengan koneksi internet untuk menggunakan fitur ini</label>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="col-md-12 text-center">
                <h6>EXPIRE DATE SAAT INI:</h6>
                <h3><?=formatDate($parameter_exp['parameter_value'])?></h3>
            </div>
            <div class="col-md-12 mt-4 text-center">
                <form id="form_extend" method="post" action="<?=base_url('parameter/C_Parameter/validateGeneratedCode')?>">
                    <h6>Masukkan Generated Code untuk menambah Expire Date :</h6>
                    <input type="text" id="generated_code" autocomplete="off" maxlength='6' class="custom_form_control_generate_code" name="generate_code" />
                    <input style="display:none;" name="kode_merchant" value="<?=$parameter_merchant_code['parameter_value']?>" />
                    <br><button id="validate_button" type="submit" class="btn btn-navy"><i class="fa fa-paper-plane"></i> Validasi</button>
                    <br><button id="loading_button" style="display: none;" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Melakukan Validasi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<script>
    $('#form_extend').on('submit', function(e){
        e.preventDefault()
        $('#validate_button').hide()
        $('#loading_button').show()
        $.ajax({
            url: '<?=base_url('parameter/C_Parameter/validateGeneratedCode')?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#generated_code').val('')
                let rs = JSON.parse(data)
                $('#validate_button').show()
                $('#loading_button').hide()
                if(rs.code != 0){
                    errortoast(rs.message)
                } else {
                    successtoast('Generated Code berhasil divalidasi dan Expire Date sudah diperpanjang')
                    window.location = "";
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $(function(){
        <?php if($this->session->flashdata('message') && $this->session->flashdata('message') != '0'){ ?>
            errortoast('<?=$this->session->flashdata('message')?>')
        <?php } ?>
        <?php if($this->session->flashdata('message') == '0'){ ?>
            successtoast('UPDATE BERHASIL')
        <?php } ?>
    })
</script>