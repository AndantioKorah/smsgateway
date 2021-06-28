<style>
    .transaksi_hover:hover {
        cursor: pointer;
        border-radius: .25rem;
        transform: scale(1.1);
        position: relative;
        box-shadow: 0 0 25px #001f3f, 0 0 25px #001f3f, 0 0 25px #001f3f;
        z-index: 1;
        transition: .2s ease-in-out;
    }

    .label_p{
        color: black;
        font-size: 15px !important;
    }

    .custom_label{
        font-size: 35px;
    }

    .card-success{
        background-color : #001f3f !important;
    }

    .card-danger{
        background-color : #660000 !important;
    }
</style>

<?php
    if($transaksi){ 
        foreach($transaksi as $t){
        $card_header_style = 'card-default';
        $card_header_text = '';
        if($t['status'] == '2'){
            $card_header_style = 'card-success';
            $card_header_text = 'text-white';
        } else if ($t['status'] == '3'){
            $card_header_style = 'card-danger';
            $card_header_text = 'text-white';
        }
?>
    
    <div class="col-3 div_transaksi" data-toggle="modal" data-target="#selected_transaksi_modal" id='<?=$t['id']?>'>
        <div class="row">
            <div class="col-12">
                <div class="card transaksi_hover">
                    <div class="card-header <?=$card_header_style?>">
                        <div class="row">
                            <div class="col-9">
                                <h3 class="card-title change_this_text <?=$card_header_text?>"><?=strtoupper(getStatusTransaksi($t['status'])).' / '?><?=strtoupper($t['jenis_transaksi'])?></h3>
                            </div>
                            <div class="col-3 text-right">
                                <!-- <?php if($t['status'] != 2){ 
                                    $btn_color = 'btn-navy';
                                    if($t['status'] == 3){
                                        $btn_color = 'btn-light';
                                    }
                                ?>
                                    <button onclick="alert(haii)" class="btn <?=$btn_color?> btn-sm" data-tooltip="tooltip" title="Gabung Bill" data-placement="left"><i class="fa fa-object-group"></i></button>
                                <?php } ?> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-inline-flex" style="padding-top: 22px;">
                                <label class="change_this_text">Rp</label>
                                <label class="custom_label change_this_text"><?=formatCurrencyWithoutRp($t['total_biaya'])?></label>
                            </div>
                            <div class="col-6 text-right">
                                <label class="change_this_text" style="height: 0px; font-weight: bold"><?=$t['nama']?></label><br>
                                <label class="change_this_text" style="height: 0px;">Meja: <?=$t['nomor_meja'] ? $t['nomor_meja'] : '-'?></label><br>
                                <label class="change_this_text" style="height: 0px;"><?=$t['jumlah_orang'] ? $t['jumlah_orang'].' orang': '-'?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6 text-left">
                                <p class="label_p change_this_text"><?=$t['nomor_transaksi']?></p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="label_p change_this_text"><?=formatDate($t['tanggal_transaksi'])?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $(function(){
        $('[data-tooltip="tooltip"]').tooltip()

        $('#list_transaksi_title').html('<strong>List Transaksi ('+'<?=count($transaksi)?>'+')</strong>')
    })

    $('.div_transaksi').on('click', function(){
        let id = $(this).attr('id')
        loadSelectedTransaksi(id)
    })
</script>
<?php } else {?>
<?php } ?>