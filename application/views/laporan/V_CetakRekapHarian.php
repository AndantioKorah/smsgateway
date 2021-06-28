<style>
    @font-face {
        font-family: MerchantCopy;
        /* src: url('MerchantCopy.ttf') format('ttf'); */
        src: url('../../assets/fonts/MerchantCopy/MerchantCopy.ttf');

    }

    .font_bill{
        font-family: MerchantCopy !important;
    }
    .header-text{
        font-size: 21px;
    }
    .text-content{
        font-size: 21px;
    }
    .text-footer{
        font-size: 19px;
    }
    .total-text{
        font-size: 20px;
    }
    .total-text-rp{
        font-size: 21px;
        font-weight: bold;
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
            <p class="text-content font_bill" style="text-align: center">REKAP:</p>
        </td>
    </tr>
    <tr class="border_bottom_custom">
        <td colspan=3>
            <p class="text-content font_bill" style="text-align: center"><?=$search['range_tanggal']?></p>
        </td>
    </tr>
    <?php $jumlah_item = 0; $total = 0; if($data_cetak){ foreach($data_cetak as $rs){
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
            <h4 style="margin-bottom: 0px;" class="font_bill total-text">jumlah item</h4>
        </td>
        <td colspan=2 align="right">
            <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=$jumlah_item?></h4>
        </td>
    </tr>
    <tr class="border_bottom_custom_total">
        <td>
            <h4 style="margin-bottom: 0px;" class="font_bill total-text">total</h4>
        </td>
        <td colspan=2 align="right">
            <h4 style="margin-bottom: 0px;" class="font_bill total-text-rp"><?=formatCurrency($total)?></h4>
        </td>
    </tr>
    <tr>
        <td colspan="3"><p class="text-footer font_bill">*) printed: <?=date('d/m/Y H:i:s')?></p></td>
    </tr>
    <tr>
        <td colspan="3"><p class="text-footer font_bill">*) by: <?=$this->general_library->getNamaUser()?></p></td>
    </tr>
    <tr class="border_top_custom">
        <td colspan="3"><h4 class="font_bill header-text" style="text-align: center;"><?=TITLES?></h4></td>
    </tr>
</table>