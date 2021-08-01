<?php
    if($pasien){
    $tempat_lahir = $pasien['tempat_lahir'] ? $pasien['tempat_lahir'] : '-';
    $tanggal_lahir = $pasien['tanggal_lahir'] ? formatDateOnly($pasien['tanggal_lahir']) : '-';
    $jenis_identitas = $pasien['jenis_identitas'] ? $pasien['jenis_identitas'] : '-';
    $nomor_identitas = $pasien['nomor_identitas'] ? $pasien['nomor_identitas'] : '-';
    $golongan_darah = $pasien['golongan_darah'] ? $pasien['golongan_darah'] : '-';
    $alamat = $pasien['alamat'] ? $pasien['alamat'] : '-';
    $nama_pekerjaan = $pasien['nama_pekerjaan'] ? $pasien['nama_pekerjaan'] : '-';
    $kewarganegaraan = $pasien['kewarganegaraan'] ? $pasien['kewarganegaraan'] : '-';
    $nomor_telepon = $pasien['nomor_telepon'] ? $pasien['nomor_telepon'] : '-';
?>
<style>
    #div_detail_pendaftaran{
        border-top: 1px solid rgba(0, 0, 0, .125);
        background-color: white;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
    }
</style>
<div class="card card-default">
    <div class="card-header text-center">
        <span id="span_nama_pasien" style="font-size: 20px; font-weight: bold;"><?=$pasien['nama_pasien']?></span>
    </div>
    <div class="card-body">
        <div class="col-12 text-center">
            <span style="font-size: 17px; font-weight: bold;">NORM: <?=$pasien['norm']?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;">
            <i class="<?=$pasien['jenis_kelamin'] == 1 ? 'fa fa-mars' : 'fa fa-venus'?>"></i> <?=$pasien['jenis_kelamin'] == 1 ? 'LAKI-LAKI' : 'PEREMPUAN'?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-birthday-cake"></i> <?=$tempat_lahir.', '.$tanggal_lahir?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-id-card"></i> <?='('.$jenis_identitas.') '.$nomor_identitas?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-burn"></i> <?=$golongan_darah?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-map-marked-alt"></i> <?=$alamat?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-briefcase"></i> <?=$nama_pekerjaan?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-flag"></i> <?=$kewarganegaraan?></span>
        </div>
        <div class="col-12 text-left">
            <span style="font-size: 14px; font-weight: bold;"><i class="fa fa-phone"></i> <?=$nomor_telepon?></span>
        </div>
        <div class="col-12 text-center p-2">
            <button href="#edit_data_pasien" data-toggle="modal" data-tooltip="tooltip_profile_pasien" data-placement="top" title="Edit Data Pasien" onclick="editPasien()" 
            class="btn btn-sm btn-outline-navy"><i class="fa fa-user-edit"></i></button>

            <button id="btn_pendaftaran_baru" class="btn btn-sm btn-outline-navy" data-tooltip="tooltip_profile_pasien" data-placement="top" title="Pendaftaran Baru">
            <i class="fa fa-plus-square"></i></button>
        </div>
    </div>
    <div class="card-footer" id="div_detail_pendaftaran" style="display: none;">
        
    </div>
</div>
<script>
    $(function(){
        $('[data-tooltip="tooltip_profile_pasien"]').tooltip();

        $('[data-tooltip="tooltip_profile_pasien"]').on('click', function() {
            $(this).tooltip('hide')
        });
    })

    function editPasien(){
        openModalEditPasien('<?=$pasien['norm']?>', 'loadProfilPasien')
    }

    $('#btn_pendaftaran_baru').on('click', function(){
        $.ajax({
            url: '<?=base_url("pendaftaran/C_Pendaftaran/fillIdPasienPendaftaran").'/'.$pasien['id']?>',
            method: 'post',
            success: function(datares){
                window.location="<?=base_url('pendaftaran')?>"
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>
<?php } else { ?>
    <script>
        errortoast('Data Pasien tidak ditemukan')
    </script>
<?php } ?>