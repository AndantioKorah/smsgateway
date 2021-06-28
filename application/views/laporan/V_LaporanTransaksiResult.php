<?php if($result){ ?>
    <div class="row">
        <div class="col-12 text-center"><h2>LAPORAN TRANSAKSI</h2></div>
        <div class="col-12 text-center"><label><?=$search['range_tanggal']?></label></div>
        <div class="col-12 text-center">Nomor Transaksi: <label><?=$search['nomor_transaksi'] ? $search['nomor_transaksi'] : '-'?></label></div>
        <div class="col-12 text-center">Status Transaksi: <label><?=$search['jenis_transaksi'] == 0 ? 'Semua' : strtoupper($search['jenis_transaksi'])?></label></div>
        <div class="col-12 text-center">Status Transaksi: <label><?=$search['status'] == 0 ? 'Semua' : getStatusTransaksi(strtoupper($search['status']))?></label></div>
        <div class="col-12 text-center">Jumlah Transaksi: <label><?=count($result)?></label></div>
        <div class="col-12 text-center">Jumlah Orang: <label><?=$jumlah_orang?></label></div>
        <div class="col-12 text-center">Total Tagihan: <label><?=formatCurrency($total_tagihan)?></label></div>
        <?php if(USE_PRINT == 1){ ?>
        <div class="col-12 text-right mb-3">
            <form action="<?=base_url('laporan/C_Laporan/printLaporanTransaksi/0')?>" target="_blank">
                    <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save as Excel</button>
            </form>
        </div>
        <?php } ?>
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
            <th class="text-center">Aksi</th>
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
                    <td class="text-center"><button href="#selected_transaksi_modal" data-toggle="modal" class="btn btn-sm btn-navy"
                    onclick="loadSelectedTransaksi('<?=$rs['id']?>')" title="Open Transaksi"><i class="fa fa-edit"></i></button></td>
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