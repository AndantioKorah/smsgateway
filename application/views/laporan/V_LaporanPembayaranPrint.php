<?php if($result){ ?>
    <?php if($flag_print == 0){
        $filename = 'Laporan Pembayaran '.date('dmYhis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");  
    }
    ?>
    <div class="row">
        <center><h2>LAPORAN PEMBAYARAN</h2></center>
        <center><label><?=$search['range_tanggal']?></label></center>
        <center>Nomor Pembayaran: <label><?=$search['nomor_pembayaran'] == "" ? 'Semua' : strtoupper($search['nomor_pembayaran'])?></label></center>
        <center>Nama Pembayar: <label><?=$search['nama_pembayar'] == "" ? 'Semua' : strtoupper($search['nama_pembayar'])?></label></center>
        <center>Cara Bayar: <label><?=$search['cara_bayar'] == '0' ? 'Semua' : strtoupper($search['cara_bayar'])?></label></center>
        <center>Total Transaksi Pembayaran: <label><?=count($result)?></label></center>
        <center>Total Tagihan: <label><?=formatCurrency($total_tagihan)?></label></center>
        <center>Total Pembayaran: <label><?=formatCurrency($total_pembayaran)?></label></center>
    </div>
    <table class="table table-hover table-striped datatable">
        <thead>
            <th class="text-center">No</th>
            <th>Nomor Transaksi</th>
            <th>Tanggal Pembayaran</th>
            <th>Nomor Pembayaran</th>
            <th>Nama Pembayar</th>
            <th>Cara Bayar</th>
            <th>Total Tagihan</th>
            <th>Diskon</th>
            <th>Jumlah Pembayaran</th>
            <th>Kembalian</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){
                $cara_bayar = strtoupper($rs['cara_bayar']);
                if($rs['cara_bayar'] != 'tunai'){
                    $cara_bayar = strtoupper($rs['cara_bayar']).' ('.$rs['nomor_referensi'].')';
                }

                $diskon = formatCurrency($rs['diskon_nominal']);
                if($rs['diskon_presentase'] != 0){
                    $diskon = $rs['diskon_presentase'].' %'.' ('.formatCurrency($rs['diskon_nominal']).')';
                }
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=$rs['nomor_transaksi']?></td>
                    <td><?=formatDate($rs['tanggal_pembayaran'])?></td>
                    <td><?=$rs['nomor_pembayaran']?></td>
                    <td><?=$rs['nama_pembayar']?></td>
                    <td><?=$cara_bayar?></td>
                    <td><?=formatCurrency($rs['total_biaya'])?></td>
                    <td><?=$diskon?></td>
                    <td><?=formatCurrency($rs['jumlah_pembayaran'])?></td>
                    <td><?=formatCurrency($rs['kembalian'])?></td>
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