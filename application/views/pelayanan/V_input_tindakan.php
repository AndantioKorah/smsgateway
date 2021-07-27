
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Daftar Pasien</h3>
    </div>
    <div class="card-body">
        <div id="list_menu" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadDaftarPasien()
    })

    function loadDaftarPasien(){
        $('#list_menu').html('')
        $('#list_menu').append(divLoaderNavy)
        $('#list_menu').load('<?=base_url("pelayanan/C_pelayanan/loadDaftarPasien")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_menu').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("user/C_User/createMenu")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    window.location=""
                    successtoast('Menu telah ditambahkan')
                    $('#nama_menu').val('')
                    $('#url').val('')
                    $('#keterangan').val('')
                    $('#icon').val('')
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>