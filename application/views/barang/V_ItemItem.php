<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Kategori Barang</th>
                <th>Sub Kategori Barang</th>
                <th>Kode Item Barang</th>
                <th>Nama Item Barang</th>
                <th>Harga</th>
                <th>Keterangan</th>
                <th>Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td align="center"><?=$no++;?></td>
                        <td><?=$rs['nama_kategori'];?></td>
                        <td><?=$rs['nama_sub_kategori'];?></td>
                        <td><?=$rs['kode_item'];?></td>
                        <td><?=$rs['nama_item'];?></td>
                        <td><?=formatCurrency($rs['harga']);?></td>
                        <td><?=$rs['keterangan'];?></td>
                        <td>
                            <button type="button" onclick="hapus('<?=$rs['id']?>')" class="btn btn-sm btn-danger" data-tooltip="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                            <!-- <button type="button" onclick="edit('<?=$rs['id']?>')" class="btn btn-sm btn-warning" data-tooltip="tooltip" title="Edit"><i class="fa fa-edit"></i></button> -->
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(function(){
            let table = $('#data_table').DataTable({
                responsive: false
            });
        })

        function hapus(id){
            if(confirm('Apakah Anda yakin ingin menghapus data ini ?')){
                $.ajax({
                    url: '<?=base_url("admin/C_Admin/deleteItembarang/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        loadItem()
                    }, error: function(e){
                        alert('Terjadi Kesalahan')
                    }
                })   
            }
        }
    </script>
<?php } ?>