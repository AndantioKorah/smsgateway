<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-sm table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Nama Dokter</th>
                <th>Nomor Telepon</th>
                <th>Alamat</th>
                <th>Fee</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td align="center"><?=$no++;?></td>
                        <td><?=$rs['nama_dokter'];?></td>
                        <td><?=$rs['nomor_telepon'];?></td>
                        <td><?=$rs['alamat'];?></td>
                        <td><?=$rs['fee'];?></td>
                        <td class="text-center">
                        <button href="#edit_master_dokter" data-toggle="modal" class="btn btn-sm btn-navy"
                           onclick="openModalEdiMasterDokter('<?=$rs['id']?>', 'loadMasterDokter')"><i class="fa fa-edit"></i></button>
                            <?php if($rs['id'] != $this->session->userdata('active_role_id') && $rs['id'] != 5){ ?>
                                <button type="button" onclick="hapus('<?=$rs['id']?>')" class="btn btn-sm btn-danger" data-tooltip="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                            <?php } ?>

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
                    url: '<?=base_url("master/C_Master/deleteMasterDokter/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(data){
                        let rs = JSON.parse(data)
                        if(rs.code == 0){
                            loadMasterDokter()
                            successtoast('data berhasil dihapus')
                        } else {
                            errortoast(rs.message)
                        }
                    }, error: function(e){
                        alert('Terjadi Kesalahan')
                    }
                })   
            }
        }
    </script>
<?php } ?>