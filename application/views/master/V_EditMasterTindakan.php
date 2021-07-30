<?php if($tindakan){ ?>
    <form id="form_edit_master_tindakan">
        <input style="display: none;" id="id_tindakan" name="id_tindakan" value="<?=$tindakan['id_tindakan']?>" />
        <div class="row p-3">
            <div class="col-md-12">
                <h4>Jenis Pemeriksaan: <?=$tindakan['nm_jns_tindakan']?></h4>
            </div>
            <div class="col-md-9"></div>
            <div class="col-md-4">
                <label>Nama Tindakan</label>
                <input require autocomplete="off" id="nama_tindakan"  class="form-control form-control-sm" name="nama_tindakan" value="<?=$tindakan['nama_tindakan']?>" />
            </div>

            <div class="col-md-4">
                <label>Tarif</label>
                <input require autocomplete="off" id="biaya"  class="form-control form-control-sm" name="biaya" value="<?=$tindakan['biaya']?>" />
            </div>

            <div class="col-md-4">
                <label>Nilai Normal</label>
                <input  autocomplete="off" id="nilai_normal"  class="form-control form-control-sm" name="nilai_normal" value="<?=$tindakan['nilai_normal']?>" />
            </div>

            <div class="col-md-4">
                <label>Satuan</label>
                <input  autocomplete="off" id="satuan"  class="form-control form-control-sm" name="satuan" value="<?=$tindakan['satuan']?>" />
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

        $('#form_edit_master_tindakan').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/editMasterTindakanSubmit")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
            
                            $('#edit_master_tindakan').modal('hide')
                            loadMasterTindakan()
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