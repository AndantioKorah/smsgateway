<div class="row">
    <div class="col-3 pl-4 pr-3" id="div_data_pasien"></div>
    <div class="col-9 pl-3" id="content_div_transaksi"></div>
</div>
<script>
    $(function(){
        loadProfilPasien('<?=$id_m_pasien?>')
        loadListPendaftaranPasien('<?=$id_m_pasien?>')
    })

    function loadProfilPasien(id){
        $('#div_data_pasien').html('')
        $('#div_data_pasien').append(divLoaderNavy)
        $('#div_data_pasien').load('<?=base_url("pendaftaran/C_Pendaftaran/loadProfilPasien")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }

    function loadListPendaftaranPasien(id){
        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("pendaftaran/C_Pendaftaran/loadListPendaftaranPasien")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }
</script>