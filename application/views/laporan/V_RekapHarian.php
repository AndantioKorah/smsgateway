<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">REKAP HARIAN</h3>
    </div>
    <div class="card-body">
        <form id="form_laporan">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tanggal Transaksi</label>
                        <input readonly class="form-control datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                        <!-- <input type="date" name="tanggal_transaksi" class="form-control" value="<?=date('Y-m-d')?>" /> -->
                    </div>
                </div>
                <div class="col-2">
                    <button style="margin-top: 32px;" class="btn btn-block btn-navy" type="submit"><i class="fa fa-search"></i> Cari</button>
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
            url: '<?=base_url("laporan/C_Laporan/searchRekapHarian")?>',
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