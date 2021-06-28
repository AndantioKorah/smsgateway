<a class="btn btn-navy btn-sm" href="<?=base_url('transaksi/pembelian')?>"><i class="fa fa-arrow-left"></i> Kembali</a>

<div class="card card-default mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                <h3 class="card-title">DETAIL PEMBELIAN: <strong><?=$pembelian['nomor_transaksi']?></strong></h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form_simpan_transaksi">
            <div class="row">
                <div class="col-4 form-group">
                    <label class="bmd-label-floating">Tanggal Pembelian</label>
                    <input readonly class="form-control form-control-sm datetimepickerthis" value="<?=$pembelian['tanggal_pembelian']?>" autocomplete="off" name="tanggal_pembelian" id="tanggal_pembelian"/>
                    <!-- <input readonly style="display:none;" class="form-control form-control-sm" value="<?=$pembelian['id']?>" autocomplete="off" name="id" id="id"/> -->
                </div>
                <div class="col-4 form-group">
                    <label class="bmd-label-floating">Nomor Transaksi</label>
                    <input readonly class="form-control form-control-sm" value="<?=$pembelian['nomor_transaksi']?>" autocomplete="off" name="nomor_transaksi" id="nomor_transaksi"/>
                </div>
                <div class="col-4 form-group">
                    <label class="bmd-label-floating">Nama Pembelian</label>
                    <input class="form-control form-control-sm" autocomplete="off" value="<?=$pembelian['nama_pembelian']?>" name="nama_pembelian" id="nama_pembelian"/>
                </div>
                <div class="col-9"></div>
                <div class="col-3">
                    <button class="btn btn-block btn-navy"><i class="fa fa-save"></i> Simpan Transaksi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                <h3 class="card-title">LIST PEMBELIAN</strong></h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="#" id="form_tambah_detail_pembelian">
            <div class="row">
                <div class="col-3 form-group">
                    <label>Jenis Pembelian</label>
                    <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="id_m_jenis_pembelian">
                        <?php if($jenis_pembelian){ foreach($jenis_pembelian as $jp){ ?>
                            <option value="<?=$jp['id']?>"><?=$jp['nama_pembelian']?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col form-group">
                    <label>Kuantitas</label>
                    <input class="form-control form-control-sm" id="qty" name="qty" type="number" oninput="onTyping()" />
                    <input style="display:none;" class="form-control form-control-sm" value="<?=$pembelian['id']?>" id="id_t_pembelian" name="id_t_pembelian" />
                </div>
                <div class="col form-group">
                    <label>Harga per item</label>
                    <input class="form-control form-control-sm format_currency_this" id="harga_per_item" name="harga_per_item" oninput="onTyping()" />
                </div>
                <div class="col form-group">
                    <label>Total Harga</label>
                    <input readonly class="form-control form-control-sm format_currency_this" id="total_harga" name="total_harga" oninput="onTyping()" />
                </div>
                <div class="col-4 form-group">
                    <label>Keterangan</label>
                    <input class="form-control form-control-sm" id="keterangan" name="keterangan"/>
                </div>
            </div>
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3 text-right">
                    <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12"><hr></div>
                <div class="col-12 text-right">
                    <h5 id="total_pembelian"></h5>
                </div>
            </div>
        </form>
        <div class="row" id="list_pembelian">
            
        </div>
    </div>
</div>

<script>
    $(function(){
        loadListPembelian()
    })

    function loadListPembelian(){
        $('#total_pembelian').html('')
        $('#list_pembelian').html('')
        $('#list_pembelian').append(divLoaderNavy)
        $('#list_pembelian').load('<?=base_url('admin/C_Admin/loadListPembelianDetail/').$pembelian['id']?>', function(){
            $('#loader').hide()
        })
    }

    function onTyping(){
        let harga = $('#harga_per_item').val().replace(/[^a-zA-Z0-9]/g, '');
        let qty = $('#qty').val()
        let total_harga = harga * qty
        $('#total_harga').val(rupiahkan(total_harga))
    }

    function rupiahkan(angka){
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }

    $('#form_simpan_transaksi').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("admin/C_Admin/simpanTransaksiPembelian")?>'+'/'+'<?=$pembelian['id']?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
               successtoast('Data Sudah Tersimpan')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#form_tambah_detail_pembelian').on('submit', function(e){
        e.preventDefault();
        if($('#qty').val() == "" || $('#qty').val() == 0 || $('#qty').val() < 0){
            errortoast('Kuantitas tidak valid')
            return false
        }
        if($('#harga_per_item').val() == "" || $('#harga_per_item').val() == 0 || $('#harga_per_item').val() < 0){
            errortoast('Kuantitas tidak valid')
            return false
        }
        $.ajax({
            url: '<?=base_url("admin/C_Admin/createPembelianDetail")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#qty').val('')
                $('#harga_per_item').val('')
                $('#total_harga').val('')
                $('#keterangan').val('')
                loadListPembelian()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>