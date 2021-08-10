<style>
    @page {
  size: A4;
  margin-top: 150;
}
    .main_cetakan_tagihan{
        width: 100%;
        /* font-family: Arial; */
    }
    .div_table_rincian_taghian{
        /* margin-top: 20px; */
        font-size: 14px;
    }

    .table_content_cetak_rincian_tagihan {
        border-collapse: collapse;
        border-bottom: 1px solid black;
    }

    .th_content_cetak_rincian_tagihan{
        /* border: 1px solid black; */
    }

    .tr_content_cetak_rincian_tagihan{
        /* border: 1px solid black; */
    }

    .th_cetak_rincian_tagihan, .td_cetak_rincian_tagihan{
        border-right: 1px solid black;
        border-left: 1px solid black;
        padding: 5px;
    }

    .td_cetak_rincian_tagihan_no{
        border: 0;
    }

    #content {
    display: table;
}

#pageFooter {
    display: table-footer-group;
}

#pageFooter:after {
    counter-increment: page;
    content:"Page " counter(page);
    left: 0; 
    top: 100%;
    white-space: nowrap; 
    z-index: 20;
    -moz-border-radius: 5px; 
    -moz-box-shadow: 0px 0px 4px #222;  
    background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);  
  }
</style>
<div class="main_cetakan_tagihan" style="font-family: <?=FONT_CETAKAN?>;">
 
    <div class="div_table_rincian_taghian">
        <table class="table_content_cetak_rincian_tagihan" style="width: 100%;" >
      
        
            <thead class="tr_content_cetak_rincian_tagihan">
            <tr height="200px" style="vertical-align: top;">
                <th colspan="5" sytle="background-color:#000000">
                <?php
        $data['pendaftaran'] = $pendaftaran;
        $this->load->view('cetakan/V_HeaderCetakan', $data);
    ?>
    
                </th>
                </tr>
                <th class="th_cetak_rincian_tagihan" style="width: 5%; text-align: center; border: 1px solid black;">NO</th>
                <th class="th_cetak_rincian_tagihan" style="width: 50%; border: 1px solid black;">PEMERIKSAAN</th>
                <th class="th_cetak_rincian_tagihan" style="width: 15%; border: 1px solid black; text-align: center;">HASIL</th>
                <th class="th_cetak_rincian_tagihan" style="width: 30%; border: 1px solid black; text-align: center;">NILAI NORMAL</th>
                <th class="th_cetak_rincian_tagihan" style="width: 30%; border: 1px solid black; text-align: center;">SATUAN</th>
            </thead>
            <tbody class="tbody_rincian_tagihan">
                <?php if($rincian_tindakan){ $no=1; foreach($rincian_tindakan as $rt){ 
                    ?>
                    <tr class="tr_content_cetak_rincian_tagihan">
                        <td class="td_cetak_rincian_tagihan" style="width: 5%; text-align: center;border: 1px solid black;"><a style="font-weight: bold;"><?=$no;?></a></td>
                        <td class="td_cetak_rincian_tagihan" colspan=4 style="width: 95%;border: 1px solid black;"><a style="font-weight: bold;"><?=$rt['nm_jns_tindakan']?></a></td>
                        <td></td>
                        <?php
                        if($rt['tindakan']){
                        $no_detail_tindakan = 1; foreach($rt['tindakan'] as $dt){ ?>
                        <tr class="tr_content_cetak_rincian_tagihan">
                            <td class="td_cetak_rincian_tagihan_no" style="width: 5%; text-align: center;border: 1px solid black;"><b><?=$no.'.'.$no_detail_tindakan;?></b></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 50%;border: 1px solid black;"><b><?=$dt['nama_tindakan']?></b></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 15%; text-align: center;border: 1px solid black;"> <b><?=$dt['hasil']?></b> </td>
                            <td class="td_cetak_rincian_tagihan" style="width: 30%; text-align: center;border: 1px solid black;"></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 30%; text-align: center;border: 1px solid black;"></td>
                        </tr>
                     
                            <?php if(isset($dt['detail_tindakan'])){ foreach($dt['detail_tindakan'] as $d) { ?>
                        <tr class="">
                            <td class="td_cetak_rincian_tagihan" style="width: 5%;"></td>
                            <td class="td_cetak_rincian_tagihan" style="width: 50%;"><?=$d['nama_tindakan']?></td>
                            <td class="td_cetak_rincian_tagihan" style="text-align: center;"><?=$d['hasil']?></td>
                            <td class="td_cetak_rincian_tagihan" style="text-align: center;"><?=$d['nilai_normal']?></td>
                            <td class="td_cetak_rincian_tagihan" style="text-align: center;"><?=$d['satuan']?></td>
                        </tr>
                        <?php } }  $no_detail_tindakan++; } } ?>
                    </tr>
                <?php $no++; } } ?> 
            </tbody>
        </table> 
        <div id="content">
  <div id="pageFooter">Page </div>
  multi-page content here...
</div>
    </div>
</div>