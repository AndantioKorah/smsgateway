<?php
    $background_header = 'white';
    $header_text = '#001f3f';
    if($transaksi['status'] == 2){
        $background_header = '#001f3f';
        $header_text = 'white';
    } else if($transaksi['status'] == 3){
        $background_header = '#660000';
        $header_text = 'white';
    }
?>
<style>
    .label_header{
        font-size: 15px;
    }

    .label_header_black{
        font-size: 14px;
        color: black;
    }

    .text_tab{
        font-weight: bold;
    }

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
        color: white !important;
        background-color: #001f3f !important;
        border-color: #001f3f #001f3f #fff;
    }
    
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link{
        color: #001f3f !important;
        background-color: #fff !important;
        border-color: #dde2e6 #dde2e6 #dde2e6;
    }

    .label_total{
        font-size: 50px !important;
    }

    .header_transaksi{
        height: auto;
        background-color: <?=$background_header?>;
        color: <?=$header_text?>;
        padding: 15px;
        border-top-left-radius: .2rem;
        border-top-right-radius: .2rem;
        margin-right: -50px !important;
        border-bottom: 1px solid #001f3f;
    }

    .body_transaksi{
        padding: 15px;
    }

</style>
<script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
<?php
    $info_meja = $transaksi['nama'] != '' || $transaksi['nama'] ? $transaksi['nama'] : '-';
    $meja = $transaksi['nomor_meja'] != '' || $transaksi['nomor_meja'] ? 'Meja: '.$transaksi['nomor_meja'] : '-';
    $jumlah_orang = $transaksi['jumlah_orang'] != '' || $transaksi['jumlah_orang'] ? $transaksi['jumlah_orang'].' orang' : '-';
    $info_meja .= ' / '.$meja.' / '.$jumlah_orang;
?>

<div class="col-12 header_transaksi">
    <div class="row">
        <div class="col-3 text-left">
            <span class="label_header">No. Transaksi:</span> 
            <h6><strong><?=$transaksi['nomor_transaksi']?></strong></h6>
        </div>
        <div class="col-3 text-center">
            <span class="label_header">Informasi Meja:</span>
            <h6 id="informasi_meja_val"><strong><?=$info_meja?></strong></h6>
        </div>
        <div class="col-3 text-center">
            <span class="label_header">Status:</span>
            <h6 id="status_val"><strong><?=getStatusTransaksi($transaksi['status']).' / '?><?=$transaksi['jenis_transaksi'] == 'dine in' ? 'Dine In' : 'Take Away'?></strong></h6>
        </div>
        <div class="col-3 text-right">
            <span class="label_header">Tanggal:</span>
            <h6 id="tanggal_transaksi_val"><strong><?=formatDate($transaksi['tanggal_transaksi'])?></strong></h6>
        </div>
    </div>
</div>
<div class="col-12 body_transaksi" style="max-height: 100%; overflow-y: auto;">
    <div class="row">
        <div class="col-6 text-center">
            <span class="label_header_black">Total Tagihan:</span>
            <?php
                $total_biaya = formatCurrency($transaksi['total_biaya']);
                if($pembayaran){
                    $total_biaya = formatCurrency($transaksi['new_total_biaya_after_diskon']);
                }
            ?>
            <h1 id="total_biaya_val" class="label_total"><strong><?=$total_biaya?></strong></h1>
        </div>
        <div class="col-6 text-center">
            <span class="label_header_black">Total Pembayaran:</span>
            <h1 id="total_pembayaran_val" class="label_total"><strong><?=$pembayaran ? formatCurrency($pembayaran['jumlah_pembayaran']) : formatCurrency(0)?></strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-3 text-left mt-3">
            <button onclick="cetakBill()" class="btn btn-block btn-navy" type="button"><i class="fa fa-print"></i> Cetak Bill</button>
        </div>
        <?php if($pembayaran){ ?>
            <div class="col-3 text-left mt-3">
                <button onclick="cetakPembayaran()" class="btn btn-block btn-navy" type="button"><i class="fa fa-print"></i> Cetak Pembayaran</button>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-12">
            <hr>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a data-toggle="tab" class="nav-link active" href="#transaksi_tab"><span class="text_tab">Transaksi</span></a>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" class="nav-link" onclick="loadPembayaran()" href="#pembayaran_tab"><span class="text_tab">Pembayaran</span></a>
                </li>
                <li id="li_edit_tab" class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#edit_tab"><span class="text_tab">Edit</span></a>
                </li>
                <li id="li_delete_tab" class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#delete_tab"><span class="text_tab">Hapus</span></a>
                </li>
                <?php if($transaksi['status'] != 2){ ?>
                <li id="li_merge_tab" class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#merge_tab"><span class="text_tab">Merge</span></a>
                </li>
                <?php } ?>
            </ul>

            <div class="tab-content">
                <div id="transaksi_tab" class="tab-pane active">
                    <form id="detail_transaksi" class="mt-3">
                        <div class="row">
                            <div class="col-4">
                                <label>Pilih Item</label><br>
                                <select class="form-control form-control-sm select2_modal_this select2-navy" style="width: 100%;" 
                                data-dropdown-css-class="select2-navy" id="id_m_item_barang_select">
                                    <option value="0" disabled selected>Pilih Item</option>
                                    <?php if($list_item){ foreach($list_item as $l){ ?>
                                        <option value="<?=$l['id'].';'.formatCurrencyWithoutRp($l['harga'])?>"><?=$l['nama_item'].' ('.formatCurrency($l['harga']).')'?></option>
                                    <?php } } ?>
                                <input style="display: none;" class="form-control form-control-sm" id="id_m_item_barang" name="id_m_item_barang"/>
                                <input style="display: none;" class="form-control form-control-sm" id="id_t_transaksi" name="id_t_transaksi" value="<?=$transaksi['id']?>"/>
                                </select>
                            </div>
                            <div class="col-2">
                                <label>Kuantitas</label>
                                <input type="number" oninput="onTyping()" class="form-control form-control-sm" id="qty" name="qty"/>
                            </div>
                            <div class="col-2">
                                <label>Harga</label>
                                <input type="input" oninput="onTyping()" class="form-control form-control-sm format_currency_this" id="harga_per_item" name="harga_per_item"/>
                            </div>
                            <div class="col-2">
                                <label>Total</label>
                                <input class="form-control form-control-sm" readonly id="total_harga" name="total"/>
                            </div>
                            <div class="col-2">
                                <label>Catatan</label>
                                <input class="form-control form-control-sm" id="catatan" name="catatan"/>
                            </div>
                            <div class="col-10"></div>
                            <div class="col-2 text-right">
                                <br>
                                <button id="btn_tambah_detail_transaksi" type="submit" style="margin-top: 7px;" class="btn btn-navy btn-sm"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3" id="list_detail_transaksi">
                    </div>
                </div>
                <div id="pembayaran_tab" class="tab-pane fade">
                </div>
                <div id="edit_tab" class="tab-pane fade">
                    <form id="form_edit_transaksi">
                        <div class="row mt-3">
                            <div class="col-2">
                                <label>Tanggal & Jam</label>
                                <input class="form-control form-control-sm" autocomplete="off" value="<?=$transaksi['tanggal_transaksi']?>" readonly name="tanggal_transaksi" id="tanggal_transaksi_edit" />
                                <input class="form-control form-control-sm" style="display: none;" autocomplete="off" value="<?=$transaksi['id']?>" readonly name="id" />
                            </div>
                            <div class="col-2">
                                <label>Nama</label>
                                <input class="form-control form-control-sm" value="<?=$transaksi['nama']?>" autocomplete="off" name="nama" id="nama_edit_new" />
                            </div>
                            <div class="col-2">
                                <label>Nomor Meja</label>
                                <input class="form-control form-control-sm" value="<?=$transaksi['nomor_meja']?>" autocomplete="off" name="nomor_meja" id="nomor_meja_edit_new" />
                            </div>
                            <div class="col-2">
                                <label>Jumlah Orang</label>
                                <input class="form-control form-control-sm" value="<?=$transaksi['jumlah_orang']?>" autocomplete="off" name="jumlah_orang" id="jumlah_orang_edit_new" />
                            </div>
                            <div class="col-2">
                                <label>Status Transaksi</label>
                                <select style="width: 100%;" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" value="<?=$transaksi['status']?>" autocomplete="off" name="status" id="status_edit_new">
                                    <option value="1" <?=$transaksi['status'] == '1' ? 'selected' : ''?>>Aktif</option>
                                    <option value="2" <?=$transaksi['status'] == '2' ? 'selected' : ''?>>Lunas</option>
                                    <option value="3" <?=$transaksi['status'] == '3' ? 'selected' : ''?>>Belum Lunas</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label>Jenis Transaksi</label>
                                <select style="width: 100%;" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" autocomplete="off" name="jenis_transaksi" id="jenis_transaksi_edit_new">
                                    <option <?=$transaksi['jenis_transaksi'] == 'dine in' ? 'selected' : ''?> value="dine in">Dine In</option>
                                    <option <?=$transaksi['jenis_transaksi'] == 'take away' ? 'selected' : ''?> value="take away">Take Away</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 text-right">
                                <button id="button_edit_transaksi" type="submit" class="btn btn-sm btn-navy"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="delete_tab" class="tab-pane fade">
                    <form id="delete_form">
                        <div class="row mt-3">
                            <div class="col-6">
                                <label>User Admin:</label>
                                <input class="form-control form-control-sm" autocomplete="off" name="username" id="username_delete" type="input" />
                            </div>
                            <div class="col-6">
                                <label>Password:</label>
                                <input class="form-control form-control-sm" autocomplete="off" name="password" id="password_delete" type="password" />
                            </div>
                            <div class="col-12 text-right mt-3">
                                <label id="loader_hapus" style="display: none;"><i class="fa fa-spin fa-spinner"></i> Menghapus Data. . .</label>
                                <button type="submit" id="btn_hapus_transaksi" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="merge_tab" class="tab-pane fade">
                    <div class="row mt-2">
                        <div class="col-12" id="list_transaksi_for_merge"></div>
                    </div>
                </div>
            </div>
        </div>
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

<div id="print_div" style="display:none;"></div>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>

<script>

    $(function(){
        $('.select2_modal_this').select2({
            dropdownParent: $('#selected_transaksi_modal')
        })

        $('#li_merge_tab').on('click', function(){
            $('#list_transaksi_for_merge').html('')
            $('#list_transaksi_for_merge').append(divLoaderNavy)
            $('#list_transaksi_for_merge').load('<?=base_url("pos/C_Pos/loadTransaksiForMerge/".$transaksi['id'])?>', function(){
                $('#laoder').hide()            
            })
        })
        
        <?php if($pembayaran){ ?>
            $('#btn_tambah_detail_transaksi').hide()
            $('.button_hapus_detail_transaksi').hide()
            $('.button_edit_detail_transaksi').hide()
            $('#button_edit_transaksi').hide()
            $('#btn_hapus_transaksi').hide()
            $('#li_delete_tab').hide()
            $('#li_merge_tab').hide()
            $('#li_edit_tab').hide()
            $('#detail_transaksi').hide()
        <?php } ?>

        $('#tanggal_transaksi_edit').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            endDate: new Date()
        })

        $('.format_currency_this').on('keypress', function(event){
            if(event.charCode >= 48 && event.charCode <= 57){
                return true;
            } else {
                return false;
            }
        })

        function formatRupiah(angka, prefix = "Rp ") {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? rupiah : "";
        }

        $('.format_currency_this').on('keyup', function(){
            $(this).val(formatRupiah($(this).val()))
        })

        reloadListDetailTransaksi()
    })

    function loadPembayaran(){
        $('#pembayaran_tab').html('')
        $('#pembayaran_tab').append(divLoaderNavy)
        $('#pembayaran_tab').load('<?=base_url("pos/C_Pos/loadPembayaran/".$transaksi['id'])?>', function(){
            $('#laoder').hide()            
        })
    }

    function reloadListDetailTransaksi(){
        $('#list_detail_transaksi').html('')
        $('#list_detail_transaksi').append(divLoaderNavy)
        $('#list_detail_transaksi').load('<?=base_url("pos/C_Pos/loadDetailTransaksi/".$transaksi['id'])?>', function(){
            $('#laoder').hide()            
        })
    }

    function rupiahkanWithRp(angka){
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp '+ribuan;
    }

    $('#delete_form').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("login/C_Login/otentikasiUser")?>'+'/'+'delete_transaksi',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp['code'] == 0){
                    errortoast('Kombinasi Username & Password tidak ditemukan atau Username yang Anda masukkan bukan User untuk Admin / Super Admin')
                    $('#loader_hapus').hide()
                    $('#btn_hapus_transaksi').show()
                    return false
                } else if (resp['code'] == 'delete_transaksi'){
                    if(confirm('Apakah Anda yakin ingin menghapus Transaksi?')){
                        $('#loader_hapus').show()
                        $('#btn_hapus_transaksi').hide()
                        $.ajax({
                            url: '<?=base_url("pos/C_Pos/deleteTransaksi")?>'+'/'+'<?=$transaksi['id']?>',
                            method: 'post',
                            data: $(this).serialize(),
                            success: function(data){
                                reloadListTransaksi()
                                // loadSelectedTransaksi('<?=$transaksi['id']?>')
                                $('#selected_transaksi_modal').modal('hide')
                                successtoast('Transaksi Berhasil Dihapus')
                            }, error: function(e){
                                errortoast('Terjadi Kesalahan')
                            }
                        })
                    }
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
        $('#username_delete').val('')
        $('#password_delete').val('')
        $('#loader_hapus').hide()
        $('#btn_hapus_transaksi').show()
    })

    $('#detail_transaksi').on('submit', function(e){
        e.preventDefault()
        if($('#id_m_item_barang_select').val() == 0){
            errortoast('Item belum dipilih')
            return false
        }
        if($('#qty').val() == "" || $('#qty').val() == 0 || $('#qty').val() < 0){
            errortoast('Kuantitas tidak valid')
            return false
        }
        if($('#harga_per_item').val() == "" || $('#harga_per_item').val() == 0 || $('#harga_per_item').val() < 0){
            errortoast('Kuantitas tidak valid')
            return false
        }
        $.ajax({
            url: '<?=base_url("pos/C_Pos/tambahDetailTransaksi")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                $('#total_biaya_val').html('<strong>'+rupiahkanWithRp(resp['new_total_biaya'])+'</strong>')
                $('#label_list_total_biaya_<?=$transaksi['id']?>').html('<strong>'+rupiahkanWithRp(resp['new_total_biaya'])+'</strong>')
                $('#qty').val('')
                $('#catatan').val('')
                $('#total_harga').val(0)
                successtoast('Item baru berhasil ditambahkan')
                reloadListDetailTransaksi()
                reloadListTransaksi()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function rupiahkan(angka){
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }

    function onTyping(){
        let harga = $('#harga_per_item').val().replace(/[^a-zA-Z0-9]/g, '');
        let qty = $('#qty').val()
        let total_harga = harga * qty
        $('#total_harga').val(rupiahkan(total_harga))
    }

    $('#id_m_item_barang_select').on('change', function(){
        $('#qty').val(1)
        let value = $(this).val().split(";")
        let harga = value[1].replace(/[^a-zA-Z0-9]/g, '')
        let qty = $('#qty').val()
        if(qty != ""){
            let total_harga = harga*qty
            $('#total_harga').val(rupiahkan(total_harga))
        } else {
            $('#total_harga').val(0)
        }
        $('#id_m_item_barang').val(value[0])
        $('#harga_per_item').val(value[1])
    })

    $('#form_edit_transaksi').on('submit', function(e){
        e.preventDefault()
        let nama = $('#nama_edit_new').val()
        let nomor_meja = $('#nomor_meja_edit_new').val()
        let jumlah_orang = $('#jumlah_orang_edit_new').val()
        let tanggal_transaksi_edit = $('#tanggal_transaksi_edit').val()
        let status = $('#status_edit_new').val()
        let status_awal = '<?=$transaksi['status']?>'
        let new_status_val = 'Aktif'
        if(status == 2){
            new_status_val = 'Lunas'
        } else if(status == 3){
            new_status_val = 'Belum Lunas'
        }
        $.ajax({
            url: '<?=base_url('pos/C_Pos/editTransaksi')?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                reloadListTransaksi()
                loadSelectedTransaksi('<?=$transaksi['id']?>')
            }, error: function(){
                errortoast('Terjadi Kesalahan. Data Gagal Tersimpan')
                loadSelectedTransaksi('<?=$transaksi['id']?>')
            }
        })
    })

    function successtoast(message = ''){
        const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: timertoast
        });

        Toast.fire({
        icon: 'success',
        title: message
        })
    }

    function errortoast(message = ''){
        const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: timertoast
        });

        Toast.fire({
        icon: 'error',
        title: message
        })
    }

    function warningtoast(message = ''){
        const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: timertoast
        });

        Toast.fire({
        icon: 'warning',
        title: message
        })
    }

    function cetakBill(){
        $("#print_div").load('<?=base_url('pos/C_Pos/cetakBill')?>', function(){
            // $('img#kop').on('load', function () {
				printSpace('print_div');
			// })
        })
    }

    function cetakPembayaran(){
        $("#print_div").load('<?=base_url('pos/C_Pos/cetakPembayaran')?>', function(){
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