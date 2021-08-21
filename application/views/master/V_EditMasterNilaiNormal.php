<?php if($nilai_normal){ ?>
    <form id="form_edit_master_nilai_normal">
        <input style="display: none;" id="id_m_nilai_normal" name="id_m_nilai_normal" value="<?=$nilai_normal['id_m_nilai_normal']?>" />
        <div class="row p-3">
  
            <div class="col-md-9"></div>
            <div class="col-md-4">
                <label>Nama Tindakan</label>
                <input readonly autocomplete="off" id="nama_tindakan"  class="form-control form-control-sm" name="nama_tindakan" value="<?=$nilai_normal['nama_tindakan']?>" />
            </div>

            <div class="col-md-4">
                <label>Jenis Kelamin</label>
                <Select class="form-control " autocomplete="off" name="jenis_kelamin" id="jenis_kelamin" >
                        <option value="">-</option> 
                        <option <?=$nilai_normal['jenis_kelamin'] == 1 ? 'selected' : ''?> value="1">Laki-laki</option>                    
                        <option <?=$nilai_normal['jenis_kelamin'] == 2 ? 'selected' : ''?> value="2">Perempuan</option> 
                        </Select>
            </div>

            <div class="col-md-4">
                <label>Umur</label>
                <input  autocomplete="off" id="umur"  class="form-control form-control-sm" name="umur" value="<?=$nilai_normal['umur']?>" />
            </div>

            <div class="col-md-4">
                <label>Nilai Normal</label>
                <input  autocomplete="off" id="nilai_normal"  class="form-control form-control-sm" name="nilai_normal" value="<?=$nilai_normal['nilai_normal']?>" />
            </div>
           
            <div class="col-md-12"><hr></div>
            <div class="col-md-12 text-right">
                <button type="submit" id="btn_simpan_edit" accesskey="s" class="btn btn-block btn-navy"><i class="fa fa-save"></i> <u>S</u>IMPAN</button>
            </div>
        </div>
    </form>
    <script>

        $('#form_edit_master_nilai_normal').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/editMasterNilaiNormalSubmit")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
            
                            $('#edit_master_nilai_normal').modal('hide')
                            loadMasterNilaiNormal()
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