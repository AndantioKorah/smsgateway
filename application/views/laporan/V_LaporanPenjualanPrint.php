<?php if($result){ ?>
    <?php if($flag_print == 0){
        $filename = 'Laporan Penjualan '.date('dmYhis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");  
    }
    ?>
    <div class="row">
        <center><h2>LAPORAN PENJUALAN</h2></center>
        <center><label><?=$search['range_tanggal']?></label></center>
        <center>Kategori: <label><?=$search['id_m_kategori_barang'] == 0 ? 'Semua' : $result[0]['nama_kategori']?></label></center>
        <center>Sub Kategori: <label><?=$search['id_m_sub_kategori_barang'] == 0 ? 'Semua' : $result[0]['nama_sub_kategori']?></label></center>
        <center>Item: <label><?=$search['id_m_item_barang'] == 0 ? 'Semua' : $result[0]['nama_item']?></label></center>
        <center>Jumlah Item: <label><?=count($result)?></label></center>
        <center>Total Biaya: <label><?=formatCurrency($total_biaya)?></label></center>
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
            <?php $no = 1; foreach($result as $rs){ 
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
    <div class="row">
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