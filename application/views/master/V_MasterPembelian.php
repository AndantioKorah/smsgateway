<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">TAMBAH JENIS PEMBELIAN</h3>
    </div>
    <div class="card-body">
        <form id="form_tambah_jenis_pembelian">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Pembelian</label>
                        <input class="form-control" autocomplete="off" name="nama_pembelian" id="nama_pembelian"/>
                        <input class="form-control" style="display:none" autocomplete="off" name="created_by" id="created_by" value="<?=$this->general_library->getId()?>"/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Keterangan</label>
                        <input class="form-control" autocomplete="off" name="keterangan" id="keterangan"/>
                    </div>
                </div>
                <div class="col-4 mt-2">
                    <button style="margin-top:22px;" class="btn btn-block btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST JENIS PEMBELIAN</h3>
    </div>
    <div class="card-body">
        <div id="list_jenis_pembelian" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadJenisPembelian()
    })

    function loadJenisPembelian(){
        $('#list_jenis_pembelian').html('')
        $('#list_jenis_pembelian').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_jenis_pembelian').load('<?=base_url("admin/C_Admin/loadJenisPembelian")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_jenis_pembelian').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/insert_jenis_pembelian")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadJenisPembelian()
                $('#nama_pembelian').val('')
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>