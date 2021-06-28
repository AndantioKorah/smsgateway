<div class="col-12">
    <div class="mt-3">
        <h5 class="text-header">Daftar Anggota Baru</h5>
        <form action="<?= base_url('anggota/C_Anggota/insertAnggota') ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-4 form-group">
                <label class="text-label">Nama Lengkap</label>
                <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" id="nama" name="nama"/>
            </div>
            <div class="col-4 form-group">
                <label class="text-label">Tempat Lahir</label>
                <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" id="tempat_lahir" name="tempat_lahir"/>
            </div>
            <div class="col-4 form-group">
                <label class="text-label">Tanggal Lahir</label>
                <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" id="tanggal_lahir" name="tanggal_lahir"/>
            </div>
        </div>
        <div class="row">
            <div class="col-4 form-group">
                <label class="text-label">Alamat</label>
                <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" id="alamat" name="alamat"/>
            </div>
            <div class="col-4 form-group">
                <label class="text-label">Nomor Telepon</label>
                <input required autocomplete="off" type="text" class="form-control-nikita form-control-sm" id="nomor_telepon" name="nomor_telepon"/>
            </div>
            <div class="col-4 form-group">
                <label class="text-label">Jenis Anggota</label>
                <select class="form-control-nikita form-control-sm" id="jenis_anggota" name="jenis_anggota">
                    <?php foreach($bipra as $row) { ?>
                    <option class="bg-nikita-primary" value="<?= $row['id'] ?>">
                        <?= $row['keterangan'] ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4 form-group">
                <label class="text-label">Foto Anggota</label>
                <input required accept="image/*" type="file" class="form-control-nikita form-control-sm" id="foto_anggota" name="foto_profil"/>
            </div>
            <div class="col-4 form-group">
                <label class="text-label">Dokumen Negara</label>
                <input required accept="image/*" type="file" class="form-control-nikita form-control-sm" id="dokumen_negara" name="dokumen_negara"/>
            </div>
            <div class="col-4 form-group">
                <label class="text-label">Dokumen Gereja</label>
                <input required accept="image/*" type="file" class="form-control-nikita form-control-sm" id="dokumen_gereja" name="dokumen_gereja"/>
            </div>
        </div>
        <div class="row">
            <div class="col-6"></div>
            <div class="col-6 text-right">
                <button type="submit" class="btn btn-main-nikita text-white">Simpan</button>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#tanggal_lahir').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        // $('input[type=file]').change(function () {
        //     console.log(this.files[0]);
        //     var reader = new FileReader();
        //     reader.readAsDataURL(this.files[0]);
        //     var me = this;
        //     reader.onload = function () {
        //     var fileContent = reader.result;
        //     console.log(fileContent)};
        // });
        
        refreshInput();
        
    });

    function isEmpty(data)
	{
		return data == null || data == "" || data == 0 ? true : false;
	}

    $(document).on('click', '#saveBtn', function(){

        let nama = $('#nama').val();
        let tempat_lahir = $('#tempat_lahir').val();
        let tanggal_lahir = $('#tanggal_lahir').val();
        
        let alamat = $('#alamat').val();
        let nomor_telepon = $('#nomor_telepon').val();
        let jenis_anggota = $('#jenis_anggota').val();

        let foto_anggota = $('#foto_anggota').val();
        let dokumen_negara = $('#dokumen_negara').val();
        let dokumen_gereja = $('#dokumen_gereja').val();

        if(isEmpty(nama)){
            alert('Nama Lengkap tidak boleh kosong');
            return false;
        } else if(isEmpty(tempat_lahir)){
            alert('Tempat Lahir tidak boleh kosong');
            return false;
        } else if(isEmpty(tanggal_lahir)){
            alert('Tanggal Lahir tidak boleh kosong');
            return false;
        } else if(isEmpty(alamat)){
            alert('Alamat tidak boleh kosong');
            return false;
        } else if(isEmpty(nomor_telepon)){
            alert('Nomor Telepon tidak boleh kosong');
            return false;
        } else {
            $.post(
            base_url + "anggota/C_Anggota/insertAnggota", {
                nama: nama,
                id_m_bipra: jenis_anggota,
                tempat_lahir: tempat_lahir,
                tanggal_lahir: tanggal_lahir,
                nomor_telpon: nomor_telepon,
                alamat: alamat 
            }
            )
            .done(function (data) {
                showDataAnggota();
                refreshInput();
            })
            .fail(function (err) {
                alert(err.status);
            });
        }
    });

    function refreshInput(){
        $('#nama').val("");
        $('#tempat_lahir').val("");
        $('#tanggal_lahir').val("");
        $('#nomor_telepon').val("");
        $('#alamat').val("");
        $('#jenis_anggota').val(1);      
    }

    function showDataAnggota(){
		$("#listAnggota").html('<div class="col loader"><h5>Mengambil Data...</h5></div>');
		$("#listAnggota").load('<?=base_url('anggota/C_Anggota/getAllAnggota')?>', function(){
			$('.listAnggota').hide();
		});
	}
</script>