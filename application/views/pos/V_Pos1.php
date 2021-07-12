<style>
    .card_header:hover{
        background-color: #c1c1c1;
        color: black;
    }
</style>

<div class="row">
    <div class="col-12">
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;">
                    <div class="card card-default">
                        <div class="card-header card_header" style="cursor: pointer;" data-card-widget="collapse">
                            <h3 class="card-title">Buat Transaksi Baru</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form_new_transaction">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Tanggal & Jam</label>
                                        <input class="form-control form-control-sm datetimepickermaxtodaythis realdatetimethis" readonly autocomplete="off" name="tanggal_transaksi" id="tanggal_transaksi"/>
                                    </div>
                                    <div class="col-3">
                                        <label>Nama</label>
                                        <input class="form-control form-control-sm" name="nama" id="nama"/>
                                    </div>
                                    <div class="col-3">
                                        <label>Nomor Meja</label>
                                        <input class="form-control form-control-sm" autocomplete="off" name="nomor_meja" id="nomor_meja"/>
                                    </div>
                                    <div class="col-3">
                                        <label>Jumlah Orang</label>
                                        <input class="form-control form-control-sm" autocomplete="off" name="jumlah_orang" id="jumlah_orang"/>
                                    </div>
                                    <div class="col-9"></div>
                                    <div class="col-3 mt-2 text-right">
                                        <button type="submit" class="btn btn-sm btn-navy"><i class="fas fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                            </form>
                            <form id="cari_transaksi_by_tanggal">
                            <div class="row">
                                <div class="col-12"><hr></div>
                                <div class="col-9">
                                    <label>Tanggal Transaksi</label>
                                    <input id="search_tanggal_transaksi" type="date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>" />
                                </div>
                                <div class="col-3" style="margin-top: 32px;">
                                    <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td rowspan="4" style="width: 60%" class="pl-5" valign="top">
                    <div id="selected_transaksi_div">
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 40%;">
                    <div class="card card-info" style="max-height: 300px; cursor: pointer;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Transaksi Aktif</h3>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6 text-right">search:</div>
                                        <div class="col-5 text-right">
                                            <input class="form-control form-control-sm" id="searchTransaksiAktif" placeholder=""/>
                                        </div>
                                        <div class="col-1 text-right">
                                            <button type="button" class="btn btn-tool" onclick="reloadTransaksiAktif()"><i class="fas fa-sync"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="body_transaksi_aktif" style="overflow-y: scroll; height: 300px;">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 40%;">
                    <div class="card card-success" style="max-height: 300px; cursor: pointer;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Transaksi  Lunas</h3>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6 text-right">search:</div>
                                        <div class="col-5 text-right">
                                            <input class="form-control form-control-sm" id="searchTransaksiLunas" placeholder=""/>
                                        </div>
                                        <div class="col-1 text-right">
                                            <button type="button" class="btn btn-tool" onclick="reloadTransaksiLunas()"><i class="fas fa-sync"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="body_transaksi_lunas" style="overflow-y: scroll; height: 300px;">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 40%;">
                    <div class="card card-danger" style="max-height: 300px; cursor: pointer;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Transaksi Belum Lunas</h3>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6 text-right">search:</div>
                                        <div class="col-5 text-right">
                                            <input class="form-control form-control-sm" id="searchTransaksiBelumLunas" placeholder=""/>
                                        </div>
                                        <div class="col-1 text-right">
                                            <button type="button" class="btn btn-tool" onclick="reloadTransaksiBelumLunas()"><i class="fas fa-sync"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="body_transaksi_belum_lunas" style="overflow-y: scroll; height: 300px;">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="modal fade" id="custom_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-sm">
		<div class="modal-content">
			<div id="custom_modal_content" class="bg-light">
			</div>
		</div>
	</div>
</div>
<script>
    let jenis_diskon = 'nominal'
    let last_id = 0
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var year = today.getFullYear();
    $(function () {
        reloadTransaksiAktif()
        reloadTransaksiLunas()
        reloadTransaksiBelumLunas()
    })

    $('#form_new_transaction').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url('pos/C_Pos/createNewTransaksi')?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#nomor_meja').val('')
                $('#nama').val('')
                $('#jumlah_orang').val('')
                let resp = JSON.parse(data)
                last_id = resp.last_id
                loadSelectedTransaksi(last_id)
                reloadTransaksiAktif()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#cari_transaksi_by_tanggal').on('submit', function(e){
        e.preventDefault()
        let tanggal = $('#search_tanggal_transaksi').val().split("-")
        year = tanggal[0]
        month = tanggal[1]
        day = tanggal[2]
        reloadTransaksiAktif()
        reloadTransaksiLunas()
        reloadTransaksiBelumLunas()
    })

    function loadSelectedTransaksi(id){
        $('#selected_transaksi_div').html('')
        $('#selected_transaksi_div').append('<div class="col-12 text-center text-navy mt-3" id="loader"><i class="fa fa-5x fa-spin fa-spinner"></i></div>')
        $('#selected_transaksi_div').load('<?=base_url("pos/C_Pos/loadSelectedTransaksi")?>'+'/'+id, function(){
            $('#loader').hide()
        })
        last_id = id
        $('.transaksi_hover').removeClass('transaksi_aktif')
        $('#transaksi_div_'+id).addClass('transaksi_aktif')
    }

    function reloadTransaksiAktif(){
        $('#body_transaksi_aktif').html('')
        $('#body_transaksi_aktif').append(cardBodyLoader)
        $('#body_transaksi_aktif').load('<?=base_url("pos/C_Pos/loadTransaksiAktif")?>'+'/'+last_id+'/'+year+'/'+month+'/'+day, function(){
            $('#loader').hide()
        })
    }

    $('#searchTransaksiAktif').on('keyup', function(){
        $('#body_transaksi_aktif').html('')
        $('#body_transaksi_aktif').append(cardBodyLoader)
        $.ajax({
            url: '<?=base_url("pos/C_Pos/searchTransaksiAktif")?>'+'/'+last_id,
            method: 'post',
            data: {
                search: $(this).val(),
                tanggal: day,
                bulan: month,
                tahun: year
            }, success: function(data){
                $('#loader').hide()
                $('#body_transaksi_aktif').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function reloadTransaksiLunas(){
        $('#body_transaksi_lunas').html('')
        $('#body_transaksi_lunas').append(cardBodyLoader)
        $('#body_transaksi_lunas').load('<?=base_url("pos/C_Pos/loadTransaksiLunas")?>'+'/'+last_id+'/'+year+'/'+month+'/'+day, function(){
            $('#loader').hide()
        })
    }

    $('#searchTransaksiLunas').on('keyup', function(){
        $('#body_transaksi_lunas').html('')
        $('#body_transaksi_lunas').append(cardBodyLoader)
        $.ajax({
            url: '<?=base_url("pos/C_Pos/searchTransaksiLunas")?>'+'/'+last_id,
            method: 'post',
            data: {
                search: $(this).val(),
                tanggal: day,
                bulan: month,
                tahun: year
            }, success: function(data){
                $('#loader').hide()
                $('#body_transaksi_lunas').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function reloadTransaksiBelumLunas(){
        $('#body_transaksi_belum_lunas').html('')
        $('#body_transaksi_belum_lunas').append(cardBodyLoader)
        $('#body_transaksi_belum_lunas').load('<?=base_url("pos/C_Pos/loadTransaksiBelumLunas")?>'+'/'+last_id+'/'+year+'/'+month+'/'+day, function(){
            $('#loader').hide()
        })
    }

    $('#searchTransaksiBelumLunas').on('keyup', function(){
        $('#body_transaksi_belum_lunas').html('')
        $('#body_transaksi_belum_lunas').append(cardBodyLoader)
        $.ajax({
            url: '<?=base_url("pos/C_Pos/searchTransaksiBelumLunas")?>'+'/'+last_id,
            method: 'post',
            data: {
                search: $(this).val(),
                tanggal: day,
                bulan: month,
                tahun: year
            }, success: function(data){
                $('#loader').hide()
                $('#body_transaksi_belum_lunas').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>