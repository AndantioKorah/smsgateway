<?php if($result){ ?>
    <form id="form_edit_data_pasien">
        <input style="display: none;" id="id_m_pasien" name="id_m_pasien" value="<?=$result['id']?>" />
        <input style="display: none;" id="norm" name="norm" value="<?=$result['norm']?>" />
        <div class="row p-3">
            <div class="col-md-3">
                <h4>NORM: <strong><?=$result['norm']?></strong></h4>
            </div>
            <div class="col-md-9"></div>
            <div class="col-md-4">
                <label>NAMA LENGKAP</label>
                <input require autocomplete="off" id="nama_pasien" style="text-transform:uppercase" class="form-control form-control-sm" name="nama_pasien" value="<?=$result['nama_pasien']?>" />
            </div>
            <div class="col-md-2">
                <label>JENIS KELAMIN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="jenis_kelamin">
                    <option <?=$result['jenis_kelamin'] == "1" ? "selected" : ""?> value="1">LAKI-LAKI</option>
                    <option <?=$result['jenis_kelamin'] == "2" ? "selected" : ""?> value="2">PEREMPUAN</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>TEMPAT LAHIR</label>
                <input autocomplete="off" style="text-transform:uppercase" value="<?=$result['tempat_lahir']?>" class="form-control form-control-sm" name="tempat_lahir" />
            </div>
            <div class="col-md-2">
                <label>TANGGAL LAHIR</label>
                <input autocomplete="off" id="tanggal_lahir" value="<?=formatDateOnlyForEdit2($result['tanggal_lahir'])?>" class="form-control form-control-sm" name="tanggal_lahir" />
            </div>
            <div class="col-md-2">
                <label>GOLONGAN DARAH</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="goldar">
                    <option <?=$result['nama_pasien'] == "0" ? "selected" : ""?> value="0">TIDAK TAHU</option>
                    <?php foreach($golongan_darah as $goldar){ ?>
                        <option <?=$result['nama_pasien'] == $goldar['id'] ? "selected" : ""?> value=<?=$goldar['id'].';'.strtoupper($goldar['golongan_darah'])?>><?=strtoupper($goldar['golongan_darah'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-8">
                <label>ALAMAT DOMISILI</label>
                <input autocomplete="off"  style="text-transform:uppercase" class="form-control form-control-sm" name="alamat" value="<?=$result['alamat']?>" />
            </div>
            <div class="col-md-4">
                <label>NOMOR TELEPON</label>
                <input autocomplete="off" style="text-transform:uppercase" class="form-control form-control-sm" name="nomor_telepon" value="<?=$result['nomor_telepon']?>" />
            </div>
            <div class="col-md-3" style="display: none;">
                <label>PROVINSI</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($provinsi as $prov){ ?>
                        <option <?=$prov['id'] == '71' ? 'selected' : ''?> value=<?=$prov['id']?>><?=strtoupper($prov['nama_provinsi'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3" style="display: none;">
                <label>KABUPATEN/KOTA</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($kota as $kt){ ?>
                        <option <?=$kt['id'] == '7171' ? 'selected' : ''?> value=<?=$kt['id']?>><?=strtoupper($kt['nama_kabupaten_kota'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3" style="display: none;">
                <label>KECAMATAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($kecamatan as $kec){ ?>
                        <option <?=$kec['id'] == '717106' ? 'selected' : ''?> value=<?=$kec['id']?>><?=strtoupper($kec['nama_kecamatan'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3" style="display: none;">
                <label>KELURAHAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($kelurahan as $kel){ ?>
                        <option <?=$kel['id'] == '7171061002' ? 'selected' : ''?> value=<?=$kel['id']?>><?=strtoupper($kel['nama_kelurahan'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-2">
                <label>JENIS IDENTITAS</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="jenis_identitas">
                    <option <?=$result['jenis_identitas'] == "KTP" ? "selected" : ""?> value="KTP">KTP</option>
                    <option <?=$result['jenis_identitas'] == "PASSPORT" ? "selected" : ""?> value="PASSPORT">PASSPORT</option>
                    <option <?=$result['jenis_identitas'] == "LAINNYA" ? "selected" : ""?> value="LAINNYA">LAINNYA</option>
                    <option <?=$result['jenis_identitas'] == "0" ? "selected" : ""?> value="0">TIDAK ADA</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>NOMOR IDENTITAS</label>
                <input autocomplete="off" style="text-transform:uppercase" class="form-control form-control-sm" name="nomor_identitas" value="<?=$result['nomor_identitas']?>" />
            </div>
            <div class="col-md-3">
                <label>KEWARGANEGARAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="warga_negara">
                    <?php foreach($negara as $n){ ?>
                        <option <?=$result['id_m_negara'] == $n['id'] ? "selected" : ""?> value=<?=$n['id'].';'.strtoupper($n['nama_negara'])?>><?=strtoupper($n['nama_negara'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>PEKERJAAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_pekerjaan">
                    <?php foreach($pekerjaan as $p){ ?>
                        <option <?=$result['id_m_pekerjaan'] == $p['id'] ? "selected" : ""?> value=<?=$p['id']?>><?=strtoupper($p['nama_pekerjaan'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-12 text-right">
                <button type="submit" id="btn_simpan_edit" accesskey="s" class="btn btn-block btn-navy"><i class="fa fa-save"></i> <u>S</u>IMPAN</button>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $('.select2_this').select2()

            $("#tanggal_lahir").inputmask("99-99-9999", {
                placeholder: "hh-bb-tttt"
            });
        })

        $('#form_edit_data_pasien').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("pendaftaran/C_Pendaftaran/editDataPasien")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
                        <?php if($callback != '0') { ?>
                            $('#edit_data_pasien').modal('hide')
                            <?=$callback.'('.$result['id'].')'?>
                        <?php } ?>
                   } else {
                       errortoast(res.message)
                   }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })
    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6><i class="fa fa-exclamation"></i> Data tidak ditemukan</h6>
    </div>
<?php } ?>    