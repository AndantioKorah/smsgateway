<style>
    .main_cetakan_tagihan{
        width: 100%;
        /* font-family: Arial; */
    }
    .div_table_rincian_taghian{
        margin-top: 20px;
        font-size: 14px;
    }

    .table_content_cetak_rincian_tagihan {
        border-collapse: collapse;
        border-bottom: 1px solid black;
    }

    .th_content_cetak_rincian_tagihan, .tr_content_cetak_rincian_tagihan{
        border: 1px solid black;
    }

    .th_cetak_rincian_tagihan, .td_cetak_rincian_tagihan{
        border-right: 1px solid black;
        border-left: 1px solid black;
        padding: 5px;
    }

    .td_cetak_rincian_tagihan_no{
        border: 0;
    }
</style>
<div class="main_cetakan_tagihan" style="font-family: <?=FONT_CETAKAN?>; margin-top: <?=MARGIN_TOP_CETAKAN?>;">
    <?php
        $data['pendaftaran'] = $pendaftaran;
        $this->load->view('cetakan/V_HeaderCetakan', $data);
    ?>
    <div class="div_table_rincian_taghian">
        <table class="table_content_cetak_rincian_tagihan" style="width: 100%;">
            <thead class="tr_content_cetak_rincian_tagihan">
                <th class="th_cetak_rincian_tagihan" style="width: 5%; text-align: center;">NO</th>
                <th class="th_cetak_rincian_tagihan" style="width: 50%;">TAGIHAN</th>
                <th class="th_cetak_rincian_tagihan" style="width: 15%; text-align: center;">BIAYA</th>
                <th class="th_cetak_rincian_tagihan" style="width: 30%; text-align: center;">TANGGAL INPUT</th>
            </thead>
            <tbody class="tbody_rincian_tagihan">
                <?php if($rincian_tagihan){ $no=1; foreach($rincian_tagihan as $rt){ 
                    ?>
                    <tr class="tr_content_cetak_rincian_tagihan">
                        <td class="td_cetak_rincian_tagihan" style="width: 5%; text-align: center;"><a style="font-weight: bold;"><?=$no;?></a></td>
                        <td class="td_cetak_rincian_tagihan" colspan=3 style="width: 95%;"><a style="font-weight: bold;"><?=$rt['nm_jns_tindakan']?></a></td>
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
                        $no_detail_tagihan = 1; foreach($rt['detail_tagihan'] as $dt){ ?>
                        <tr class="tr_content_cetak_rincian_tagihan">
                            <td class="td_cetak_rincian_tagihan_no" style="width: 5%; text-align: center;"><b><?=$no.'.'.$no_detail_tagihan;?></b></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 50%;"><b><?=$dt['nama_tagihan']?></b></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 15%; text-align: center;"><?=formatCurrency($dt['biaya'])?></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 30%; text-align: center;"><?=formatDate($dt['created_date'])?></td>
                        </tr>
                        <?php if($dt['detail_tindakan']){ foreach($dt['detail_tindakan'] as $d) { ?>
                        <tr class="">
                            <td class="td_cetak_rincian_tagihan" style="width: 5%;"></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 50%;"><?=$d?></td>
                            <td class="td_cetak_rincian_tagihan"></td>
                            <td class="td_cetak_rincian_tagihan"></td>
                        </tr>
                        <?php } } $no_detail_tagihan++; } } ?>
                    </tr>
                <?php $no++; } } ?> 
            </tbody>
        </table> 
    </div>
</div>