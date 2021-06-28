<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LAPORAN TRANSAKSI</h3>
    </div>
    <div class="card-body">
        <form id="form_laporan">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tanggal Transaksi</label>
                        <input readonly class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nomor Transaksi</label>
                        <input class="form-control form-control-sm" autocomplete="off" name="nomor_transaksi" id="nomor_transaksi"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="bmd-label-floating">Status Transaksi</label>
                        <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="status">
                            <option value="0" selected>Semua</option>
                            <option value="1">Aktif</option>
                            <option value="2">Lunas</option>
                            <option value="3">Belum Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="bmd-label-floating">Jenis Transaksi</label>
                        <select class="form-control form-control-sm select2_this" data-dropdown-css-class="select2-navy" name="jenis_transaksi">
                            <option value="0" selected>Semua</option>
                            <option value="dine in">Dine In</option>
                            <option value="take away">Take Away</option>
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
<div class="modal fade" id="selected_transaksi_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="selected_transaksi_div">
            </div>
        </div>
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

    function loadSelectedTransaksi(id){
        $('#selected_transaksi_div').html('')
        $('#selected_transaksi_div').append('<div class="col-12 text-center text-navy mt-3" id="loader"><i class="fa fa-5x fa-spin fa-spinner"></i></div>')
        $('#selected_transaksi_div').load('<?=base_url("pos/C_Pos/loadSelectedTransaksiFromLaporan")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }

    $('#form_laporan').on('submit', function(e){
        e.preventDefault()
        $('#result_laporan_div').show()
        $('#result_laporan').html('')
        $('#result_laporan').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("laporan/C_Laporan/searchLaporanTransaksi")?>',
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