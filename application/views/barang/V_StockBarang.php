<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">TAMBAH STOCK BARANG</h3>
    </div>
    <div class="card-body">
        <form id="form_tambah_stock">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Pilih Item</label>
                        <select class="form-control select2_this select2-navy" data-dropdown-css-class="select2-navy" id="select_pilih_item" style="width: 100%;">
                            <option value="0" disabled selected>Pilih Item</option>
                            <option value="semua">Lihat Semua</option>
                            <?php if($list_item){ foreach($list_item as $l) {?>
                                <option value="<?=$l['id'].';'.formatCurrencyWithoutRp($l['harga'])?>"><?=$l['kode_item'].' - '.$l['nama_item']?></option>
                            <?php } }?>
                        </select>
                        <input style="display: none;" class="form-control" autocomplete="off" name="id_m_item_barang" id="id_m_item_barang"/>
                    </div>
                </div>
                <div class="col-3 hide_this" style="display: none;">
                    <div class="form-group">
                        <label>Tambahan Stock</label>
                        <input class="form-control" autocomplete="off" name="jumlah_stock" id="jumlah_stock"/>
                    </div>
                </div>
                <div class="col-3 hide_this" style="display: none;">
                    <div class="form-group">
                        <label>Harga</label>
                        <input class="form-control format_currency_this" autocomplete="off" name="harga" id="harga"/>
                    </div>
                </div>
                <div class="col-1 hide_this" style="display: none;">
                    <button style="margin-top: 32px;" class="btn btn-block btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>                
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST STOCK BARANG</h3>
    </div>
    <div class="card-body">
        <div id="list_stock_item" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){

    })

    $('#select_pilih_item').on('change', function(){
        let id = $(this).val()
        if(id != 'semua'){
            let split = id.split(";")
            loadStock(split[0])
            $('#id_m_item_barang').val(split[0])
            $('#harga').val(split[1])
        }
    })

    function loadStock(id){
        if(id != "semua"){
            $('.hide_this').hide()
        }
        $('.hide_this').hide()
        $('#list_stock_item').html('')
        $('#list_stock_item').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#list_stock_item').load('<?=base_url("admin/C_Admin/loadStock")?>'+'/'+id, function(){
            if(id != "semua"){
                $('.hide_this').show()
            }
            $('#loader').show()
        })
    }

    $('#form_tambah_stock').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/insert_item")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadStock()
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