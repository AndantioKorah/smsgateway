<table class="table table-sm table-hover">
            <thead class="thead_rincian_tindakan">
                <th class="text-center" style="width: 5%;">NO</th>
                <th style="width: 50%;">Tindakan</th>
                <th style="width: 15%;" class="text-left"></th>
               
            </thead>
            <tbody class="tbody_rincian_tindakan">
                <?php if($rincian_tindakan){ $no=1; foreach($rincian_tindakan as $rt){ 
                    ?>
                    <tr style="cursor: pointer;">
                        <td style="width: 5%;" class="text-center"><b style="font-size: 18px;"><?=$no++;?></b></td>
                        <td style="width: 50%;"><b style="font-size: 18px;"><?=$rt['nm_jns_tindakan']?></b></td>
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
                            <td style="width: 50%;"><?=$dt['nama_tindakan']?></td>
                            <td style="width: 30%;" class="text-center"></td>
                        </tr>
                        <?php } } ?>
                       
                    </tr>
                <?php } } else { ?>
                    <tr>
                        <td colspan="4">BELUM ADA DATA</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table> 