<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LAPORAN PENJUALAN</h3>
    </div>
    <div class="card-body">
        <form id="form_laporan">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tanggal Transaksi</label>
                        <input readonly class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Kategori Barang</label>
                        <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="id_m_kategori_barang" id="id_m_kategori_barang">
                            <option value="0" selected>Semua</option>
                            <?php if($kategori){ foreach($kategori as $k){ ?>
                                <option value="<?=$k['id']?>"><?=$k['nama_kategori']?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Sub Kategori Barang</label>
                        <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="id_m_sub_kategori_barang" id="id_m_sub_kategori_barang">
                            <option value="0" selected>Semua</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Item</label>
                        <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="id_m_item_barang" id="id_m_item_barang">
                            <option value="0" selected>Semua</option>
                        </select>
                    </div>
                </div>
                <div class="col-10"></div>
                <div class="col-2 text-right mt-2">
                    <button class="btn btn-block btn-navy" type="submit"><i class="fa fa-search"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default" id="result_laporan_div" style="display: none;">
    <div class="card-body">
        <div class="row">
            <div class="col-12" id="result_laporan"></div>
        </div>
    </div>
</div>

<script>
    let sub_kategori = JSON.parse('<?=json_encode($sub_kategori)?>')
    let item = JSON.parse('<?=json_encode($item)?>')

    $(function(){
        $('.datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        })
    })

    $('#id_m_kategori_barang').on('change', function(){
        let this_val = $(this).val()
        $('#id_m_sub_kategori_barang').empty().append('<option value="0" selected>Semua</option>')
        $('#id_m_item_barang').empty().append('<option value="0" selected>Semua</option>')
        if($(this).val() != '0'){
            sub_kategori.forEach(function(obj){
                if(obj['id_m_kategori_barang'] == this_val){
                    $('#id_m_sub_kategori_barang').append('<option value="'+obj.id+'">'+obj.nama_sub_kategori+'</option>')
                }
            })
        }
    })

    $('#id_m_sub_kategori_barang').on('change', function(){
        let this_val = $(this).val()
        $('#id_m_item_barang').empty().append('<option value="0" selected>Semua</option>')
        if($(this).val() != '0'){
            item.forEach(function(obj){
                if(obj['id_m_sub_kategori_barang'] == this_val){
                    $('#id_m_item_barang').append('<option value="'+obj.id+'">'+obj.nama_item+'</option>')
                }
            })
        }
    })

    $('#form_laporan').on('submit', function(e){
        e.preventDefault()
        $('#result_laporan_div').show()
        $('#result_laporan').html('')
        $('#result_laporan').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("laporan/C_Laporan/searchLaporanPenjualan")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result_laporan').html('')
                $('#result_laporan').append(data)                
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

</script>