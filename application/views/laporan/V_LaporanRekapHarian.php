<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title"><strong>LAPORAN REKAP HARIAN</strong></h3>
            </div>
            <div class="card-body">
                <form id="form_search_laporan">
                    <div class="row">
                        <div class="col-12">
                            <label>Pilih Range Tanggal</label>
                            <input class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                        </div>
                        <div class="col-12 mt-2 text-right">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-search"></i> CARI LAPORAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="result_search_laporan">
        
    </div>
</div>
<script>
    $(function(){
        $('.datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        })
        
        $('#form_search_laporan').submit()
    })

    $('#form_search_laporan').on('submit', function(e){
        e.preventDefault()
        $('#result_search_laporan').html('')
        $('#result_search_laporan').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("laporan/C_Laporan/searchLaporanRekapHarian")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result_search_laporan').html('')
                $('#result_search_laporan').append(data)
            }, error: function(err){
                console.log(err)
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>
