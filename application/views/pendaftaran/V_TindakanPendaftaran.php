<style>
    
</style>
<table class="table table-sm table-hover" border="0" style="width: 100%; max-height: 350px; overflow:auto;">
    <thead class="thead_rincian_tindakan">
        <th style="width: 5%;" class="text-center" >No</th>
        <th style="width: 25%;" >Tindakan</th>
        <th style="width: 5%;" class="text-center">Biaya</th>
        <th style="width: 5%;" class="text-center">Pilihan</th>
    </thead>
    <tbody class="tbody_rincian_tindakan" id="daftar_tindakan">
        <?php if(isset($rincian_tindakan)){ 
            $total_biaya = 0;
            $no=1; 
            foreach($rincian_tindakan as $rt){ 
            ?>
            <tr style="cursor: pointer;">
                <td class="text-center"><b style="font-size: 14px;"><?=$no;?></b></td>
                <td><b style="font-size: 14px;"><?=strtoupper($rt['nm_jns_tindakan'])?></b></td>
                <td class="text-center"></td>
                <td class="text-center"></td>

                <?php 
                
                if(isset($rt['tindakan'])){
                    $nmr=1;
                    foreach($rt['tindakan'] as $dt){
                    $total_biaya += $dt['biaya'];
                    ?>
                <tr style="cursor: pointer;" onclick="showTrDetailTindakan('<?=$no.$nmr?>')">
                    <td class="text-center" style="font-size: 14px;"> <?=$no.'.'.$nmr;?> </td>
                    <td><b style="font-size: 14px;"><?=$dt['nama_tindakan']?></b></td>
                    <td class="text-center"><b><?=formatCurrency($dt['biaya'])?></b></td>
                    <td class="text-center"><input type="button" title="Hapus Tindakan"  class="btn btn-danger btn-sm tombol_hapus_tindakan" data-idtindakan="<?=$dt['id']?>"  value="Hapus"></td>
                </tr>
            
                <?php if(isset($dt['detail_tindakan'])){ foreach($dt['detail_tindakan'] as $d) { ?>
                <tr class="tr_detail_tindakan_<?=$no.$nmr?>" style="display: none;">
                    <td></td>
                    <td style="font-size: 14px;"><?=$d['nama_tindakan']?></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } } $nmr++; } } ?>
                
            </tr>
            <?php $no++; ?> 
        <?php } ?>
            <tr>
                <td colspan=2 class="text-right"><b style="font-size: 16px;">TOTAL BIAYA :</b></td>
                <td colspan=1 class="text-center"><b style="font-size: 16px;"><?=formatCurrency($total_biaya)?></b></td>
                <td></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="4">BELUM ADA DATA</td>
            </tr>
        <?php   } ?>
    </tbody>
</table> 
<script>
     var base_url = "<?=base_url()?>";

    function showTrDetailTindakan(id){
        $('.tr_detail_tindakan_'+id).toggle()
    }

    $('#daftar_tindakan').on('click','.tombol_hapus_tindakan',function(){
       
        var session_id = $('#session_id').val();
    
        if(confirm('Apakah anda yakin?')){ 
            $(this).html('<i class="fas fa-spinner fa-spin"></i>')
            let idtindakan = $(this).data('idtindakan');
        
            $.post(
                base_url+"pendaftaran/C_Pendaftaran/delTindakanPendaftaran", 
                { 
                    idtindakan : idtindakan, session_id:session_id
                }
            )
            .done(function(data) { 
                LoadViewTindakan(session_id)                               
            })
            .fail(function(err){
                $(this).html('<i class="fas fa-trash"></i>')
                errortoast(err.status);
            });
            $(this).cllist_idest("tr").fadeOut();    
        }
    });
</script>