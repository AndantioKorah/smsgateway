<style>
    @page{
        size: A4;
        margin-top: 150px;
    }

    .format_str{
        mso-number-format:\@;
        font-size: 12px;
        font-family: Verdana;
        font-weight: normal;
        padding: 5px;
        border: 1px solid black;
    }

    .title_print_laporan{
        font-size: 16px;
        font-family: Verdana;
    }

    .title_print_laporan_parameter{
        margin-top: 5px;
        font-size: 14px;
        font-family: Verdana;
        margin-bottom: 10px;
    }
</style>
<?php if($result){ ?>
    <table style="width: 100%;">
        <thead>
            <th>
                <center class="title_print_laporan">LAPORAN FEE DOKTER</center>
                <center class="title_print_laporan_parameter">Range Tanggal: <?=$parameter['range_tanggal']?></center>
            </th>
        </thead>
        <tbody>
            <tr>
                <td>
                <table class="table" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                <thead>
                    <th class="format_str text-center">NO</th>
                    <th class="format_str text-center">NAMA DOKTER</th>
                    <th class="format_str text-center">FEE</th>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $rs){ ?>
                        <tr>
                            <td class="format_str" style="text-align: center;"><?=$no++;?></td>
                            <td class="format_str" style="text-align: left;"><?=$rs['nama_dokter']?></td>
                            <td class="format_str" style="text-align: center;"><?=formatCurrency($rs['total'] * $rs['fee'] / 100)?><a style="display: none; color: white">.</a></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
                </td>
            </tr>
        </tbody>
    </table>
    
<?php } ?>