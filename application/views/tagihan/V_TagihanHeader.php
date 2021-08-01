<style>
    .span_label{
        color: black;
        font-weight: bold;
        font-size: 14px;
    }
</style>
<?php if($tagihan){ ?>
    <input style="display: none;" id="total_tagihan_header" value="<?=formatCurrencyWithoutRp($tagihan['total_tagihan'])?>" />
    <input style="display: none;" id="sisa_tagihan_header" value="<?=formatCurrencyWithoutRp($sisa_harus_bayar)?>" />
    <div class="col text-center">
        <span class="span_label">Total Tagihan:</span><br>
        <h2><?=formatCurrency($tagihan['total_tagihan'])?></h2>
    </div>
    <div class="col text-center">
        <span class="span_label">Total Pembayaran:</span><br>
        <?php if($pembayaran){
            $diskon = null;
            if($pembayaran['diskon_nominal'] && $pembayaran['diskon_nominal'] > 0){
                $diskon = formatCurrency($pembayaran['diskon_nominal']);
                if($pembayaran['diskon_presentase'] && $pembayaran['diskon_presentase'] > 0){
                    $diskon = '('.$pembayaran['diskon_presentase'].'%) '.$diskon;
                }
            }
        ?>
            <h2><?=formatCurrency($pembayaran['jumlah_pembayaran'])?></h2>
            <?php if($diskon){ ?>
                <h6>Diskon : <?=$diskon?></h6>
            <?php } ?>
        <?php } else { ?>
            <h2><?=formatCurrency(0)?></h2>
        <?php } ?>
    </div>
    <div class="col text-center">
        <span class="span_label">Total Uang Muka:</span><br>
        <?php if($uang_muka){ ?>
            <h2><?=formatCurrency($uang_muka['jumlah_pembayaran'])?></h2>
        <?php } else { ?>
            <h2><?=formatCurrency(0)?></h2>
        <?php } ?>
    </div>
    <div class="col text-center">
        <span class="span_label">Sisa Harus Bayar:</span><br>
        <h2><?=formatCurrency($sisa_harus_bayar)?></h2>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-12 text-center">
            <h6><i class="fa fa-exclamation"></i> TAGIHAN TIDAK DITEMUKAN</h6>
        </div>
    </div>
<?php } ?>