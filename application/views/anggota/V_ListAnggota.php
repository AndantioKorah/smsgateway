<div class="col-12">
    <div class="mt-3">
        <h5 class="text-header">List Anggota</h5>
        <div class="row col-6">
            <div class="col-1">
                <i class="fa fa-lg fa-search mt-2"></i>
            </div>
            <div class="col-11" style="margin-left: -70px;">            
                <input style="padding-left: 35px;" placeholder="Cari Berdasarkan Nama" autocomplete="off" type="text" id="search-anggota" class="form-control-sm form-control-nikita"/>
            </div>
        </div>
        <div class="col-12 mt-5">
            <div id="listAnggota" class="row"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        showDataAnggota();
    });

    $(document).on('keyup', '#search-anggota', function(){
        searchAnggota($('#search-anggota').val());
    });

    function showDataAnggota(){
		$("#listAnggota").html('<div class="col loader"><h5>Mengambil Data...</h5></div>');
		$("#listAnggota").load('<?=base_url('anggota/C_Anggota/getAllAnggota')?>', function(){
			$('.loader').hide();
		});
	}

    function searchAnggota(name){
        if(name == ''){
            showDataAnggota();
        } else {
            $("#listAnggota").html('<div class="col loader"><h5>Mengambil Data...</h5></div>');
            $("#listAnggota").load('<?=base_url()?>anggota/C_Anggota/searchByName/'+name, function(){
            // $("#listAnggota").load('<?=base_url()?>anggota/C_Anggota/searchByName/'+name, function(){
                $('.loader').hide();
            });
        }
	}
</script>