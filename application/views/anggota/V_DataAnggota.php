<?php if($anggota != null){ ?>
    <?php foreach($anggota as $row){?>
        <div class="border rounded text-label col-4 row ml-3 mr-4">
            <div class="col-3 mt-2 mb-2">
                <?php $imgSrc = $row['foto_profil'] != null ? dirFileLoad('foto_anggota').$row['foto_profil'] : base_url('assets/img/default-profile-picture.jpg')?>
                <a href="<?=$imgSrc?>" target="_blank"><img style="width: 100px; height: 100px;" src="<?=$imgSrc?>"/></a>
            </div>
            <div class="col-9 mt-1">
                <div class="row">
                    <div class="col-12 mb-1">
                        <strong><?=$row['nama'];?></strong>
                    </div>
                    <div class="col-12 mb-1">
                        <?=formatDateOnly($row['tanggal_lahir']);?>  
                    </div>
                    <div class="col-12 mb-1">
                        <?=$row['nomor_telpon'];?>
                    </div>
                    <div class="col-12">
                        <?=$row['alamat'];?>
                    </div>
                </div>
            </div> 
            <div class="col-12 text-label mb-3 mt-1">
                <a class="btn btn-sm btn-main-nikita" href="<?=base_url('anggota/detail/'.$row['id'])?>"><span class="fa fa-user-edit"></span> Edit</a>
                <a class="btn btn-sm bg-dark text-white" onclick="return confirm('Apakah Anda yakin?')" href="<?=base_url('anggota/delete/'.$row['id'])?>"><span class="fa fa-user-times"></span> Delete</a>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <h6 class="text-label">Data Tidak Ditemukan</h6>
<?php } ?>