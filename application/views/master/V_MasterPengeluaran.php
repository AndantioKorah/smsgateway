<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">TAMBAH JENIS PENGELUARAN</h3>
    </div>
    <div class="card-body">
        <form id="form_tambah_jenis_pengeluaran">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Pengeluaran</label>
                        <input class="form-control" autocomplete="off" name="nama_pengeluaran" id="nama_pengeluaran"/>
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
        <h3 class="card-title">LIST JENIS PENGELUARAN</h3>
    </div>
    <div class="card-body">
        <div id="list_jenis_pengeluaran" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadJenisPengeluaran()
    })

    function loadJenisPengeluaran(){
        $('#list_jenis_pengeluaran').html('')
        $('#list_jenis_pengeluaran').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_jenis_pengeluaran').load('<?=base_url("admin/C_Admin/loadJenisPengeluaran")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_jenis_pengeluaran').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/insert_jenis_pengeluaran")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadJenisPengeluaran()
                $('#nama_pengeluaran').val('')
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>