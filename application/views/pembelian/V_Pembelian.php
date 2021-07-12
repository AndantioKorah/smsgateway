<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-9">
                <h3 style="margin-top:10px;" class="card-title">TRANSAKSI PEMBELIAN</h3>
            </div>
            <div class="col-3">
                <form id="form_tambah_transaksi_pembelian">
                    <input class="form-control form-control-sm" style="display:none;" name="created_by" value="<?=$this->general_library->getId()?>" />
                    <button class="btn btn-block btn-navy" type="submit"><i class="fa fa-plus"></i> Buat Pembelian Baru</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form_cari_transaksi_pembelian">
            <div class="row">
                <div class="col-4 form-group">
                    <label class="bmd-label-floating">Tanggal Transaksi</label>
                    <input readonly class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                </div>
                <div class="col-4 form-group">
                    <label class="bmd-label-floating">Nomor Transaksi</label>
                    <input class="form-control form-control-sm" autocomplete="off" name="nomor_transaksi" id="nomor_transaksi"/>
                </div>
                <div class="col-4 form-group">
                    <label class="bmd-label-floating">Nama Pembelian</label>
                    <input class="form-control form-control-sm" autocomplete="off" name="nama_pembelian" id="nama_pembelian"/>
                </div>
                <div class="col-9"></div>
                <div class="col-3">
                    <button class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari Transaksi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="div_result" style="display:none;" class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST PEMBELIAN</h3>
    </div>
    <div class="card-body">
        <div id="riwayat_pembelian" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        })
    })


    $('#form_tambah_transaksi_pembelian').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin/C_Admin/createTransaksiPembelian")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                window.location="<?=base_url('transaksi/pembelian/detail')?>"+"/"+resp.last_id
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#form_cari_transaksi_pembelian').on('submit', function(e){
        e.preventDefault();
        $('#div_result').show()
        $('#riwayat_pembelian').html('')
        $('#riwayat_pembelian').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $.ajax({
            url: '<?=base_url("admin/C_Admin/searchTransaksiPembelian")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                // let resp = JSON.parse(data)
                $('#loader').hide()
                $('#riwayat_pembelian').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>