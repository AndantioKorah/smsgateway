
        <div class="col-12 mt-2">
        <form id="form_input_tindakan">
        <input  class="col-12" type='hidden'  id='id_tagihan' value=<?php echo $id_tagihan['0']->id;?>>
        <input  class="col-12" type='hidden'  id='id_pendaftaran' value=<?php echo $id_pendaftaran;?>>
        <input  class="col-12" type='text' placeholder="Cari Tindakan..." autocomplete="off" id='input' onkeyup='searchTable()'>
        <table border="0" id='table'>

            <?php $i=1; foreach($list_tindakan as $tindakan) { ?>
            <tr>
                <td>
                <label>
                    <input  type="checkbox" class="value1" name="check_list[]" alt="Checkbox" value="<?=$tindakan->id_tindakan?>" > 
                    <?=$tindakan->nm_tindakan?>
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
            <th scope="col">No</th>
            <th scope="col">Jenis Pemeriksaan</th>
            <th scope="col">Tindakan</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="daftar_tindakan">
        </tbody>
        </table>
            

    
</div>


<script>

$(function(){
    tampilTindakan()
    })
    $('.data_table_this').DataTable({
                    responsive: false
     });




$('#form_input_tindakan').on('submit', function(e){
        e.preventDefault() 
        
        var id_pendaftaran = $('#id_pendaftaran').val();
        var id_tagihan = $('#id_tagihan').val();
        var tindakan = [];
				$('.value1').each(function(){
					if($(this).is(":checked"))
					{
						tindakan.push($(this).val());
					}
				});
        if(tindakan == ""){
            errortoast('  Tindakan Belum dipilih')
            $('#button_submit_input_tindakan').show('fast')
            return false
        }  
        $('#button_loading').show()
        $('#button_submit_input_tindakan').hide('fast')     
           
	// tindakan = tindakan.toString();
    $('#daftar_tindakan').html('');
     $('#daftar_tindakan').append(divLoaderNavy)
				$.ajax({
					url:"<?=base_url("pelayanan/C_Pelayanan/insertTindakan")?>",
					method:"POST",
					data:{id_pendaftaran:id_pendaftaran,tindakan:tindakan,id_tagihan:id_tagihan},
					success:function(data){
                        tampilTindakan()
						// $('#result').html(data);
					} , error: function(e){
                errortoast('Terjadi Kesalahan')
            }
		})
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


function tampilTindakan()
    {            
        var id_pendaftaran = $('#id_pendaftaran').val();
       
        $.ajax({
            url:"<?=base_url("pelayanan/C_Pelayanan/getTindakanPasien")?>",
            data : {id_pendaftaran : id_pendaftaran },
            method : 'post',
            dataType : 'json',
            success : function (data){ 
                                                
                $('#daftar_tindakan').html('');
                
                let no = 1;    
                if (data != 0){                    
                    $.each(data, function (i, item){
                        $('#loader').hide()
                        $('#daftar_tindakan').append(
                            '<tr>'+
                                '<td>'+no+'</td>'+
                                '<td>'+data[i].nm_jns_tindakan+'</td>'+
                                '<td>'+data[i].nama_tindakan+'</td>'+
                                '<td><button title="Hapus Tindakan"  class="btn btn-danger btn-sm tombol_hapus_tindakan" data-idtindakan="'+data[i].id+'"><i class="fa fa-trash fa-sm"></i></button></td>'+
                            '</tr>'
                        );
                        no++;
                    });                      
                } else {
                    $('#daftar_tindakan').append('<tr><td colspan="6">Belum Ada Tindakan</td></tr>');
                }         
            },
            error : function (err){
                console.log(err);
            }

        })        
    }

    $('#daftar_tindakan').on('click','.tombol_hapus_tindakan',function(){
        var base_url = 'http://localhost/lab/';
        var id_pendaftaran = $('#id_pendaftaran').val();
         if(confirm('Apakah anda yakin?')){ 
            $(this).html('<i class="fas fa-spinner fa-spin"></i>')
            let idtindakan = $(this).data('idtindakan');
            $.post(
                base_url+"pelayanan/C_Pelayanan/delTindakanPasien", 
                { 
                    idtindakan : idtindakan, id_pendaftaran:id_pendaftaran
                }
            )
            .done(function(data) {                                  
            })
            .fail(function(err){
                $(this).html('<i class="fas fa-trash"></i>')
                customAlert(err.status);
            });
            $(this).closest("tr").fadeOut();    
        }
    });

</script>