<?php if(!$pembayaran){ ?>
    <style>
        .form-control-custom{
            padding: 5px !important;
            height: 55px !important;
            font-size: 50px !important;
            /* border: none; */
            border-bottom: 1px solid #c1c1c1;
            border-radius: 5px;
        }

        .form-control-custom-bigger{
            padding: 5px !important;
            /* height: 85px !important;
            font-size: 80px !important; */
            height: 55px !important;
            font-size: 50px !important;
            /* border: none; */
            border-bottom: 1px solid #c1c1c1;
            border-radius: 5px;
        }

        #diskon_label:hover{
            cursor: pointer;
            color: #072c52;
            background-color: #e9ecef;
            border-radius: 5px;
            padding: 3px;
        }

        .label_pembayaran{
            background-color: #001f3f;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
    <form id="form_pembayaran">
        <div class="row mt-3">
            <div class="col-6 border-right">
                <div class="row">
                    <div class="col-12">
                        <label>Tanggal Pembayaran</label>
                        <input class="form-control realdatetimethis" readonly id="tanggal_pembayaran" name="tanggal_pembayaran" />
                    </div>
                    <div class="col-12">
                        <label>Nama Pembayar</label>
                        <input autocomplete="off" class="form-control" name="nama_pembayar" value="<?=$transaksi['nama']?>" />
                    </div>
                    <div class="col-12">
                        <label>Cara Bayar</label>
                        <select class="form-control select2_pembayaran select2-navy" style="width: 100%" id="cara_bayar" data-dropdown-css-class="select2-navy" name="cara_bayar">
                            <option value="tunai">Tunai</option>
                            <option value="card">Kartu Debit/Credit</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="col-12" id="div_non_tunai" style="display: none;">
                        <label>Nomor Referensi</label>
                        <input autocomplete="off" class="form-control" name="nomor_referensi" />
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <label class="label_pembayaran">Sub Total</label>
                    </div>
                    <div class="col-2">
                        <label style="font-size: 35px;">Rp </label>
                    </div>
                    <div class="col-10">
                        <input id="total_biaya_pemb" autocomplete="off" oninput="countTotalBiaya()" name="new_total_biaya"
                        class="form-control form-control-custom format_currency_this text-right" value="<?=formatCurrencyWithoutRp($transaksi['total_biaya'])?>" />
                    </div>
                    <div class="col-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="label_pembayaran">Diskon</label>
                    </div>
                    <div class="col-2">
                        <label id="diskon_label" style="font-size: 35px;">Rp </label>
                    </div>
                    <div class="col-10">
                        <input id="diskon_nominal" autocomplete="off" oninput="countTotalBiaya()" name="diskon_nominal"
                        class="form-control form-control-custom format_currency_this text-right" placeholder="0" />
                        <input id="diskon_presentase" autocomplete="off" style="display:none" oninput="countTotalBiaya()" name="diskon_presentase"
                        class="form-control form-control-custom text-right" placeholder="%" />
                    </div>
                    <div class="col-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="label_pembayaran">Total Biaya</label>
                    </div>
                    <div class="col-2">
                        <label style="font-size: 35px;">Rp </label>
                    </div>
                    <div class="col-10">
                        <input id="total_biaya_final_pemb" autocomplete="off" readonly name="new_total_biaya_after_diskon"
                        class="form-control form-control-custom-bigger format_currency_this text-right" value="<?=formatCurrencyWithoutRp($transaksi['total_biaya'])?>" />
                    </div>
                    <div class="col-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="label_pembayaran">Jumlah Pembayaran</label>
                    </div>
                    <div class="col-2">
                        <label style="font-size: 35px;">Rp </label>
                    </div>
                    <div class="col-10">
                        <input id="jumlah_pembayaran_pemb" oninput="countSelisih()" autocomplete="off" name="jumlah_pembayaran"
                        class="form-control form-control-custom-bigger format_currency_this text-right" value="<?=formatCurrencyWithoutRp($transaksi['total_biaya'])?>" />
                    </div>
                    <div class="col-12"><hr><div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label id="label_kembalian" class="label_pembayaran">Kembalian</label>
                    </div>
                    <div class="col-2">
                        <label style="font-size: 35px;">Rp </label>
                    </div>
                    <div class="col-10">
                        <input id="kembalian_pemb" readonly autocomplete="off" name="kembalian"
                        class="form-control form-control-custom-bigger format_currency_this text-right" value="0" />
                    </div>
                </div>
                <?php if($transaksi['total_biaya'] > 0){ ?>
                <div class="row">
                    <div class="col-12 mt-3">
                        <button accesskey="b" type="submit" class="btn btn-navy btn-block">BAYAR</button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </form>

    <script>

        $(function(){
            $('.select2_pembayaran').select2()

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
        })
        
        $('#form_pembayaran').on('submit', function(e){
            e.preventDefault()
            let total_biaya_final_pemb = $('#total_biaya_final_pemb').val().split('.').join("")
            let jumlah_pembayaran = $('#jumlah_pembayaran_pemb').val().split('.').join("")
            // console.log('jumlah_pembayaran: '+jumlah_pembayaran)
            // console.log('total_biaya_final_pemb: '+total_biaya_final_pemb)
            // console.log(parseInt(jumlah_pembayaran) < parseInt(total_biaya_final_pemb))
            if(parseInt(jumlah_pembayaran) < parseInt(total_biaya_final_pemb)){
                errortoast('Jumlah Pembayaran tidak boleh kurang dari Total Biaya')
                return false
            }
            $.ajax({
                url: '<?=base_url("pos/C_Pos/createPembayaran")?>'+'/'+'<?=$transaksi['id']?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(data){
                    last_id = '<?=$transaksi['id']?>'
                    <?php if($flag_kasir == 1){ ?>
                        reloadListTransaksi()
                    <?php } else { ?>
                        $('#form_laporan').submit()
                    <?php } ?>
                    loadSelectedTransaksi(last_id)
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

        function countSelisih(){
            let new_selisih = 0
            let total_biaya_final_pemb = $('#total_biaya_final_pemb').val().split('.').join("")
            let jumlah_pembayaran = $('#jumlah_pembayaran_pemb').val().split('.').join("")
            new_selisih = jumlah_pembayaran - total_biaya_final_pemb
            if(new_selisih < 0){
                new_selisih = 0;
                // $('#label_kembalian').html('Sisa Harus Bayar')
            } else {
                // $('#label_kembalian').html('Kembalian')
            }
            $('#kembalian_pemb').val(rupiahkan(new_selisih))
        }

        function countTotalBiaya(){
            let new_total = 0;
            let total_tagihan = $('#total_biaya_pemb').val().split('.').join("")
            let diskon = 0;
            if(jenis_diskon == 'nominal'){
                diskon = $('#diskon_nominal').val().split('.').join("")
                new_total = total_tagihan - diskon
            } else {
                diskon = $('#diskon_presentase').val()
                diskon = (diskon * total_tagihan) / 100
                new_total = total_tagihan - diskon
            }
            if(new_total < 0 || diskon > new_total){
                new_total = 0
            }
            
            $('#kembalian_pemb').val(rupiahkan(0))
            $('#jumlah_pembayaran_pemb').val(rupiahkan(new_total))
            $('#total_biaya_final_pemb').val(rupiahkan(new_total))
        }

        function rupiahkan(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }

        function rupiahkanWithRp(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp '+ribuan;
        }

        $('#diskon_label').on('click', function(){
            if(jenis_diskon == 'nominal'){
                jenis_diskon = 'presentase'
                $(this).html('%')
                $('#diskon_nominal').val('')
                $('#diskon_presentase').val('')
                $('#diskon_nominal').hide()
                $('#diskon_presentase').show()
                $('#jumlah_pembayaran_pemb').val($('#total_biaya_pemb').val())
                $('#total_biaya_final_pemb').val($('#total_biaya_pemb').val())
                $('#kembalian_pemb').val(rupiahkan(0))
            } else {
                jenis_diskon = 'nominal'
                $(this).html('Rp')
                $('#diskon_nominal').val('')
                $('#diskon_presentase').val('')
                $('#diskon_nominal').show()
                $('#diskon_presentase').hide()
                $('#total_biaya_final_pemb').val($('#total_biaya_pemb').val())
                $('#jumlah_pembayaran_pemb').val($('#total_biaya_pemb').val())
                $('#kembalian_pemb').val(rupiahkan(0))
            }
        })

        $('#tanggal_pembayaran').datetimepicker({
            format: 'yyyy-mm-dd hh:mm:ss',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            endDate: new Date()
        })

        $('#tanggal_pembayaran').on('changeDate', function (ev) {
            $(this).removeClass('realdatetimethis')
        });

        $('#tanggal_pembayaran').on('click', function (ev) {
            $(this).addClass('realdatetimethis')
        });

        $('#cara_bayar').on('change', function(){
            let val = $(this).val()
            if(val == 'tunai'){
                $('#div_non_tunai').hide()
            } else {
                $('#div_non_tunai').show()
            }
        })
    </script>
<?php } else { ?>
    <style>
    .form-control-custom{
            padding: 5px !important;
            height: 30px !important;
            font-size: 25px !important;
            border: none;
            border-bottom: 1px solid #c1c1c1;
            border-radius: 0px;
            background-color: white !important;
        }
    </style>
    <div class="mt-3">
        <div class="row">
            <div class="col-3">
                <label>Nomor Pembayaran</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <h5><?=$pembayaran['nomor_transaksi']?></h5>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <label>Tanggal Pembayaran</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input readonly class="form-control-custom form-control" value="<?=formatDate($pembayaran['tanggal_pembayaran'])?>" />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <label>Nama Pembayar</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input readonly class="form-control-custom form-control" value="<?=($pembayaran['nama_pembayar'])?>" />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <label>Cara Bayar</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input readonly class="form-control-custom form-control" value="<?=strtoupper($pembayaran['cara_bayar'])?>" />
            </div>
        </div>
        <?php if($pembayaran['cara_bayar'] != 'tunai'){ ?>
            <div class="row mt-2">
                <div class="col-3">
                    <label>Nomor Referensi</label>
                </div>
                <div class="col-1">:</div>
                <div class="col-8">
                    <input readonly class="form-control-custom form-control" value="<?=($pembayaran['nomor_referensi'])?>" />
                </div>
            </div>
        <?php } ?>
        <div class="row mt-2">
            <div class="col-3">
                <label>Jumlah Pembayaran</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input readonly class="form-control-custom form-control text-right" value="<?=formatCurrency($pembayaran['jumlah_pembayaran'])?>" />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <label>Diskon</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <?php
                    $diskon = formatCurrency($pembayaran['diskon_nominal']);
                    if($pembayaran['diskon_presentase'] != 0){
                        $diskon = $pembayaran['diskon_presentase'].' %'.' ('.formatCurrency($pembayaran['diskon_nominal']).')';
                    }
                ?>
                <input readonly class="form-control-custom form-control text-right" value="<?=$diskon?>" />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <label>Kembalian</label>
            </div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input readonly class="form-control-custom form-control text-right" value="<?=formatCurrency($pembayaran['kembalian'])?>" />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-9"></div>
            <div class="col-3 text-right">
                <button id="btn_hapus_pembayaran" class="btn btn-block btn-danger"><i class="fa fa-trash"></i> Hapus Pembayaran</button>
            </div>
        </div>
        <div class="row" id="hapus_pembayaran_div" style="display: none;">
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
            <form id="form_delete_pembayaran">
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
                        <label id="loader_hapus_pembayaran" style="display: none;"><i class="fa fa-spin fa-spinner"></i> Menghapus Data. . .</label>
                        <button type="submit" id="btn_hapus_pembayaran" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <script>
        $('#btn_hapus_pembayaran').on('click', function(){
            $('#hapus_pembayaran_div').toggle({
                height: true
            })
        })

        $('#form_delete_pembayaran').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("login/C_Login/otentikasiUser")?>'+'/'+'delete_pembayaran',
                method: 'post',
                data: $(this).serialize(),
                success: function(data){
                    let resp = JSON.parse(data)
                    if(resp['code'] == 0){
                        errortoast('Kombinasi Username & Password tidak ditemukan atau Username yang Anda masukkan bukan User untuk Admin / Super Admin')
                        $('#loader_hapus_pembayaran').hide()
                        $('#btn_hapus_pembayaran').show()
                        return false
                    } else if (resp['code'] == 'delete_pembayaran'){
                        if(confirm('Apakah Anda yakin ingin menghapus Pembayaran?')){
                            $('#loader_hapus_pembayaran').show()
                            $('#btn_hapus_pembayaran').hide()
                            $.ajax({
                                url: '<?=base_url("pos/C_Pos/deletePembayaran")?>'+'/'+'<?=$pembayaran['id']?>'+'/'+'<?=$transaksi['id']?>',
                                method: 'post',
                                data: $(this).serialize(),
                                success: function(data){
                                    successtoast('Pembayaran Berhasil Dihapus')
                                    <?php if($flag_kasir == 1){ ?>
                                        reloadListTransaksi()
                                    <?php } else { ?>
                                        $('#form_laporan').submit()
                                    <?php } ?>
                                    loadSelectedTransaksi('<?=$transaksi['id']?>')
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
        })
    </script>
<?php } ?>