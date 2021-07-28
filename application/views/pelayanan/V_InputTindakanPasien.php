
        <div class="col-12 mt-2">
        <form id="form_input_tindakan">
        <input  class="col-12" type='hidden' placeholder="Cari Tindakan..." id='id_pendaftaran' value=<?php echo $id_pendaftaran;?>>
        <input  class="col-12" type='text' placeholder="Cari Tindakan..." autocomplete="off" id='input' onkeyup='searchTable()'>
        <table border="0" id='table'>

<?php $i=1; foreach($list_tindakan as $tindakan) { ?>
<tr>
    <td>
    <label>
        <input  type="checkbox" class="value1" name="check_list[]" alt="Checkbox" value="<?=$tindakan->id?>" > 
        <?=$tindakan->nama_tindakan?>
    </label><br>
</td>
</tr>
<?php $i++; } ?>
</table>
<button id="button_submit_input_tindakan" type="submit" class="btn btn-navy btn-sm"> Simpan </button>
</form>
    

    <br>
<div id="tabel_tindakan_pasien" class="row p-2" style="border-radius: 10px; border: 1px solid #001f3f;   background-color: #white;font-color: #000000;">
        <div class="col-12" style="border-bottom: 1px solid #001f3f;">
            <span style="font-size: 15px; font-weight: bold;">TINDAKAN PASIEN</span>
        </div>
        <div class="col-12 mt-2">
        <table class="table table-sm table-hover table-striped data_table_this">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Jenis Pemeriksaan</th>
      <th scope="col">Tindakan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Hematologi</td>
      <td>Hematologi Rutin</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Hematologi</td>
      <td>Hematologi Lengkap</td>
    </tr>

  </tbody>
</table>
    

    
</div>


<script>

$(function(){
                $('.data_table_this').DataTable({
                    responsive: false
                });
            })


$('#form_input_tindakan').on('submit', function(e){
   
        e.preventDefault()
        $('#button_loading').show()
        $('#button_submit_input_tindakan').hide('fast')
        
        var id_pendaftaran = $('#id_pendaftaran').val();
        var tindakan = [];
				$('.value1').each(function(){
					if($(this).is(":checked"))
					{
						tindakan.push($(this).val());
					}
				});
			// tindakan = tindakan.toString();
        $('#tabel_tindakan_pasien').hide('fast')
				$.ajax({
					url:"<?=base_url("pelayanan/C_Pelayanan/insertTindakan")?>",
					method:"POST",
					data:{id_pendaftaran:id_pendaftaran,tindakan:tindakan},
					success:function(data){
						$('#result').html(data);
					} , error: function(e){
                errortoast('Terjadi Kesalahan')
            }
		})

        $('#tabel_tindakan_pasien').show('fast')
        $('#button_submit_input_tindakan').show('fast')
    })

function searchTable() {
   
    var input;
    var saring;
    var status; 
    var tbody; 
    var tr; 
    var td;
    var i; 
    var j;
    input = document.getElementById("input");
    saring = input.value.toUpperCase();
    tbody = document.getElementsByTagName("tbody")[0];;
    tr = tbody.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(saring) > -1) {
                status = true;
            }
        }
        if (status) {
            tr[i].style.display = "";
            status = false;
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>