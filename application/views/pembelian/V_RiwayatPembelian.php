<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pembelian</th>
                <th>Pilihan</th>            
            </thead>
            <tbody>
                <?php $no=1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=$rs['nomor_transaksi']?></td>
                        <td><?=formatDate($rs['tanggal_pembelian'])?></td>
                        <td><?=$rs['nama_pembelian']?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="openDetail('<?=$rs['id']?>')" title="Detail"><i class="fa fa-list"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="hapusPembelian('<?=$rs['id']?>')" title="Hapus"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            $('.datatable').DataTable({
                responsive: false
            });
        })
		
		function hapusPembelian(id){
			if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("admin/C_Admin/hapusTransaksiPembelian")?>'+'/'+id,
                    method: 'post',
                    success: function(data){
                        $('#form_cari_transaksi_pembelian').submit()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
		}

        function openDetail(id){
            window.location="<?=base_url('transaksi/pembelian/detail')?>"+"/"+id
        }
    </script>
<?php } else { ?>
    <div class="col-12 text-center"><h4><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h4></div>
<?php } ?>
