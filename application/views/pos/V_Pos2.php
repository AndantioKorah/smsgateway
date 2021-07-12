<style>
    
</style>

<div class="row">
    <div class="col-4" style="overflow-y: scroll; height: 100%;">
        <div class="card card-default">
            <div class="card-header card_header" style="cursor: pointer;" data-card-widget="collapse">
                <h3 class="card-title">Buat Transaksi Baru</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="form_new_transaction">
                    <div class="row">
                        <div class="col-6">
                            <label>Tanggal & Jam</label>
                            <input class="form-control form-control-sm datetimepickermaxtodaythis realdatetimethis" readonly autocomplete="off" name="tanggal_transaksi" id="tanggal_transaksi"/>
                        </div>
                        <div class="col-6">
                            <label>Nama</label>
                            <input class="form-control form-control-sm" name="nama" id="nama"/>
                        </div>
                        <div class="col-6">
                            <label>Nomor Meja</label>
                            <input class="form-control form-control-sm" autocomplete="off" name="nomor_meja" id="nomor_meja"/>
                        </div>
                        <div class="col-6">
                            <label>Jumlah Orang</label>
                            <input class="form-control form-control-sm" autocomplete="off" name="jumlah_orang" id="jumlah_orang"/>
                        </div>
                        <div class="col-9"></div>
                        <div class="col-3 mt-2 text-right">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                    </div>
                </form>
                <form id="cari_transaksi_by_tanggal">
                <div class="row">
                    <div class="col-12"><hr></div>
                    <div class="col-9">
                        <label>Tanggal Transaksi</label>
                        <input id="search_tanggal_transaksi" type="date" class="form-control" value="<?=date('Y-m-d')?>" />
                    </div>
                    <div class="col-3" style="margin-top: 32px;">
                        <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">List Transaksi</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" onclick="reloadListTransaksi()" class="btn btn-tool"><i class="fas fa-sync"></i></button>
                </div>
            </div>
            <div class="card-body" id="body_transaksi">
            </div>
        </div>
    </div>
    <div class="col-8 fixme">
        <div id="selected_transaksi_div">
        </div>
    </div>
</div>
<script>
    let jenis_diskon = 'nominal'
    let last_id = 0
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var year = today.getFullYear();
    $(function () {
        reloadListTransaksi()
    })

    // var fixmeTop = $('.fixme').offset().top;       // get initial position of the element

    // $(window).scroll(function() {                  // assign scroll event listener

    //     var currentScroll = $(window).scrollTop(); // get current position

    //     if (currentScroll >= fixmeTop) {           // apply position: fixed if you
    //         $('.fixme').css({                      // scroll to that element or below it
    //             position: 'fixed',
    //             top: '0'
    //             right: '0'
    //         });
    //     } else {                                   // apply position: static
    //         $('.fixme').css({                      // if you scroll above it
    //             position: 'static'
    //         });
    //     }

    // });

    $('#form_new_transaction').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url('pos/C_Pos/createNewTransaksi')?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#nomor_meja').val('')
                $('#nama').val('')
                $('#jumlah_orang').val('')
                let resp = JSON.parse(data)
                last_id = resp.last_id
                loadSelectedTransaksi(last_id)
                reloadListTransaksi()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#cari_transaksi_by_tanggal').on('submit', function(e){
        e.preventDefault()
        let tanggal = $('#search_tanggal_transaksi').val().split("-")
        year = tanggal[0]
        month = tanggal[1]
        day = tanggal[2]
        reloadListTransaksi()
    })

    function loadSelectedTransaksi(id){
        $('#selected_transaksi_div').html('')
        $('#selected_transaksi_div').append('<div class="col-12 text-center text-navy mt-3" id="loader"><i class="fa fa-5x fa-spin fa-spinner"></i></div>')
        $('#selected_transaksi_div').load('<?=base_url("pos/C_Pos/loadSelectedTransaksi")?>'+'/'+id, function(){
            $('#loader').hide()
        })
        last_id = id
        $('.transaksi_hover').removeClass('transaksi_aktif')
        $('#transaksi_div_'+id).addClass('transaksi_aktif')
    }

    function reloadListTransaksi(){
        $('#body_transaksi').html('')
        $('#body_transaksi').append(cardBodyLoader)
        $('#body_transaksi').load('<?=base_url("pos/C_Pos/reloadListTransaksi")?>'+'/'+last_id+'/'+year+'/'+month+'/'+day, function(){
            $('#loader').hide()
        })
    }

    // $('#searchTransaksiAktif').on('keyup', function(){
    //     $('#body_transaksi_aktif').html('')
    //     $('#body_transaksi_aktif').append(cardBodyLoader)
    //     $.ajax({
    //         url: '<?=base_url("pos/C_Pos/searchTransaksiAktif")?>'+'/'+last_id,
    //         method: 'post',
    //         data: {
    //             search: $(this).val(),
    //             tanggal: day,
    //             bulan: month,
    //             tahun: year
    //         }, success: function(data){
    //             $('#loader').hide()
    //             $('#body_transaksi_aktif').append(data)
    //         }, error: function(e){
    //             errortoast('Terjadi Kesalahan')
    //         }
    //     })
    // })
</script>