<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">TAMBAH MERCHANT</h3>
        <div class="card-tools">
            <button data-toggle="modal" data-target="#generate_code_modal" id="btn_generate_code" class="btn btn-navy btn-sm">Generate Code</button>
        </div>
    </div>
    <div class="card-body">
        <form id="form_tambah_merchant">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nama Merchant</label>
                                <input class="form-control" autocomplete="off" name="nama_merchant" id="nama_merchant"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Kode Merchant</label>
                                <input class="form-control" autocomplete="off" name="kode_merchant" id="kode_merchant"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Contact Person Merchant</label>
                                <input class="form-control" autocomplete="off" name="contact_person" id="contact_person"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Email Merchant</label>
                                <input class="form-control" autocomplete="off" name="email" id="email"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Alamat Merchant</label>
                                <textarea rows=5 class="form-control" autocomplete="off" name="alamat" id="alamat"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-4 text-right mt-2">
                    <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST MERCHANT</h3>
    </div>
    <div class="card-body">
        <div id="list_merchant" class="row">
        </div>
    </div>
</div>
<div class="modal fade" id="generate_code_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-md">
		<div class="modal-content">
			<div id="generate_code_modal_content">
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
        loadMerchant()
    })

    function loadMerchant(){
        $('#list_merchant').html('')
        $('#list_merchant').append('<div id="loader" class="col-md-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_merchant').load('<?=base_url("merchant/C_Merchant/loadMerchant")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_merchant').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("merchant/C_Merchant/insertMerchant")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadMerchant()
                $('#nama_merchant').val('')
                $('#kode_merchant').val('')
                $('#contact_person').val('')
                $('#email').val('')
                $('#alamat').val('')
                successtoast('Merchant Berhasil ditambahkan')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#btn_generate_code').click(function(){
        $('#generate_code_modal_content').html('')
        $('#generate_code_modal_content').append(divLoaderNavy)
        $('#generate_code_modal_content').load('<?=base_url("merchant/C_Merchant/generateCode")?>', function(){
            
        })
    })
</script>