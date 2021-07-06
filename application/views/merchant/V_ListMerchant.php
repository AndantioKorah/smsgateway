<?php if($result){ ?>
    <div class="col-md-12">
        <table class="table table-hover table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Kode Merchant</th>
                <th>Nama Merchant</th>
                <th>Alamat Merchant</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td align="center"><?=$no++;?></td>
                        <td><?=$rs['kode_merchant'];?></td>
                        <td><?=$rs['nama_merchant'];?></td>
                        <td><?=$rs['alamat'];?></td>
                        <td><?=$rs['contact_person'];?></td>
                        <td><?=$rs['email'];?></td>
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
                responsive: true
            });
            $('[data-tooltip="tooltip"]').tooltip();
        })

        function hapus(id){
            if(confirm('Apakah Anda yakin ingin menghapus data ini ?')){
                $.ajax({
                    url: '<?=base_url("merchant/C_Merchant/deleteMerchant/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        loadMerchant()
                        successtoast('Merchant berhasil dihapus')
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })   
            }
        }
    </script>
<?php } ?>