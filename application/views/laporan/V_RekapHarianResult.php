<div class="row">
    <div class="col-12 text-center"><h4><strong>REKAP</strong></h4></div>
    <div class="col-12 text-center"><h4><?=($search['range_tanggal'])?></h4></div>
    <div class="col-12 text-center"><button id="btn_print" href="#print_pilih_item_modal" data-toggle="modal"
    class="btn btn-sm btn-navy"><i class="fa fa-print"></i> Cetak Rekap Harian</button></div>
    <div class="col-12"><hr></div>
</div>
<div class="row">
    <div class="col-12 text-center">
        <label>Jumlah Pengunjung</label>
        <strong><h1><?=$jumlah_orang?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Jumlah Transaksi</label>
        <strong><h1><?=count($transaksi)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Jumlah Pembayaran</label>
        <strong><h1><?=count($pembayaran)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Jumlah Pengeluaran</label>
        <strong><h1><?=count($pengeluaran)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Jumlah Pembelian</label>
        <strong><h1><?=count($pembelian)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Total Biaya</label>
        <strong><h1><?=formatCurrency($total_biaya_transaksi)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Total Pembayaran</label>
        <strong><h1><?=formatCurrency($total_pembayaran)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Total Biaya Pengeluaran</label>
        <strong><h1><?=formatCurrency($total_pengeluaran)?></h1></strong>
    </div>
    <div class="col-3 text-center">
        <label>Total Biaya Pembelian</label>
        <strong><h1><?=formatCurrency($total_pembelian)?></h1></strong>
    </div>
    <div class="col-12 text-center">
        <label style="font-size: 22px;">LABA</label>
        <?php
            $laba = $total_pembayaran - ($total_pengeluaran + $total_pembelian);
        ?>
        <strong><h1><?=formatCurrency($laba)?></h1></strong>
    </div>
    <div class="col-12"><hr></div>
</div>
<div class="row">
    <div class="col-4">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">JUMLAH TRANSAKSI Per KATEGORI</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body" style="max-height: 450px; overflow:scroll; height: 450px;">
                <table style="width: 100%;">
                    <?php if($kategori){ $no=1; foreach($kategori as $k){ if($k['jumlah'] != 0){ ?>
                        <tr>
                            <td><?=$no++.'.';?></td>
                            <td><?=$k['nama_kategori']?></td>
                            <td>:</td>
                            <td class="text-right"><label style="font-size: 25px; margin-top: 5px;"><?=$k['jumlah']?></label></td>
                        </tr>
                    <?php } } }?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">JUMLAH TRANSAKSI Per SUB KATEGORI</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body" style="max-height: 450px; overflow:scroll; height: 450px;">
                <table style="width: 100%;">
                    <?php if($sub_kategori){ $no=1; foreach($sub_kategori as $k){ if($k['jumlah'] != '0'){ ?>
                        <tr>
                            <td><?=$no++.'.';?></td>
                            <td><?=$k['nama_sub_kategori']?></td>
                            <td>:</td>
                            <td class="text-right"><label style="font-size: 25px; margin-top: 5px;"><?=$k['jumlah']?></label></td>
                        </tr>
                    <?php } } } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">JUMLAH TRANSAKSI Per ITEM</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body" style="max-height: 450px; overflow:scroll; height: 450px;">
                <table style="width: 100%;">
                    <?php if($item){ $no=1; foreach($item as $k){ if($k['jumlah'] != '0'){ ?>
                        <tr>
                            <td><?=$no++.'.';?></td>
                            <td><?=$k['nama_item']?></td>
                            <td>@</td>
                            <td class="text-right"><?=formatCurrency($k['harga_per_item'])?></td>
                            <td class="text-right">:</td>
                            <td class="text-right"><label style="font-size: 25px; margin-top: 5px;"><?=$k['jumlah']?></label></td>
                        </tr>
                    <?php } } }?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row"><div class="col-12"><hr></div></div>
<div class="row">
    <div class="col-12 text-center">
        <h5><strong>LIST TRANSAKSI</strong></h5>
    </div>
    <div class="col-5 text-center" style="border: 1px solid #001f3f; border-radius: 5px;">
        <label>Jenis Transaksi</label>
        <div class="row">
            <div class="col-6">
                <label>Dine In</label>
                <h1 id="dine_in_text"></h1>
            </div>
            <div class="col-6">
                <label>Take Away</label>
                <h1 id="take_away_text"></h1>
            </div>
        </div>
    </div>
    <div class="col-2"></div>
    <div class="col-5 text-center" style="border: 1px solid #001f3f; border-radius: 5px;">
        <label>Status Transaksi</label>
        <div class="row">
            <div class="col-4">
                <label>Aktif</label>
                <h1 id="aktif_text"></h1>
            </div>
            <div class="col-4">
                <label>Lunas</label>
                <h1 id="lunas_text"></h1>
            </div>
            <div class="col-4">
                <label>Belum Lunas</label>
                <h1 id="belum_lunas_text"></h1>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Informasi Meja</th>
                <th>Total Biaya</th>
                <th class="text-center">Jenis Transaksi</th>
                <th class="text-center">Status Transaksi</th>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $dine_in = 0; 
                $take_away = 0; 
                $aktif = 0; 
                $belum_lunas = 0; 
                $lunas = 0;
                if($transaksi){
                foreach($transaksi as $rs){ 
                    if($rs['jenis_transaksi'] == 'dine in'){
                        $dine_in++;
                    } else {
                        $take_away++;
                    }

                    if($rs['status'] == 1){
                        $aktif++;
                    } else if($rs['status'] == 2){
                        $lunas++;
                    } else {
                        $belum_lunas++;
                    }

                    $info_meja = $rs['nama'];

                    if($rs['nomor_meja'] != '' && $rs['nomor_meja']){
                        $info_meja = $info_meja.' / Meja: '.$rs['nomor_meja'];
                    } else {
                        $info_meja = $info_meja.' / -';
                    }

                    if($rs['jumlah_orang'] != '' && $rs['jumlah_orang']){
                        $info_meja = $info_meja.' / '.$rs['jumlah_orang'].' orang';
                    } else {
                        $info_meja = $info_meja.' / -';
                    }
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=$rs['nomor_transaksi'];?></td>
                        <td><?=formatDate($rs['tanggal_transaksi']);?></td>
                        <td><?=$info_meja?></td>
                        <td><?=formatCurrency($rs['total_biaya'])?></td>
                        <td class="text-center"><?=strtoupper($rs['jenis_transaksi'])?></td>
                        <td class="text-center"><?=getStatusTransaksi($rs['status'])?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
    <div class="col-12"><hr></div>
</div>
<div class="row">
    <div class="col-12 text-center">
        <h5><strong>DETAIL TRANSAKSI</strong></h5>
    </div>
    <div class="col-12 mt-3">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Nomor Transaksi</th>
                <th class="text-center">Nama</th>
                <th class="text-left">Tanggal Transaksi</th>
                <th class="text-left">Item</th>
                <th class="text-left">Harga per Item</th>
                <th class="text-center">Qty</th>
                <th class="text-left">Total</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($detail_transaksi as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$rs['nomor_transaksi']?></td>
                        <td class="text-center"><?=$rs['nama']?></td>
                        <td class="text-left"><?=formatDate($rs['tanggal_transaksi'])?></td>
                        <td class="text-left"><?=$rs['nama_item']?></td>
                        <td class="text-left"><?=formatCurrency($rs['harga_per_item'])?></td>
                        <td class="text-center"><?=$rs['qty']?></td>
                        <td class="text-left"><?=formatCurrency($rs['total'])?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-12"><hr></div>
</div>
<div class="row">
    <div class="col-12 text-center">
        <h5><strong>LIST PEMBAYARAN</strong></h5>
    </div>
    <div class="col-12">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <!-- <th>Nomor Transaksi</th> -->
                <th>Nomor Pembayaran</th>
                <th>Nama Pembayar</th>
                <th>Cara Bayar</th>
                <th>Total Tagihan</th>
                <th>Diskon</th>
                <th>Jumlah Pembayaran</th>
                <th>Kembalian</th>
            </thead>
            <tbody>
                <?php if($pembayaran){ $no = 1; foreach($pembayaran as $p){ 
                    $cara_bayar = strtoupper($p['cara_bayar']);
                    if($p['cara_bayar'] != 'tunai'){
                        $cara_bayar = strtoupper($p['cara_bayar']).' ('.$p['nomor_referensi'].')';
                    }

                    $diskon = formatCurrency($p['diskon_nominal']);
                    if($p['diskon_presentase'] != 0){
                        $diskon = $p['diskon_presentase'].' %'.' ('.formatCurrency($p['diskon_nominal']).')';
                    }
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=formatDate($p['tanggal_pembayaran'])?></td>
                        <!-- <td><?=$p['nomor_transaksi']?></td> -->
                        <td><?=$p['nomor_pembayaran']?></td>
                        <td><?=$p['nama_pembayar']?></td>
                        <td><?=$cara_bayar?></td>
                        <td><?=formatCurrency($p['total_biaya'])?></td>
                        <td><?=$diskon?></td>
                        <td><?=formatCurrency($p['jumlah_pembayaran'])?></td>
                        <td><?=formatCurrency($p['kembalian'])?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
    <div class="col-12"><hr></div>
</div>
<div class="row">
    <div class="col-12 text-center">
        <h5><strong>LIST PENGELUARAN</strong></h5>
    </div>
    <div class="col-12">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th>Tanggal Pengeluaran</th>
                <th>Nomor Transaksi</th>
                <th>Nama Pengeluaran</th>
                <th>Jenis Pengeluaran</th>
                <th>Qty</th>
                <th>Harga per Item</th>
                <th>Total</th>
            </thead>
            <tbody>
                <?php if($pengeluaran){ $no = 1; foreach($pengeluaran as $p){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=formatDate($p['tanggal_pengeluaran'])?></td>
                        <td><?=$p['nomor_transaksi']?></td>
                        <td><?=$p['nama_pengeluaran']?></td>
                        <td><?=$p['nama_jenis_pengeluaran']?></td>
                        <td><?=formatCurrencyWithoutRp($p['qty'])?></td>
                        <td><?=formatCurrency($p['harga_per_item'])?></td>
                        <td><?=formatCurrency($p['total_harga'])?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
    <div class="col-12"><hr></div>
</div>
<div class="row">
    <div class="col-12 text-center">
        <h5><strong>LIST PEMBELIAN</strong></h5>
    </div>
    <div class="col-12">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th>Tanggal Pembelian</th>
                <th>Nomor Transaksi</th>
                <th>Nama Pembelian</th>
                <th>Jenis Pembelian</th>
                <th>Qty</th>
                <th>Harga per Item</th>
                <th>Total</th>
            </thead>
            <tbody>
                <?php if($pembelian){ $no = 1; foreach($pembelian as $p){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=formatDate($p['tanggal_pembelian'])?></td>
                        <td><?=$p['nomor_transaksi']?></td>
                        <td><?=$p['nama_pembelian']?></td>
                        <td><?=$p['nama_jenis_pembelian']?></td>
                        <td><?=formatCurrencyWithoutRp($p['qty'])?></td>
                        <td><?=formatCurrency($p['harga_per_item'])?></td>
                        <td><?=formatCurrency($p['total_harga'])?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="print_pilih_item_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-xl">
		<div class="modal-content">
			<div id="print_pilih_item_div">
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
        $('.datatable').dataTable()

        $('#aktif_text').html('<?=$aktif?>')
        $('#lunas_text').html('<?=$lunas?>')
        $('#belum_lunas_text').html('<?=$belum_lunas?>')
        $('#dine_in_text').html('<?=$dine_in?>')
        $('#take_away_text').html('<?=$take_away?>')
    })

    $('#btn_print').on('click', function(){
        $('#print_pilih_item_div').html('')
        $('#print_pilih_item_div').append(divLoaderNavy)
        $('#print_pilih_item_div').load('<?=base_url("laporan/C_Laporan/pilihItemForCetakRekap2")?>', function(){
            $('#loader').hide()
        })
    })
</script>