<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">TAMBAH DOKTER</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_tambah_role">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Dokter</label>
                        <input class="form-control" autocomplete="off" name="nama_dokter" id="nama_dokter" required/>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nomor Telepon</label>
                        <input class="form-control" type="number" autocomplete="off" name="nomor_telepon" id="nomor_telepon" required/>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Alamat</label>
                        <input class="form-control" autocomplete="off" name="alamat" id="alamat" required/>
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
        <h3 class="card-title">LIST DOKTER</h3>
    </div>
    <div class="card-body">
        <div id="list_role" class="row">
        </div>
    </div>
</div>

<div class="modal fade" id="edit_master_dokter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT MASTER DOKTER</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_master_dokter_content">
          </div>
      </div>
  </div>
</div>


<script>
    $(function(){
        loadMasterDokter()
    })

    function loadMasterDokter(){
        $('#list_role').html('')
        $('#list_role').append(divLoaderNavy)
        $('#list_role').load('<?=base_url("master/C_Master/loadMasterDokter")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_role').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/createMasterDokter")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadMasterDokter()
                $('#role_name').val('')
                $('#nama').val('')
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function openModalEdiMasterDokter(id = 0){
    $('#edit_master_dokter_content').html('')
    $('#edit_master_dokter_content').append(divLoaderNavy)
    $('#edit_master_dokter_content').load('<?=base_url("master/C_Master/loadEditMasterDokter")?>'+'/'+id, function(){
      $('#loader').hide()
    })
  }

</script>