<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">TAMBAH JENIS PEMERIKSAAN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_tambah_role">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Pemeriksaan</label>
                        <input class="form-control" autocomplete="off" name="nm_jns_tindakan" id="nm_jns_tindakan"/>
                    </div>
                </div>
                
                
                </div>
                    <div class="col-8"></div>
                <div class="col-4 text-right mt-2">
                    <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST JENIS PEMERIKSAAN</h3>
    </div>
    <div class="card-body">
        <div id="list_role" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadJenisPemeriksaan()
    })

    function loadJenisPemeriksaan(){
        $('#list_role').html('')
        $('#list_role').append(divLoaderNavy)
        $('#list_role').load('<?=base_url("master/C_Master/loadJenisPemeriksaan")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_role').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/createJenisPemeriksaan")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadJenisPemeriksaan()
                $('#role_name').val('')
                $('#nama').val('')
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>