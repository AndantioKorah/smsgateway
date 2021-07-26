
<style>
    .div_col_custom{
        text-overflow: ellipsis; 
        white-space: nowrap; 
        overflow: hidden; 
        cursor: pointer;
    }

    .div_col_custom:hover{
        background-color: #001f3f;
        color: white;
        /* border-radius: 5px; */
        transition: .2s;
    }
</style>
<?php if($result){ $i = 0; foreach($result as $rs){
    $no_identitas = $rs['nomor_identitas'] ? $rs['nomor_identitas'] : '-'; 
    $tgl_lahir = $rs['tanggal_lahir'] != '0000-00-00' ? formatDateOnly($rs['tanggal_lahir']) : '-'; 
?>
    <?php if($i == count($result)-1){ ?>
        <div class="div_col_custom col-12" onclick="openPasien('<?=$rs['id']?>')">
    <?php } else { ?>
        <div class="div_col_custom col-12" style="border-bottom: 1px solid #001f3f;" onclick="openPasien('<?=$rs['id']?>')">
    <?php } ?>
        <span style="width: 15px; font-weight: bold; font-size: 14px;"><?='('.$rs['norm'].') '.$rs['nama_pasien']?></span><br>
        <span style="font-size: 13px; font-weight: bold;"><?=$rs['jenis_kelamin'] == 1 ? 'LAKI-LAKI' : 'PEREMPUAN' ?></span><br>
        <span style="font-size: 13px; font-weight: bold;"><?=$tgl_lahir?></span><br>
        <span style="font-size: 13px; font-weight: bold;"><?=$no_identitas?></span>
    </div>
<?php $i++; } } ?>
<script>
    function openPasien(id_m_pasien){
        window.location='<?=base_url('pasien')?>'+'/'+id_m_pasien
    }
</script>