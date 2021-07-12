<?php if($detail){ ?>
    <div class="col-12 mt-3">
        <table class="table table-hover table-striped data_table_this">
            <thead>
                <th class="text-center">No</th>
                <th>Jenis Pengeluaran</th>
                <th>Harga per Item</th>
                <th>Kuantitas</th>
                <th>Total Harga</th>
                <th>Keterangan</th>
                <th>Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; $total_pengeluaran = 0; foreach($detail as $d){ 
                    $total_pengeluaran += $d['total_harga'];
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=$d['nama_pengeluaran']?></td>
                        <td><?=formatCurrency($d['harga_per_item'])?></td>
                        <td><?=formatCurrencyWithoutRp($d['qty'])?></td>
                        <td><?=formatCurrency($d['total_harga'])?></td>
                        <td><?=$d['keterangan_detail']?></td>
                        <td>
                            <button onclick="hapusDetailPengeluaran('<?=$d['id_detail']?>')" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php } 
                $total_pengeluaran = formatCurrency($total_pengeluaran);
                ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            $('.data_table_this').DataTable({
                responsive: false
            })
            $('#total_pengeluaran').html('TOTAL PENGELUARAN: <strong>'+'<?=$total_pengeluaran?>'+'</strong>')
        })

        function hapusDetailPengeluaran(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("admin/C_Admin/deletePengeluaranDetail")?>'+'/'+id,
                    method: 'post',
                    success: function(data){
                        loadListPengeluaran()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } ?>