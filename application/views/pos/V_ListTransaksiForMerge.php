<div class="row">
    <div class="col-12">
    <?php if($list_merge){ ?>
        <h6>Transaksi yang sudah digabung : </h6>
        <table class="table table-striped table-hover table-sm data_table_this_for_merge">
            <thead>
            <th class="text-center">No</th>
                <th class="text-center">Nomor Transaksi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Informasi Meja</th>
                <th>Total</th>
                <th class="text-center">Jenis Transaksi</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php
                    foreach($list_merge as $lm){
                    $no = 1;
                    $info_meja = $lm['nama'];

                    if($lm['nomor_meja'] != '' && $lm['nomor_meja']){
                        $info_meja = $info_meja.' / Meja: '.$lm['nomor_meja'];
                    } else {
                        $info_meja = $info_meja.' / -';
                    }

                    if($lm['jumlah_orang'] != '' && $lm['jumlah_orang']){
                        $info_meja = $info_meja.' / '.$lm['jumlah_orang'].' orang';
                    } else {
                        $info_meja = $info_meja.' / -';
                    }
                ?>
                    <tr>
                        <td class="text-center" style="vertical-align: middle;"><?=$no++;?></td>
                        <td class="text-center" style="vertical-align: middle;"><?=$lm['nomor_transaksi']?></td>
                        <td class="text-center" style="vertical-align: middle;"><?=formatDate($lm['tanggal_transaksi'])?></td>
                        <td class="text-center" style="vertical-align: middle;"><?=$info_meja?></td>
                        <td style="vertical-align: middle;"><?=formatCurrency($lm['total_biaya'])?></td>
                        <td class="text-center" style="vertical-align: middle;"><?=$lm['jenis_transaksi']?></td>
                        <td class="text-center" style="vertical-align: middle;"><button onclick="deleteMerge('<?=$lm['id']?>')"
                        class="btn btn-sm btn-danger"><b><i class="fa fa-trash"></i> Hapus</b></button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <!-- <center><h5>Tidak ada data</h5></center> -->
        <?php } ?>
    </div>
    <div class="col-12"><hr></div>
    <div class="col-12">
        <h6>Pilih Transaksi yang akan di Gabung : </h6>
        <?php if($result){ ?>
            <table class="table table-striped table-sm table-hover data_table_this_for_merge">
                <thead>
                <th class="text-center">No</th>
                    <th class="text-center">Nomor Transaksi</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Informasi Meja</th>
                    <th>Total</th>
                    <th class="text-center">Jenis Transaksi</th>
                    <th class="text-center">Pilihan</th>
                </thead>
                <tbody>
                    <?php
                        foreach($result as $rs){
                        $no = 1;
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
                            <td class="text-center" style="vertical-align: middle;"><?=$no++;?></td>
                            <td class="text-center" style="vertical-align: middle;"><?=$rs['nomor_transaksi']?></td>
                            <td class="text-center" style="vertical-align: middle;"><?=formatDate($rs['tanggal_transaksi'])?></td>
                            <td class="text-center" style="vertical-align: middle;"><?=$info_meja?></td>
                            <td style="vertical-align: middle;"><?=formatCurrency($rs['total_biaya'])?></td>
                            <td class="text-center" style="vertical-align: middle;"><?=$rs['jenis_transaksi']?></td>
                            <td class="text-center" style="vertical-align: middle;"><button onclick="mergeBill('<?=$rs['id']?>')"
                            class="btn btn-sm btn-warning"><b><i class="fa fa-retweet"></i> Merge</b></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <center><h5>Tidak ada data</h5></center>
        <?php } ?>
    </div>
</div>
<script>
    $(function(){
        // $('.data_table_this_for_merge').DataTable({
        //         responsive: false
        //     });
    })

    function rupiahkanWithRp(angka){
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp '+ribuan;
    }

    function mergeTabReload(){
        $('#list_transaksi_for_merge').html('')
        $('#list_transaksi_for_merge').append(divLoaderNavy)
        $('#list_transaksi_for_merge').load('<?=base_url("pos/C_Pos/loadTransaksiForMerge/".$current_transaksi['id'])?>', function(){
            $('#laoder').hide()            
        })
    }

    function mergeBill(id){
        if(confirm('Apakah Anda yakin ingin menggabungkan tagihan?')){
            let parent_id = '<?=$current_transaksi['id']?>'
            $.ajax({
                url: '<?=base_url("pos/C_Pos/mergeBill")?>'+'/'+id+'/'+parent_id,
                method: 'post',
                success: function(data){
                    let rs = JSON.parse(data)
                    if(rs.code == 0){
                        reloadListTransaksi()
                        reloadListDetailTransaksi()
                        $('#total_biaya_val').html('<strong>'+rupiahkanWithRp(rs['new_total'])+'</strong>')
                        successtoast(rs.message)
                        mergeTabReload()
                    } else {
                        errortoast(rs.message)
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }
    function deleteMerge(id){
        if(confirm('Apakah Anda yakin ingin menghapus gabungan tagihan?')){
            let parent_id = '<?=$current_transaksi['id']?>'
            $.ajax({
                url: '<?=base_url("pos/C_Pos/deleteMerge")?>'+'/'+id+'/'+parent_id,
                method: 'post',
                success: function(data){
                    let rs = JSON.parse(data)
                    if(rs.code == 0){
                        reloadListTransaksi()
                        reloadListDetailTransaksi()
                        $('#total_biaya_val').html('<strong>'+rupiahkanWithRp(rs['new_total'])+'</strong>')
                        successtoast(rs.message)
                        mergeTabReload()
                    } else {
                        errortoast(rs.message)
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }
</script>