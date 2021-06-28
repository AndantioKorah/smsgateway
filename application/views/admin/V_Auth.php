<div class="modal-header">
    <h5 class="modal-title">Otentikasi User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="otentikasi_form">
        <div class="row">
            <div class="col-12">
                <label>User Admin:</label>
                <input class="form-control form-control-sm" autocomplete="off" name="username" type="input" />
            </div>
            <div class="col-12">
                <label>Password:</label>
                <input class="form-control form-control-sm" autocomplete="off" name="password" type="password" />
            </div>
            <div class="col-12 text-right mt-3">
                <button type="submit" class="btn btn-sm btn-navy">Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
    $('#otentikasi_form').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("login/C_Login/otentikasiUser")?>'+'/'+'<?=$jenis_transaksi?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp['code'] == 0){
                    errortoast('Kombinasi Username & Password tidak ditemukan atau Username yang Anda masukkan bukan User untuk Admin / Super Admin')
                }else if(resp['code'] == 1){
                    deleteDetailTransaksi('<?=$id?>', '<?=$id_t_transaksi?>')
                } else if(resp['code'] == 2){
                    updateTransaksi('<?=$id?>', '<?=$id_t_transaksi?>')
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function errortoast(message = ''){
        const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: timertoast
        });

        Toast.fire({
        icon: 'error',
        title: message
        })
    }
</script>