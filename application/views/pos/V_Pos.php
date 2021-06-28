<style>
    .form-control-transaksi{
        border: 1px solid #b6b1bd;
        border-radius: 5px;
    }

    .form-control-transaksi:focus{
        border: 1px solid #001F3F !important;
        transition: .2s ease-in-out;
    }
</style>
<div class="row">
    <div class="col-8">
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
                        <div class="col-2">
                            <label>Nomor Meja</label>
                            <input class="form-control form-control-sm" autocomplete="off" name="nomor_meja" id="nomor_meja"/>
                        </div>
                        <div class="col-2">
                            <label>Jumlah Orang</label>
                            <input class="form-control form-control-sm" autocomplete="off" name="jumlah_orang" id="jumlah_orang"/>
                        </div>
                        <div class="col-2">
                            <label>Jenis Transaksi</label>
                            <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="jenis_transaksi">
                                <option value="dine in">Dine In</option>
                                <option value="take away">Take Away</option>
                            </select>
                        </div>
                        <div class="col-9"></div>
                        <div class="col-3 mt-2 text-right">
                            <button accesskey="t" type="submit" class="btn btn-sm btn-navy"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card card-default">
            <div class="card-header card_header" style="cursor: pointer;" data-card-widget="collapse">
                <h3 class="card-title">Cari Transaksi</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="cari_transaksi_by_tanggal">
                    <div class="row">
                        <div class="col-12">
                            <label>Tanggal Transaksi</label>
                            <input id="search_tanggal_transaksi" type="date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>" />
                        </div>
                        <div class="col-9"></div>
                        <div class="col-3 mt-2 text-right">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h3 class="card-title" id="list_transaksi_title">List Transaksi</h3>
                    </div>
                    <div class="col-6 text-right">
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-4 text-right">
                                <input oninput="searchTransaksi()" id="searchTransaksi" class="form-control form-control-sm form-control-transaksi" type="search" placeholder="Search" aria-label="Search">
                            </div>
                            <div class="col-2">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" onclick="reloadListTransaksi()" class="btn btn-tool"><i class="fas fa-sync"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row text-center" id="body_transaksi">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="selected_transaksi_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-xl">
		<div class="modal-content">
			<div id="selected_transaksi_div">
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
        reloadListTransaksi()
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
                $('#selected_transaksi_modal').modal('show')
                loadSelectedTransaksi(last_id)
                reloadListTransaksi()
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
        reloadListTransaksi()
    })

    function loadSelectedTransaksi(id){
        $('#selected_transaksi_div').html('')
        $('#selected_transaksi_div').append('<div class="col-12 text-center text-navy mt-3" id="loader"><i class="fa fa-5x fa-spin fa-spinner"></i></div>')
        $('#selected_transaksi_div').load('<?=base_url("pos/C_Pos/loadSelectedTransaksi")?>'+'/'+id, function(){
            $('#loader').hide()
        })
        last_id = id
        // $('.transaksi_hover').removeClass('transaksi_aktif')
        // $('#transaksi_div_'+id).addClass('transaksi_aktif')
    }

    function reloadListTransaksi(){
        $('#body_transaksi').html('')
        $('#body_transaksi').append(divLoaderNavy)
        $('#body_transaksi').load('<?=base_url("pos/C_Pos/reloadListTransaksi")?>'+'/'+last_id+'/'+year+'/'+month+'/'+day, function(){
            $('#loader').hide()
        })
    }

    function searchTransaksi(){
        $('#body_transaksi').html('')
        $('#body_transaksi').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("pos/C_Pos/searchTransaksi")?>'+'/'+last_id,
            method: 'post',
            data: {
                search: $('#searchTransaksi').val(),
                tanggal: day,
                bulan: month,
                tahun: year
            }, success: function(data){
                // $('#loader').hide()
                $('#body_transaksi').html('')
                $('#body_transaksi').html(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>