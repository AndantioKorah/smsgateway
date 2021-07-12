<?php if($result){ ?>
    <div class="row">
        <div class="col-12 text-center"><h2>LAPORAN PEMBAYARAN</h2></div>
        <div class="col-12 text-center"><label><?=$search['range_tanggal']?></label></div>
        <div class="col-12 text-center">Nomor Pembayaran: <label><?=$search['nomor_pembayaran'] == "" ? 'Semua' : strtoupper($search['nomor_pembayaran'])?></label></div>
        <div class="col-12 text-center">Nama Pembayar: <label><?=$search['nama_pembayar'] == "" ? 'Semua' : strtoupper($search['nama_pembayar'])?></label></div>
        <div class="col-12 text-center">Cara Bayar: <label><?=$search['cara_bayar'] == '0' ? 'Semua' : strtoupper($search['cara_bayar'])?></label></div>
        <div class="col-12 text-center">Jumlah Transaksi Pembayaran: <label><?=count($result)?></label></div>
        <div class="col-12 text-center">Total Tagihan: <label><?=formatCurrency($total_tagihan)?></label></div>
        <div class="col-12 text-center">Total Pembayaran: <label><?=formatCurrency($total_pembayaran)?></label></div>
        <?php if(USE_PRINT == 1){ ?>
        <div class="col-12 text-right mb-3">
            <form action="<?=base_url('laporan/C_Laporan/printLaporanPembayaran/0')?>" target="_blank">
                    <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save as Excel</button>
            </form>
        </div>
        <?php } ?>
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