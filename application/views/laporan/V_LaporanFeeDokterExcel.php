<style>
    .format_str{
        mso-number-format:\@;
        border: 1px solid black;
        padding: 5px;
    }
</style>
<?php if($result){ 
    $filename = 'Laporan Fee Dokter '.date('dmYhis').'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename"); 
?>
    <div class="row">
        <center><strong>LAPORAN FEE DOKTER</strong></center>
        <center>Range Tanggal: <?=$parameter['range_tanggal']?></center>
    </div>
    <table class="table" style="width: 100%; border: 1px solid black;">
        <thead>
            <th class="format_str text-center">NO</th>
            <th class="format_str text-center">NAMA DOKTER</th>
            <th class="format_str text-center">TOTAL</th>
            <th class="format_str text-center">%</th>
            <th class="format_str text-center">FEE</th>
        </thead>
        <tbody>
        <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td class="format_str" style="text-align: center;"><?=$no++;?></td>
                <td class="format_str" style="text-align: left;"><?=$rs['nama_dokter']?></td>
                <td class="format_str" style="text-align: center;"><?=formatCurrency($rs['total'])?></td>
                <td class="format_str" style="text-align: center;"><?=$rs['fee']?>%</td>
                <td class="format_str" style="text-align: center;"><?=formatCurrency($rs['total'] * $rs['fee'] / 100)?></td>
               
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>