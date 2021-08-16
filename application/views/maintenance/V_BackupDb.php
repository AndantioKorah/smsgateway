<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title"><strong>HISTORY BACKUP DATABASE</strong></h3>
        <button onclick="backupDatabase()" id="btn_backup" class="btn btn-sm btn-navy float-right"><i class="fa fa-hdd"></i> Backup Database</button>
        <button disabled style="display: none;" id="btn_loading" class="btn btn-sm btn-navy float-right"><i class="fa fa-spin fa-spinner"></i> Melakukan Backup. . .</button>
    </div>
    <div class="card-body" id="div_history_backup">
    </div>
</div>
<script>
    $(function(){
        loadHistorybackup()
    })

    function backupDatabase(){
        $('#btn_backup').hide()
        $('#btn_loading').show()
        $.ajax({
            url: '<?=base_url("maintenance/C_Maintenance/backupDatabase")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                successtoast('backup berhasil')
                window.location=""
            }, error: function(err){
                console.log(err)
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function loadHistorybackup(){
        $('#div_history_backup').html('')
        $('#div_history_backup').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("maintenance/C_Maintenance/loadHistoryBackup")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_history_backup').html('')
                $('#div_history_backup').append(data)
            }, error: function(err){
                console.log(err)
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>