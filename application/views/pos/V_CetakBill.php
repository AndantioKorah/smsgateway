<style>
    @font-face {
        font-family: MerchantCopy;
        src: url('assets/fonts/MerchantCopy/MerchantCopy.ttf');
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
    tr.border_bottom_top_custom td{
        border-bottom: 1px dashed black;
        border-top: 1px dashed black;
        padding-top: 10px; 
        padding-bottom: 10px;
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
            <p class="text-content font_bill" style="text-align: center"><?=$transaksi['nomor_transaksi']?></p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="text-content font_bill" style="text-align: left"><?=$transaksi['nama']?></p>
        </td>
        <td>
            <p class="text-content font_bill" style="text-align: center"><?=$transaksi['nomor_meja'] != '' && $transaksi['nomor_meja'] ? 'Meja: '.$transaksi['nomor_meja'] : '-' ?></p>
        </td>
        <td>
            <p class="text-content font_bill" style="text-align: right"><?=$transaksi['jumlah_orang'] != '' && $transaksi['jumlah_orang'] ? 'Pax: '.$transaksi['jumlah_orang'] : '-' ?></p>
        </td>
    </tr>
    <tr class="border_bottom_custom">
        <td colspan=2>
            <p class="text-content font_bill"><?=formatDate($transaksi['tanggal_transaksi'])?></p>
        </td>
        <td>
            <p class="text-content font_bill" style="text-align: right"><?=$transaksi['jenis_transaksi'] == 'dine in' ? 'Dine In' : 'Take Away'?></p>
        </td>
    </tr>
    <?php $jumlah_item = 0; $total = 0; if($result){ foreach($result as $rs){
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
        <td style="width: 25%">
            <h4 style="margin-bottom: 0px;" class="font_bill total-text">item</h4>
        </td>
        <td colspan=2 align="right" style="width: 75%">
            <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=$jumlah_item?></h4>
        </td>
    </tr>
    <tr class="border_bottom_custom_total">
        <td style="width: 25%">
            <h4 style="margin-bottom: 0px;" class="font_bill total-text">total</h4>
        </td>
        <td colspan=2 align="right" style="width: 75%">
            <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=formatCurrency($total)?></h4>
        </td>
    </tr>
    <!-- <tr>
        <td colspan="3"><p class="text-footer font_bill">*) struk ini bukan bukti pembayaran</p></td>
    </tr> -->
    <tr>
        <td colspan="3"><p class="text-footer font_bill">*) printed: <?=date('d/m/Y H:i:s')?></p></td>
    </tr>
    <tr>
        <td colspan="3"><p class="text-footer font_bill">*) by: <?=$this->general_library->getNamaUser()?></p></td>
    </tr>
    <!-- <tr class="border_top_custom">
        <td colspan="3"><h4 class="font_bill header-text" style="text-align: center;"><?=TITLES?></h4></td>
    </tr> -->
</table>