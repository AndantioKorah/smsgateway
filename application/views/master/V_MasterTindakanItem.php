<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-sm table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Jenis Pemeriksaan</th>
                <th>Nama Tindakan</th>
                <th>Tarif</th>
                <th>Nilai Normal</th>
                <th>Satuan</th>
                <th>Parent</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td align="center"><?=$no++;?></td>
                        <td><?=$rs['nm_jns_tindakan'];?></td>
                        <td><?=$rs['nama_tindakan'];?></td>
                        <td><?= formatCurrency($rs['biaya']);?></td>
                        <td><?=$rs['nilai_normal'];?></td>
                        <td><?=$rs['satuan'];?></td>
                        <td><?=$rs['nama_tindakan_parent'];?></td>
                        <td class="text-center">
                        <button href="#edit_master_tindakan" data-toggle="modal" class="btn btn-sm btn-navy"
                           onclick="openModalEdiMasterTindakan('<?=$rs['id_tindakan']?>', 'loadMasterTindakan')"><i class="fa fa-edit"></i></button>
                           
                                <button type="button" onclick="hapus('<?=$rs['id_tindakan']?>')" class="btn btn-sm btn-danger" data-tooltip="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                           

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
                    url: '<?=base_url("master/C_Master/deleteMasterTindakan/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(data){
                        let rs = JSON.parse(data)
                        if(rs.code == 0){
                            loadMasterTindakan()
                            successtoast('Tindakan berhasil dihapus')
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