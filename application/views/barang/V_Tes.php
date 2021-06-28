<div class="col-12 p-2">
    <h4>TAMBAH KATEGORI BARANG</h4>
    <hr>
    <form id="form_tambah_kategori">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Nama Kategori</label>
                    <input class="form-control" autocomplete="off" name="nama_kategori" id="nama_kategori"/>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Kode Kategori</label>
                    <input class="form-control" autocomplete="off" name="kode_kategori" id="kode_kategori"/>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Keterangan</label>
                    <input class="form-control" autocomplete="off" name="keterangan" id="keterangan"/>
                </div>
            </div>
            <div class="col-8"></div>
            <div class="col-4 text-right mt-2">
                <button class="btn btn-primary" type="submit">SIMPAN</button>
            </div>
        </div>
    </form>
    <h5>LIST KATEGORI BARANG</h5>
    <hr>
    <div id="list_kategori" class="row mt-3">

    </div>
</div>
<script>
    $(function(){
        loadKategori()
    })

    function loadKategori(){
        $('#list_kategori').html('')
        $('#list_kategori').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_kategori').load('<?=base_url("admin/C_Admin/loadKategori")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_kategori').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/insert_kategori_barang")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadKategori()
                $('#nama_kategori').val('')
                $('#kode_kategori').val('')
                $('#keterangan').val('')
            }, error: function(e){
                alert('Terjadi Kesalahan')
            }
        })
    })
</script>