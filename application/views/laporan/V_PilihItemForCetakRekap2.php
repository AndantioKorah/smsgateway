<form id="form_pilih_item" action="<?=base_url('laporan/C_Laporan/saveRekapItem')?>" target="_blank" method="post">
    <div class="row p-3" style="height:calc(100vh - 30px); overflow-y: scroll;">
        <div class="col-12 pb-3">
            <h5>PILIH TRANSAKSI</h5>
            <div class="row">
                <div class="col-12">
                    <div class="icheck-primary d-inline">
                        <input value="semua_transaksi" name="id_transaksi[]" type="checkbox" id="pilih_semua_transaksi" checked>
                        <label for="pilih_semua_transaksi">PILIH SEMUA</label>
                    </div>
                </div>
                <table class="table table-hover table-striped datatablecetakrekap mt-2">
                    <thead>
                        <th class="text-center">No</th>
                        <th class="text-center">Pilih</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Informasi Meja</th>
                        <th>Total Biaya</th>
                        <th class="text-center">Jenis Transaksi</th>
                        <th class="text-center">Status Transaksi</th>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $dine_in = 0; 
                        $take_away = 0; 
                        $aktif = 0; 
                        $belum_lunas = 0; 
                        $lunas = 0;
                        if($transaksi){
                        foreach($transaksi as $rs){ 
                            if($rs['jenis_transaksi'] == 'dine in'){
                                $dine_in++;
                            } else {
                                $take_away++;
                            }

                            if($rs['status'] == 1){
                                $aktif++;
                            } else if($rs['status'] == 2){
                                $lunas++;
                            } else {
                                $belum_lunas++;
                            }

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
                                <td class="text-center"><?=$no++;?></td>
                                <td class="text-center">
                                    <div class="icheck-primary d-inline">
                                        <input value="<?=$rs['id']?>" name="id_transaksi[]" type="checkbox" class="checkbox_transaksi" id="transaksi_<?=$rs['id']?>" checked>
                                        <label for="transaksi_<?=$rs['id']?>"></label>
                                    </div>
                                </td>
                                <td><?=$rs['nomor_transaksi'];?></td>
                                <td><?=formatDate($rs['tanggal_transaksi']);?></td>
                                <td><?=$info_meja?></td>
                                <td><?=formatCurrency($rs['total_biaya'])?></td>
                                <td class="text-center"><?=strtoupper($rs['jenis_transaksi'])?></td>
                                <td class="text-center"><?=getStatusTransaksi($rs['status'])?></td>
                            </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
        <div class="col-12 text-right">
            <button type="submit" id="simpan_rekap_item" class="btn btn-sm btn-navy" accesskey="s"><i class="fa fa-download"></i> SIMPAN REKAP ITEM</button>
            <button type="button" id="cetak_rekap_btn" class="btn btn-sm btn-navy" accesskey="c"><i class="fa fa-print"></i> CETAK REKAP</button>
        </div>
    </div>
</form>

<div id="print_div" style="display:none;"></div>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>

<script>
    $(function(){
        $('.datatablecetakrekap').dataTable({
            "paging": false,
        })
    })

    $('#cetak_rekap_btn').on('click', function(){
        let data_post = $('#form_pilih_item').serialize();
        if(data_post.length == 0){
            errortoast('Parameter tidak boleh kosong')
            return false
        }
        $.ajax({
            url: '<?=base_url('laporan/C_Laporan/createDataRekap2')?>',
            method: 'post',
            data: data_post,
            success: function(data){
                cetakRekap2()
            }, error: function(){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $("#pilih_semua_transaksi").change(function(){ 
        $(".checkbox_transaksi").prop('checked', $(this).prop("checked"));
    });
    $('.checkbox_transaksi').change(function(){ 
        if(false == $(this).prop("checked")){ 
            $("#pilih_semua_transaksi").prop('checked', false);
        }
        if ($('.checkbox_transaksi:checked').length == $('.checkbox_transaksi').length ){
            $("#pilih_semua_transaksi").prop('checked', true);
        }
    });

    $("#pilih_semua_sub_kategori").change(function(){ 
        $(".checkbox_sub_kategori").prop('checked', $(this).prop("checked"));
    });
    $('.checkbox_sub_kategori').change(function(){ 
        if(false == $(this).prop("checked")){ 
            $("#pilih_semua_sub_kategori").prop('checked', false);
        }
        if ($('.checkbox_sub_kategori:checked').length == $('.checkbox_sub_kategori').length ){
            $("#pilih_semua_sub_kategori").prop('checked', true);
        }
    });

    $("#pilih_semua_item").change(function(){ 
        $(".checkbox_item").prop('checked', $(this).prop("checked"));
    });
    $('.checkbox_item').change(function(){ 
        if(false == $(this).prop("checked")){ 
            $("#pilih_semua_item").prop('checked', false);
        }
        if ($('.checkbox_item:checked').length == $('.checkbox_item').length ){
            $("#pilih_semua_item").prop('checked', true);
        }
    });

    function cetakRekap2(){
        $("#print_div").load('<?=base_url('laporan/C_Laporan/cetakRekap2')?>', function(){
            // $('img#kop').on('load', function () {
				printSpace('print_div');
			// })
        })
    }

    function printSpace(elementId) {
		var isi = document.getElementById(elementId).innerHTML;
		window.frames["print_frame"].document.title = document.title;
		window.frames["print_frame"].document.body.innerHTML = isi;
		window.frames["print_frame"].window.focus();
		window.frames["print_frame"].window.print();
	}
</script>