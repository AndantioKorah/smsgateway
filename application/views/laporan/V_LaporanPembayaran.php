<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LAPORAN PEMBAYARAN</h3>
    </div>
    <div class="card-body">
        <form id="form_laporan">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tanggal Pembayaran</label>
                        <input readonly class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nomor Pembayaran</label>
                        <input class="form-control form-control-sm" autocomplete="off" name="nomor_pembayaran" id="nomor_pembayaran"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Pembayar</label>
                        <input class="form-control form-control-sm" autocomplete="off" name="nama_pembayar" id="nama_pembayar"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="bmd-label-floating">Cara Bayar</label>
                        <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="cara_bayar">
                            <option value="0" selected>Semua</option>
                            <option value="tunai">Tunai</option>
                            <option value="card">Debit / Credit</option>
                            <option value="transfer">Transfer</option>
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
    $(function(){
        $('.datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        })
    })


    $('#form_laporan').on('submit', function(e){
        e.preventDefault()
        $('#result_laporan_div').show()
        $('#result_laporan').html('')
        $('#result_laporan').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("laporan/C_Laporan/searchLaporanPembayaran")?>',
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