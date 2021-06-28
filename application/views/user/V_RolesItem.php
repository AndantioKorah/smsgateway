<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Nama Role</th>
                <th>Role</th>
                <th>Keterangan</th>
                <th>Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td align="center"><?=$no++;?></td>
                        <td><?=$rs['nama'];?></td>
                        <td><?=$rs['role_name'];?></td>
                        <td><?=$rs['keterangan'];?></td>
                        <td>
                            <!-- <button type="button" onclick="hapus('<?=$rs['id']?>')" class="btn btn-sm btn-danger" data-tooltip="tooltip" title="Hapus"><i class="fa fa-trash"></i></button> -->
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
            $('[data-tooltip="tooltip"]').tooltip();
        })

        function hapus(id){
            if(confirm('Apakah Anda yakin ingin menghapus data ini ?')){
                $.ajax({
                    url: '<?=base_url("admin/C_Admin/deleteSubKategori/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        loadSubKategori()
                    }, error: function(e){
                        alert('Terjadi Kesalahan')
                    }
                })   
            }
        }
    </script>
<?php } ?>