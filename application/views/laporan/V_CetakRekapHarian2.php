<style>
    @font-face {
        font-family: MerchantCopy;
        src: url('../../assets/fonts/MerchantCopy/MerchantCopy.ttf');
    }

    .font_bill{
        font-family: MerchantCopy !important;
    }
    .header-text{
        font-size: 21px;
    }
    .text-content{
        font-size: 20px;
    }
    .text-footer{
        font-size: 17px;
    }
    .total-text{
        font-size: 20px;
    }
    .total-text-rp{
        font-size: 23px;
    }
    h4{
        font-weight: normal;
    }
    tr.border_bottom_custom td{
        border-bottom: 1px dashed black;
    }
    tr.border_top_custom td{
        border-top: 1px dashed black;
    }
    tr.border_bottom_custom_total td{
        border-bottom: 1px dashed black;
        padding-bottom: 10px;
    }
    tr.border_top_custom_total td{
        border-top: 1px dashed black;
        padding-top: 10px;
    }
    
</style>
<?php if($data_cetak){ foreach($data_cetak as $dc){ ?>
    <table style="width: 58mm;">
        <tr>
            <td style="text-align: center;" colspan=3>
                <h4 style="margin-bottom: 0px;" class="font_bill header-text"><?=NAMA_TOKO?></h4>
            </td>
        </tr>
        <tr class="border_bottom_custom">
            <td style="text-align: center;" colspan=3>
                <h4 style="margin-bottom: 0px;" class="font_bill header-text"><?=ALAMAT_TOKO?></h4>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <p class="text-content font_bill" style="text-align: center"><?=$dc['nomor_transaksi']?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="text-content font_bill" style="text-align: left"><?=$dc['nama']?></p>
            </td>
            <td>
                <p class="text-content font_bill" style="text-align: center"><?=$dc['nomor_meja'] != '' && $dc['nomor_meja'] ? 'Meja: '.$dc['nomor_meja'] : '-' ?></p>
            </td>
            <td>
                <p class="text-content font_bill" style="text-align: right"><?=$dc['jumlah_orang'] != '' && $dc['jumlah_orang'] ? 'Pax: '.$dc['jumlah_orang'] : '-' ?></p>
            </td>
        </tr>
        <tr class="border_bottom_custom">
            <td colspan=2>
                <p class="text-content font_bill"><?=formatDate($dc['tanggal_pembayaran'])?></p>
            </td>
            <td>
                <p class="text-content font_bill" style="text-align: right"><?=$dc['jenis_transaksi'] == 'dine in' ? 'Dine In' : 'Take Away'?></p>
            </td>
        </tr>
        <?php $jumlah_item = 0; $total = 0; if($dc['detail_item']){ foreach($dc['detail_item'] as $rs){
            $catatan='';
            $total += floatval($rs['total']);
            $jumlah_item += $rs['qty'];
            if($rs['catatan']){
                $catatan = '('.$rs['catatan'].')';
            }
        ?>
        <tr>
            <td colspan=3>
                <p class="text-content font_bill" style="text-align: left">
                    <?=$rs['nama_item']?><br><?=$catatan?>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan=2><p class="text-content font_bill" style="text-align: left"><?=$rs['qty'].' X '.formatCurrency($rs['harga_per_item'])?></p></td>
            <td><p class="text-content font_bill" style="text-align: right"><?=formatCurrency($rs['total'])?></p></td>
        </tr>
        <?php } } ?>
        <tr class="border_top_custom_total">
            <td>
                <h4 style="margin-bottom: 0px;" class="font_bill total-text">item</h4>
            </td>
            <td colspan=2 align="right">
                <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=$jumlah_item?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4 style="margin-bottom: 0px;" class="font_bill total-text">sub total</h4>
            </td>
            <td colspan=2 align="right">
                <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=formatCurrency($total)?></h4>
            </td>
        </tr>
        <?php
            $diskon = formatCurrency($dc['diskon_nominal']);
            if($dc['diskon_presentase'] != 0){
                $diskon = $dc['diskon_presentase'].' %'.' ('.formatCurrency($dc['diskon_nominal']).')';
            }
        ?>
        <tr>
            <td>
                <h4 style="margin-bottom: 0px;" class="font_bill total-text">diskon</h4>
            </td>
            <td colspan=2 align="right">
                <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=$diskon?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4 style="margin-bottom: 0px;" class="font_bill total-text">total</h4>
            </td>
            <td colspan=2 align="right">
                <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=formatCurrency($dc['new_total_biaya_after_diskon'])?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4 style="margin-bottom: 0px;" class="font_bill total-text">pembayaran</h4>
            </td>
            <td colspan=2 align="right">
                <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=formatCurrency($dc['jumlah_pembayaran'])?></h4>
            </td>
        </tr>
        <tr class="border_bottom_custom_total">
            <td>
                <h4 style="margin-bottom: 0px;" class="font_bill total-text">kembalian</h4>
            </td>
            <td colspan=2 align="right">
                <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=formatCurrency($dc['kembalian'])?></h4>
            </td>
        </tr>
        <!-- <tr>
            <td colspan="3"><p class="text-footer font_bill">*) printed: <?=date('d/m/Y H:i:s')?></p></td>
        </tr> -->
        <!-- <tr>
            <td colspan="3"><p class="text-footer font_bill">*) by: <?=$this->general_library->getNamaUser()?></p></td>
        </tr> -->
        <tr>
            <td colspan="3"><h4 class="font_bill header-text" style="text-align: center;"><?=TITLES?></h4></td>
        </tr>
    </table>
<?php } } ?>