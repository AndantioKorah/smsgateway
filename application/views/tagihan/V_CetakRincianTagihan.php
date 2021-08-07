<style>
    .main_cetakan_tagihan{
        width: 100%;
        font-family: Verdana;
    }
    .div_table_rincian_taghian{
        margin-top: 20px;
        font-size: 14px;
    }
</style>
<div class="main_cetakan_tagihan">
    <?php
        $data['pendaftaran'] = $pendaftaran;
        $this->load->view('cetakan/V_HeaderCetakan', $data);
    ?>
    <div class="div_table_rincian_taghian">
        <table style="width: 100%;">
            <thead>
                <th style="width: 5%; text-align: center;">NO</th>
                <th style="width: 50%;">TAGIHAN</th>
                <th style="width: 15%; text-align: left;">BIAYA</th>
                <th style="width: 30%; text-align: center;">TANGGAL INPUT</th>
            </thead>
            <tbody class="tbody_rincian_tagihan">
                <?php if($rincian_tagihan){ $no=1; foreach($rincian_tagihan as $rt){ 
                    ?>
                    <tr>
                        <td style="width: 5%; text-align: center;"><b style="font-size: 18px;"><?=$no++;?></b></td>
                        <td style="width: 50%;"><b style="font-size: 18px;"><?=$rt['nm_jns_tindakan']?></b></td>
                        <td style="width: 15%; text-align: left;"></td>
                        <td style="width: 30%; text-align: left;"></td>
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
                        <tr>
                            <td style="width: 5%;">
                            <td style="width: 50%;"><?=$dt['nama_tagihan']?></td>
                            <td style="width: 15%; text-align: left;"><?=formatCurrency($dt['biaya'])?></td>
                            <td style="width: 30%; text-align: center;"><?=formatDate($dt['created_date'])?></td>
                        </tr>
                        <?php } } ?>
                    </tr>
                <?php } } ?> 
            </tbody>
        </table> 
    </div>
</div>