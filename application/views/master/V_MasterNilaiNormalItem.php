<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-sm table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Nama Tindakan</th>
                <th>Jenis Kelamin</th>
                <th>Umur</th>
                <th>NIlai Normal</th>
                <th>Kategori</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    
                    <tr>
                        <td align="center"><?=$no++;?></td>
                        <td><?=$rs['parent'];?> / <?=$rs['nama_tindakan'];?></td>                        
                        <td>
                            <?php if($rs['jenis_kelamin'] == 1) echo "Laki-laki"; else if($rs['jenis_kelamin']) echo "Perempuan"; else echo ""; ?>
                        </td>
                        <td><?=$rs['umur'];?></td>
                        <td><?=$rs['nilai_normal'];?></td>
                        <td><?=$rs['kategori_pasien'];?></td>
                        <td class="text-center">
                        <button href="#edit_master_nilai_normal" data-toggle="modal" class="btn btn-sm btn-navy"
                           onclick="openModalEdiMasterNilaiNormal('<?=$rs['id_m_nilai_normal']?>')"><i class="fa fa-edit"></i></button>
                           <button type="button" onclick="hapus('<?=$rs['id_m_nilai_normal']?>')" class="btn btn-sm btn-danger" data-tooltip="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
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
                    url: '<?=base_url("master/C_Master/deleteMasterNilaiNormal/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(data){
                        let rs = JSON.parse(data)
                        if(rs.code == 0){
                            loadMasterNilaiNormal()
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