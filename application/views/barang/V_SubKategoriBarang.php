<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">TAMBAH SUB KATEGORI BARANG</h3>
    </div>
    <div class="card-body">
        <form id="form_tambah_sub_kategori">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Pilih Kategori</label>
                        <select class="form-control select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_kategori_barang" style="width: 100%;">
                            <?php if($list_kategori){ foreach($list_kategori as $l) {?>
                                <option value="<?=$l['id']?>"><?=$l['kode_kategori'].' - '.$l['nama_kategori']?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Kode Sub Kategori</label>
                        <input class="form-control" autocomplete="off" name="kode_sub_kategori" id="kode_sub_kategori"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Nama Sub Kategori</label>
                        <input class="form-control" autocomplete="off" name="nama_sub_kategori" id="nama_sub_kategori"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input class="form-control" autocomplete="off" name="keterangan" id="keterangan"/>
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
        <h3 class="card-title">LIST SUB KATEGORI BARANG</h3>
    </div>
    <div class="card-body">
        <div id="list_sub_kategori" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadSubKategori()
    })

    function loadSubKategori(){
        $('#list_sub_kategori').html('')
        $('#list_sub_kategori').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_sub_kategori').load('<?=base_url("admin/C_Admin/loadSubKategori")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_sub_kategori').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/insert_sub_kategori_barang")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadSubKategori()
                $('#nama_sub_kategori').val('')
                $('#kode_sub_kategori').val('')
                $('#keterangan').val('')
            }, error: function(e){
                alert('Terjadi Kesalahan')
            }
        })
    })
</script>