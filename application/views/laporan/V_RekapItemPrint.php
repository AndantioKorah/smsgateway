<?php if($list_item){ ?>
    <?php
        $filename = 'Rekap Item '.date('dmYhis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");  
    ?>
    <div class="row">
        <center><h2>REKAP ITEM</h2></center>
        <center><label><?=($search['range_tanggal'])?></label></center>
    </div>
    <table class="table table-hover table-striped datatable">
        <thead>
            <th class="text-center">No</th>
            <th>Nama Item</th>
            <th>Harga Satuan</th>
            <th>Kuantitas</th>
            <th>Total</th>
        </thead>
        <tbody>
            <?php
            $total_seluruh = 0;
            $no = 1; foreach($list_item as $rs){
            $total = 0;
            $total = $rs['jumlah'] * $rs['harga_per_item'];
            $total_seluruh += $total;
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=$rs['nama_item'];?></td>
                    <td><?=$rs['harga_per_item'];?></td>
                    <td><?=$rs['jumlah']?></td>
                    <td><?=$total?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan=4><center><b>TOTAL</b></center></td>
                <td><?=$total_seluruh?></td>
            </tr>
        </tbody>
    </table>
    <!-- <div class="row">
        <div class="col-12 text-right"><?=date('d/m/Y H:i:s')?></div>
        <div class="col-12 text-right"><?=$this->general_library->getNamaUser()?></div>
    </div> -->
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