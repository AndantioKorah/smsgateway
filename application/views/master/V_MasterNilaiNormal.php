<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">TAMBAH TINDAKAN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_tambah_nilai_normal">
            <div class="row">
              
                <div class="col-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Tindakan</label>
                        <select class='col-12' id="tindakan" name="tindakan" type='text' placeholder="Cari Tindakan..." required>Cari Tindakan...</select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Jenis Kelamin</label>
                        <Select class="form-control select2_this select2-navy" autocomplete="off" name="jenis_kelamin" id="jenis_kelamin" >
                        <option value="">-</option> 
                        <option value="1">Laki-laki</option>                    
                        <option value="2">Perempuan</option> 
                        </Select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Umur</label>
                        <input type="text" class="form-control" autocomplete="off" name="umur" id="umur"/>
                    </div>
                </div>

   

                <div class="col-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nilai Normal</label>
                        <input type="text" class="form-control" autocomplete="off" name="nilai_normal" id="nilai_normal" required/>
                    </div>
                </div>


                </div>
                    <div class="col-12"></div>
                <div class="col-12 text-right mt-2">
                    <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST NILAI NORMAL</h3>
    </div>
    <div class="card-body">
        <div id="list_nilai" class="row">
        </div>
    </div>
</div>

<div class="modal fade" id="edit_master_nilai_normal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT MASTER NILAI NORMAL</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_master_nilai_content">
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        loadMasterNilaiNormal()
    })

    function loadMasterNilaiNormal(){
      
        $('#list_nilai').html('')
        $('#list_nilai').append(divLoaderNavy)
        $('#list_nilai').load('<?=base_url("master/C_Master/loadMasterNilaiNormal")?>', function(){
            $('#loader').hide()
        })
    }

       $("#tindakan").select2({
        placeholder: "Cari Tindakan",
        tokenSeparators: [',', ' '],
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '<?=base_url("master/C_Master/select2Tindakan")?>',
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nm_tindakan,
                            id: item.id_tindakan
                        }
                    })
                };
            }
        }
    });

    $('#form_tambah_nilai_normal').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/createMasterNilaiNormal")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadMasterNilaiNormal()

            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function openModalEdiMasterNilaiNormal(id = 0){
    $('#edit_master_nilai_content').html('')
    $('#edit_master_nilai_content').append(divLoaderNavy)
    $('#edit_master_nilai_content').load('<?=base_url("master/C_Master/editMasterNilaiNormal")?>'+'/'+id, function(){
      $('#loader').hide()
    })
  }

</script>