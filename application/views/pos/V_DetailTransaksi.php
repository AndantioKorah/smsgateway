<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-striped table-sm table-hover data_table_this">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Item</th>
                <th class="text-left">Harga per Item</th>
                <th class="text-center">Qty</th>
                <th class="text-left">Total</th>
                <th class="text-left">Catatan</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; $total = 0; foreach($result as $rs){ ?>
                    <tr class=<?=$rs['flag_merge'] == 1 ? "bg-info" : "" ?>>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nama_item']?></td>
                        <td class="text-left"><?=formatCurrency($rs['harga_per_item'])?></td>
                        <td class="text-center"><?=$rs['qty']?></td>
                        <td class="text-left"><?=formatCurrency($rs['total'])?></td>
                        <td class="text-left"><?=$rs['catatan']?></td>
                        <td class="text-center">
                            <button title="hapus" data-toggle="modal" data-target="#custom_modal" onclick="openAuthModal('<?=$rs['id']?>', '<?=$rs['id_t_transaksi']?>', '1')" 
                            class="btn btn-sm btn-danger button_hapus_detail_transaksi"><i class="fa fa-trash"></i></button>
                            <button title="edit" data-toggle="modal" data-target="#custom_modal" onclick="openAuthModal('<?=$rs['id']?>', '<?=$rs['id_t_transaksi']?>', '2')" 
                            class="btn btn-sm btn-warning button_edit_detail_transaksi"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                <?php $total += $rs['total']; } ?>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                    <td colspan="3" class="text-left"><strong><?=formatCurrency($total)?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            // $('.data_table_this').DataTable({
            //     responsive: false
            // });

            <?php if($pembayaran){ ?>
                $('.button_hapus_detail_transaksi').hide()
                $('.button_edit_detail_transaksi').hide()
            <?php } ?>
        })

        function deleteDetailTransaksi(id, id_t_transaksi){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("pos/C_Pos/deleteDetailTransaksi")?>'+'/'+id,
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(data){
                        $('#custom_modal').modal('hide')
                        let resp = JSON.parse(data)
                        $('#total_biaya_val').html('<strong>'+rupiahkanWithRp(resp['new_total_biaya'])+'</strong>')
                        $('#label_list_total_biaya_'+id_t_transaksi).html('<strong>'+rupiahkanWithRp(resp['new_total_biaya'])+'</strong>')
                        successtoast('Item berhasil dihapus')
                        <?php if($flag_kasir == 1){ ?>
                            reloadListTransaksi()
                        <?php } else { ?>
                            $('#form_laporan').submit()
                        <?php } ?>
                        reloadListDetailTransaksi()
                        // loadSelectedTransaksi(id_t_transaksi)
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }

        function updateTransaksi(id, id_t_transaksi){
            $('#custom_modal_content').html('')
            $('#custom_modal_content').append(divLoaderNavy)
            $('#custom_modal_content').load('<?=base_url("pos/C_Pos/modalUpdateItemDetailTransaksi")?>'+'/'+id+'/'+id_t_transaksi, function(){
                $('#loader').hide()
            })
        }

        function openAuthModal(id, id_t_transaksi, jenis_transaksi){
            $('#custom_modal_content').html('')
            $('#custom_modal_content').append(divLoaderNavy)
            $('#custom_modal_content').load('<?=base_url("login/C_Login/openAuthModal")?>'+'/'+id+'/'+id_t_transaksi+'/'+jenis_transaksi, function(){
                $('#loader').hide()
            })
        }
    </script>
<?php } else { ?>
<?php } ?>