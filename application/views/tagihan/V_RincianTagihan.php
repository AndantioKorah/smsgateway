<style>
    .tbody_rincian_tagihan {
        display:block;
        max-height:350px;
        overflow:auto;
    }
    .thead_rincian_tagihan, .tbody_rincian_tagihan tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    .thead_rincian_tagihan {
        width: calc( 100% - 1em )
    }
</style>
<div class="row">
    <div class="col-12 mt-3 mb-3 text-left">
        <button class="btn btn-sm btn-navy"><i class="fa fa-print"></i> Cetak Rincian Tagihan</button>
    </div>
    <div class="col-12">
        <table class="table table-sm table-hover">
            <thead class="thead_rincian_tagihan">
                <th class="text-center" style="width: 5%;">NO</th>
                <th style="width: 50%;">TAGIHAN</th>
                <th style="width: 15%;" class="text-left">BIAYA</th>
                <th style="width: 30%;" class="text-center">TANGGAL INPUT</th>
            </thead>
            <tbody class="tbody_rincian_tagihan">
                <?php if($rincian_tagihan){ $no=1; foreach($rincian_tagihan as $rt){ 
                    ?>
                    <tr style="cursor: pointer;">
                        <td style="width: 5%;" class="text-center"><b style="font-size: 18px;"><?=$no++;?></b></td>
                        <td style="width: 50%;"><b style="font-size: 18px;"><?=$rt['nm_jns_tindakan']?></b></td>
                        <td style="width: 15%;" class="text-left"></td>
                        <td style="width: 30%;" class="text-center"></td>
                        <?php
                        if($rt['detail_tagihan']){
                            usort($rt['detail_tagihan'], function($a, $b) {
                                $ad = new DateTime($a['created_date']);
                                $bd = new DateTime($b['created_date']);
                                if ($ad == $bd) {
                                    return 0;
                                }
                                return $ad > $bd ? -1 : 1;
                            });
                        foreach($rt['detail_tagihan'] as $dt){ ?>
                        <tr style="cursor: pointer;">
                            <td style="width: 5%;">
                            <td style="width: 50%;"><?=$dt['nama_tagihan']?></td>
                            <td style="width: 15%;" class="text-left"><?=formatCurrency($dt['biaya'])?></td>
                            <td style="width: 30%;" class="text-center"><?=formatDate($dt['created_date'])?></td>
                        </tr>
                        <?php } } ?>
                        <tr>
                            <td style="width: 5%;">
                            <td style="width: 50%;" class="text-right"><b style="font-size: 18px;">TOTAL <?=$rt['nm_jns_tindakan']?> :</b></td>
                            <td style="width: 15%;" class="text-left"><b style="font-size: 18px;"><?=formatCurrency($rt['total_biaya'])?></b></td>
                            <td style="width: 30%;" class="text-center"></td>
                        </tr>
                    </tr>
                <?php } } else { ?>
                    <tr>
                        <td colspan="4">BELUM ADA DATA</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table> 
    </div>
</div>