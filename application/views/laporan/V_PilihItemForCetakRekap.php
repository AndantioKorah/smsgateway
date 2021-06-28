<form id="form_pilih_item">
    <div class="row p-3">
        <div class="col-12 pb-3">
            <h5>KATEGORI</h5>
            <div class="row">
                <div class="col-12">
                    <div class="icheck-primary d-inline">
                        <input value="semua_kategori" name="kategori[]" type="checkbox" id="pilih_semua_kategori" checked>
                        <label for="pilih_semua_kategori">PILIH SEMUA</label>
                    </div>
                </div>
                <?php if($kategori){ foreach($kategori as $k){ ?>
                    <div class="col-2 mt-3">
                        <div class="icheck-primary d-inline">
                            <input value="<?=$k['id']?>" name="kategori[]" type="checkbox" class="checkbox_kategori" id="kategori_<?=$k['id']?>" checked>
                            <label for="kategori_<?=$k['id']?>"><?=$k['nama_kategori']?></label>
                        </div>
                    </div>
                <?php } } ?>
            </div>
            <hr>
        </div>
        <div class="col-12 pb-3">
            <h5>SUB KATEGORI</h5>
            <div class="row">
                <div class="col-12">
                    <div class="icheck-primary d-inline">
                        <input value="semua_sub_kategori" name="sub_kategori[]" type="checkbox" id="pilih_semua_sub_kategori" checked>
                        <label for="pilih_semua_sub_kategori">PILIH SEMUA</label>
                    </div>
                </div>
                <?php if($sub_kategori){ foreach($sub_kategori as $sk){ ?>
                    <div class="col-2 mt-3">
                        <div class="icheck-primary d-inline">
                            <input value="<?=$sk['id']?>" name="sub_kategori[]" type="checkbox" class="checkbox_sub_kategori" id="sub_kategori_<?=$sk['id']?>" checked>
                            <label for="sub_kategori_<?=$sk['id']?>"><?=$sk['nama_sub_kategori']?></label>
                        </div>
                    </div>
                <?php } } ?>
            </div>
            <hr>
        </div>
        <div class="col-12 pb-3">
            <h5>ITEM</h5>
            <div class="row">
                <div class="col-12">
                    <div class="icheck-primary d-inline">
                        <input value="semua_item" name="item[]" type="checkbox" id="pilih_semua_item" checked>
                        <label for="pilih_semua_item">PILIH SEMUA</label>
                    </div>
                </div>
                <?php if($item){ foreach($item as $i){ ?>
                    <div class="col-2 mt-3">
                        <div class="icheck-primary d-inline">
                            <input value="<?=$i['id']?>" name="item[]" type="checkbox" class="checkbox_item" id="item_<?=$i['id']?>" checked>
                            <label for="item_<?=$i['id']?>"><?=$i['nama_item']?></label>
                        </div>
                    </div>
                <?php } } ?>
            </div>
            <hr>
        </div>
        <div class="col-12 text-right">
            <button type="submit" id="cetak_rekap_btn" class="btn btn-sm btn-navy" accesskey="c"><i class="fa fa-print"></i> CETAK REKAP</button>
        </div>
    </div>
</form>

<div id="print_div" style="display:none;"></div>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>

<script>
    $('#form_pilih_item').on('submit', function(e){
        e.preventDefault()
        let data_post = $(this).serialize();
        if(data_post.length == 0){
            errortoast('Parameter tidak boleh kosong')
            return false
        }
        $.ajax({
            url: '<?=base_url('laporan/C_Laporan/createDataRekap')?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                cetakRekap()
            }, error: function(){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $("#pilih_semua_kategori").change(function(){ 
        $(".checkbox_kategori").prop('checked', $(this).prop("checked"));
    });
    $('.checkbox_kategori').change(function(){ 
        if(false == $(this).prop("checked")){ 
            $("#pilih_semua_kategori").prop('checked', false);
        }
        if ($('.checkbox_kategori:checked').length == $('.checkbox_kategori').length ){
            $("#pilih_semua_kategori").prop('checked', true);
        }
    });

    $("#pilih_semua_sub_kategori").change(function(){ 
        $(".checkbox_sub_kategori").prop('checked', $(this).prop("checked"));
    });
    $('.checkbox_sub_kategori').change(function(){ 
        if(false == $(this).prop("checked")){ 
            $("#pilih_semua_sub_kategori").prop('checked', false);
        }
        if ($('.checkbox_sub_kategori:checked').length == $('.checkbox_sub_kategori').length ){
            $("#pilih_semua_sub_kategori").prop('checked', true);
        }
    });

    $("#pilih_semua_item").change(function(){ 
        $(".checkbox_item").prop('checked', $(this).prop("checked"));
    });
    $('.checkbox_item').change(function(){ 
        if(false == $(this).prop("checked")){ 
            $("#pilih_semua_item").prop('checked', false);
        }
        if ($('.checkbox_item:checked').length == $('.checkbox_item').length ){
            $("#pilih_semua_item").prop('checked', true);
        }
    });

    function cetakRekap(){
        $("#print_div").load('<?=base_url('laporan/C_Laporan/cetakRekap')?>', function(){
            // $('img#kop').on('load', function () {
				printSpace('print_div');
			// })
        })
    }

    function printSpace(elementId) {
		var isi = document.getElementById(elementId).innerHTML;
		window.frames["print_frame"].document.title = document.title;
		window.frames["print_frame"].document.body.innerHTML = isi;
		window.frames["print_frame"].window.focus();
		window.frames["print_frame"].window.print();
	}
</script>