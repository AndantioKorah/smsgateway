<?php if($result){ ?>
    <?php if($flag_print == 0){
        $filename = 'Laporan Transaksi '.date('dmYhis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");  
    }
    ?>
    <div class="row">
        <center><h2>LAPORAN TRANSAKSI</h2></center>
        <center><label><?=$search['range_tanggal']?></label></center>
        <center>Nomor Transaksi: <label><?=$search['nomor_transaksi'] ? $search['nomor_transaksi'] : '-'?></label></center>
        <center>Status Transaksi: <label><?=$search['jenis_transaksi'] == 0 ? 'Semua' : strtoupper($search['jenis_transaksi'])?></label></center>
        <center>Status Transaksi: <label><?=$search['status'] == 0 ? 'Semua' : getStatusTransaksi(strtoupper($search['status']))?></label></center>
        <center>Jumlah Transaksi: <label><?=count($result)?></label></center>
        <center>Jumlah Orang: <label><?=$jumlah_orang?></label></center>
        <center>Total Tagihan: <label><?=formatCurrency($total_tagihan)?></label></center>
    </div>
    <table class="table table-hover table-striped datatable">
        <thead>
            <th class="text-center">No</th>
            <th>Nomor Transaksi</th>
            <th>Tanggal Transaksi</th>
            <th>Informasi Meja</th>
            <th>Total Biaya</th>
            <th class="text-center">Jenis Transaksi</th>
            <th class="text-center">Status Transaksi</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ 
                $info_meja = $rs['nama'];

                if($rs['nomor_meja'] != '' && $rs['nomor_meja']){
                    $info_meja = $info_meja.' / Meja: '.$rs['nomor_meja'];
                } else {
                    $info_meja = $info_meja.' / -';
                }

                if($rs['jumlah_orang'] != '' && $rs['jumlah_orang']){
                    $info_meja = $info_meja.' / '.$rs['jumlah_orang'].' orang';
                } else {
                    $info_meja = $info_meja.' / -';
                }
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=$rs['nomor_transaksi'];?></td>
                    <td><?=formatDate($rs['tanggal_transaksi']);?></td>
                    <td><?=$info_meja?></td>
                    <td><?=formatCurrency($rs['total_biaya'])?></td>
                    <td class="text-center"><?=strtoupper($rs['jenis_transaksi'])?></td>
                    <td class="text-center"><?=getStatusTransaksi($rs['status'])?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="row">
        <br><br>
        <div class="col-12 text-right"><?=date('d/m/Y H:i:s')?></div>
        <div class="col-12 text-right"><?=$this->general_library->getNamaUser()?></div>
    </div>
    <script>
        $(function(){
            $('.datatable').DataTable({
                responsive: false
            });
        })
    </script>
<?php } else { ?>
    <div class="col-12 text-center"><h4><i class="fa fa-exclamation"></i> DATA TIDAK DITEMUKAN</h4></div>
<?php } ?>