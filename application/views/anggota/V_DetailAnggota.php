<?php if($anggota != null){ ?>
    <?php foreach($anggota as $row){?>
        <div class="p-3">
        <h5 class="text-header"><span class="fa fa-id-card"></span> Detail Anggota</h5><br>
            <form action="<?=base_url('anggota/C_anggota/editAnggota/'.$row['id'])?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-4 form-group">
                        <label class="text-label">Nama Lengkap</label>
                        <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" name="nama" value="<?=$row['nama']?>"/>
                    </div>
                    <div class="col-4 form-group">
                        <label class="text-label">Tempat Lahir</label>
                        <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" name="tempat_lahir" value="<?=$row['tempat_lahir']?>"/>
                    </div>
                    <div class="col-4 form-group">
                        <label class="text-label">Tanggal Lahir</label>
                        <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" name="tanggal_lahir" value="<?=formatDateOnlyForEdit($row['tanggal_lahir'])?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 form-group">
                        <label class="text-label">Alamat</label>
                        <input autocomplete="off" required type="text" class="form-control-nikita form-control-sm" name="alamat" value="<?=$row['alamat']?>"/>
                    </div>
                    <div class="col-4 form-group">
                        <label class="text-label">Nomor Telepon</label>
                        <input autocomplete="off" required type="text" class="form-control-nikita form-control-sm" name="nomor_telpon" value="<?=$row['nomor_telpon']?>"/>
                    </div>
                    <div class="col-4 form-group">
                        <label class="text-label">Jenis Anggota</label>
                        <select class="form-control-nikita form-control-sm" name="id_m_bipra">
                            <?php foreach($bipra as $rows) { ?>
                            <option class="bg-nikita-primary" <?=$row['id_m_bipra'] == $rows['id'] ? 'selected' : ''?> value="<?= $rows['id'] ?>">
                                <?= $rows['keterangan'] ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 form-group">
                        <label class="text-label">Foto Anggota</label>
                        <input accept="image/*" type="file" class="form-control-nikita form-control-sm" name="foto_profil" id="foto_profil"/>
                    </div>
                    <div class="col-4 form-group">
                        <label class="text-label">Dokumen Negara</label>
                        <input accept="image/*" type="file" class="form-control-nikita form-control-sm" name="dokumen_negara" id="dokumen_negara"/>
                    </div>
                    <div class="col-4 form-group">
                        <label class="text-label">Dokumen Gereja</label>
                        <input accept="image/*" type="file" class="form-control-nikita form-control-sm" name="dokumen_gereja" id="dokumen_gereja"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a class="bg-dark btn text-white" href="<?=base_url('anggota/list')?>">Kembali</a>
                    </div>
                    <div class="col-6 text-right">
                        <button type="submit" class="btn btn-main-nikita text-white">Simpan</button>
                    </div>
                </div>
            </form>    
        </div>    
    <?php } ?>
<?php } else { ?>
    <h6 class="text-white">Data Tidak Ditemukan</h6>
<?php } ?> 