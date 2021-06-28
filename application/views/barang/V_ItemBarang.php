<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">TAMBAH ITEM BARANG</h3>
    </div>
    <div class="card-body">
        <form id="form_tambah_item">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Pilih Sub Kategori</label>
                        <select class="form-control select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_sub_kategori_barang" style="width: 100%;">
                            <?php if($list_sub_kategori){ foreach($list_sub_kategori as $l) {?>
                                <option value="<?=$l['id']?>"><?=$l['kode_sub_kategori'].' - '.$l['nama_sub_kategori']?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Kode Item</label>
                        <input class="form-control" autocomplete="off" name="kode_item" id="kode_item"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Nama Item</label>
                        <input class="form-control" autocomplete="off" name="nama_item" id="nama_item"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Harga</label>
                        <input class="form-control format_currency_this" autocomplete="off" name="harga" id="harga"/>
                    </div>
                </div>
                <div class="col">
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
        <h3 class="card-title">LIST ITEM BARANG</h3>
    </div>
    <div class="card-body">
        <div id="list_item" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadItem()
    })

    function loadItem(){
        $('#list_item').html('')
        $('#list_item').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_item').load('<?=base_url("admin/C_Admin/loadItem")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_item').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/insert_item")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadItem()
                $('#kode_item').val('')
                $('#nama_item').val('')
                $('#harga').val('')
                $('#keterangan').val('')
            }, error: function(e){
                alert('Terjadi Kesalahan')
            }
        })
    })
</script>