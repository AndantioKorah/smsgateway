<style>
    .transaksi_hover:hover{
        background-color: #cbcdd0;
        color: black;
        cursor: pointer;
        border-radius: 3px;
    }

    .transaksi_aktif{
        background-color: #001f3f;
        color: white;
        border-radius: 3px;
        cursor: pointer;
    }

    .transaksi_aktif:hover{
        color: white;
        background-color: #1a344e !important;
        border-radius: 3px;
        cursor: pointer;
    }
</style>

<?php if($transaksi){ ?>
    <div class="row">
        <?php foreach($transaksi as $t){ ?>
            <div class="col-12 transaksi_hover pl-2 pr-2 pt-2 <?=$t['id'] == $id_active ? 'transaksi_aktif' : ''?>" id="transaksi_div_<?=$t['id']?>" onclick="loadSelectedTransaksi('<?=$t['id']?>')">
                <div class="row">
                    <div class="col-6 text-left">
                        <?php 
                            $label_bot_left = $t['nama'];

                            if($t['nomor_meja'] != '' && $t['nomor_meja']){
                                $label_bot_left = $label_bot_left.' / Meja: '.$t['nomor_meja'];
                            } else {
                                $label_bot_left = $label_bot_left.' / -';
                            }

                            if($t['jumlah_orang'] != '' && $t['jumlah_orang']){
                                $label_bot_left = $label_bot_left.' / '.$t['jumlah_orang'].' orang';
                            } else {
                                $label_bot_left = $label_bot_left.' / -';
                            }
                        ?>
                        <a id="label_list_info_meja_<?=$t['id']?>"><strong><?=$label_bot_left?></strong></a>
                    </div>
                    <div class="col-6 text-right">
                        <strong id="label_list_total_biaya_<?=$t['id']?>"><?=formatCurrency($t['total_biaya'])?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-left">
                        <?=$t['nomor_transaksi']?>
                    </div>
                    <div class="col-6 text-right">
                        <a id="label_list_tanggal_<?=$t['id']?>"><?=formatDate($t['tanggal_transaksi'])?></a>
                    </div>
                </div>
                <hr>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-12 text-center">
            <!-- <h6><i class="fa fa-exclamation"></i> Tidak Ada Data</h6> -->
        </div>
    </div>
<?php } ?>