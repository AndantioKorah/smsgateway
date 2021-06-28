<?php if($result){ ?>
    <div class="row">
        <div class="col-12 text-center"><h2>LAPORAN PENJUALAN</h2></div>
        <div class="col-12 text-center"><label><?=$search['range_tanggal']?></label></div>
        <div class="col-12 text-center">Kategori: <label><?=$search['id_m_kategori_barang'] == 0 ? 'Semua' : $result[0]['nama_kategori']?></label></div>
        <div class="col-12 text-center">Sub Kategori: <label><?=$search['id_m_sub_kategori_barang'] == 0 ? 'Semua' : $result[0]['nama_sub_kategori']?></label></div>
        <div class="col-12 text-center">Item: <label><?=$search['id_m_item_barang'] == 0 ? 'Semua' : $result[0]['nama_item']?></label></div>
        <div class="col-12 text-center">Jumlah Item: <label id="jumlah_item"></label></div>
        <div class="col-12 text-center">Total Biaya: <label id="total_biaya"></label></div>
        <?php if(USE_PRINT == 1){ ?>
        <div class="col-12 text-right mb-3">
            <form action="<?=base_url('laporan/C_Laporan/printLaporanPenjualan/0')?>" target="_blank">
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
            <th>Tanggal Input</th>
            <th>Nama Item</th>
            <th>Harga Per Item</th>
            <th class="text-center">Qty</th>
            <th>Total Harga</th>
        </thead>
        <tbody>
            <?php $jumlah_item = 0; $total_biaya = 0; $no = 1; foreach($result as $rs){ 
                $total_biaya += floatval($rs['total']);
                $jumlah_item += floatval($rs['qty']);
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=$rs['nomor_transaksi'];?></td>
                    <td><?=formatDate($rs['tanggal_transaksi']);?></td>
                    <td><?=formatDate($rs['tanggal_input_item']);?></td>
                    <td><?=$rs['nama_item']?></td>
                    <td><?=formatCurrency($rs['harga_per_item'])?></td>
                    <td class="text-center"><?=$rs['qty']?></td>
                    <td><?=formatCurrency($rs['total'])?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(function(){
            $('.datatable').DataTable({
                responsive: false
            });
            $('#jumlah_item').html('<?=$jumlah_item?>')
            $('#total_biaya').html('<?=formatCurrency($total_biaya)?>')
        })
    </script>
<?php } else { ?>
    <div class="col-12 text-center"><h4><i class="fa fa-exclamation"></i> DATA TIDAK DITEMUKAN</h4></div>
<?php } ?>