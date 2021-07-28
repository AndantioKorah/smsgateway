<div class="row p-2" style="border-radius: 10px; border: 1px solid #001f3f; background-color: white; font-color: #001f3f;">
    <?php if($list_pendaftaran){ ?>
        <div class="col-12" style="border-bottom: 1px solid #001f3f;">
            <span style="font-size: 20px; font-weight: bold;">LIST PENDAFTARAN</span>
        </div>
        <div class="col-12 mt-2">
            <table class="table table-sm table-hover table-striped data_table_this">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-left">Tanggal Pendaftaran</th>
                    <th class="text-left">Nomor Pendaftaran</th>
                    <th class="text-left">Status Tagihan</th>
                    <th>Pilihan</th>
                </thead>
                <?php $no = 1; foreach($list_pendaftaran as $l){ ?>
                    <tr style="cursor: pointer;">
                        <td class="text-center align-middle"><?=$no++;?></td>
                        <td class="text-left align-middle"><?=formatDate($l['tanggal_pendaftaran'])?></td>
                        <td class="text-left align-middle"><?=$l['nomor_pendaftaran']?></td>
                        <td class="text-left align-middle"><?=$l['status_tagihan']?></td>
                        <td>
                            <div class="btn-group" role="group">
                                
                                <button id="option_button" type="button" class="btn btn-navy btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilihan
                                </button>
                                <div class="dropdown-menu" aria-labelledby="option_button">
                                <!-- taruh sini yor for menu-menu. iko format di bawah -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#input_tindakan" 
                                onclick="LoadViewInputTindakan('<?=$l['id_t_pendaftaran']?>', 'loadListPendaftaranPasien')"><i class="fa fa-user-md"></i> Input Tindakan</a>
                                <a class="dropdown-item" href="#edit_data_pendaftaran" data-toggle="modal"
                                onclick="openModalEditPendaftaran('<?=$l['id_t_pendaftaran']?>', 'loadListPendaftaranPasien')"><i class="fa fa-edit"></i> Edit Pendaftaran</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <script>
            $(function(){
                $('.data_table_this').DataTable({
                    responsive: false
                });
            })
        </script>
    <?php } else { ?>
        <div class="col-12 text-center">
            <h5><i class="fa fa-exclamation"></i> PASIEN BELUM MELAKUKAN PENDAFTARAN</h5>
        </div>
    <?php } ?>
</div>

<script>

function LoadViewInputTindakan(id = 0, callback = 0){
    $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("pelayanan/C_Pelayanan/loadViewInputTindakan")?>'+'/'+id, function(){
        })
  }



</script>