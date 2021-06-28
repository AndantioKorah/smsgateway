<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped datatable">
            <thead>
                <th class="text-center">No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pengeluaran</th>
                <th>Pilihan</th>            
            </thead>
            <tbody>
                <?php $no=1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=$rs['nomor_transaksi']?></td>
                        <td><?=formatDate($rs['tanggal_pengeluaran'])?></td>
                        <td><?=$rs['nama_pengeluaran']?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="openDetail('<?=$rs['id']?>')" title="Detail"><i class="fa fa-list"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="hapusPengeluaran('<?=$rs['id']?>')" title="Hapus"><i class="fa fa-trash"></i></button>
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

		function hapusPengeluaran(id){
			if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("admin/C_Admin/hapusTransaksiPengeluaran")?>'+'/'+id,
                    method: 'post',
                    success: function(data){
                        $('#form_cari_transaksi_pengeluaran').submit()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
		}

        function openDetail(id){
            window.location="<?=base_url('transaksi/pengeluaran/detail')?>"+"/"+id
        }
    </script>
<?php } else { ?>
    <div class="col-12 text-center"><h4><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h4></div>
<?php } ?>
