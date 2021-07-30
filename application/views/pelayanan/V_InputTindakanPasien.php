
        <div class="col-12 mt-2">
        <form id="form_input_tindakan">
        <input  class="col-12" type='hidden'  id='id_m_status_tagihan' value=<?php echo $id_tagihan['0']->id_m_status_tagihan;?>>
        <input  class="col-12" type='hidden'  id='id_tagihan' value=<?php echo $id_tagihan['0']->id;?>>
        <input  class="col-12" type='hidden'  id='id_pendaftaran' value=<?php echo $id_pendaftaran;?>>
        <input  class="col-12" type='hidden' placeholder="Cari Tindakan..." autocomplete="off" id='input' onkeyup='searchTable()'>
        
        <?php if($id_tagihan['0']->id_m_status_tagihan == 1){ ?>
            <select class='col-12' id="cari_tindakan" type='text' placeholder="Cari Tindakan...">Cari Tindakan...</select>
             <button id="button_submit_input_tindakan " type="submit" class="btn btn-navy btn-sm col-12 mt-2"> Simpan </button>
        <?php }?>

    
    </form>
            
       
        <div id="tabel_tindakan_pasien" class="row p-2 mt-4" style="border-radius: 10px; border: 1px solid #001f3f;   background-color: #white;font-color: #000000;">
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
            

        <div id="selesai_input_tindakan">
        <!-- <button id="button_selesai_input_tindakan" type="submit" class="btn btn-navy btn-sm col-12 mt-2"> Selesai </button> -->
        <!-- <button id="button_batal_selesai_input_tindakan"  class="btn btn-danger btn-sm col-6 mt-2"> Batal Selesai </button> -->
        <!-- <button id="button_cetak_hasil"  class="btn btn-navy btn-sm col-6 mt-2 float-right"> Cetak Hasil </button> -->
        </div>
</div>


<script>

$(function(){
    tampilTindakan()
    })
    $('.data_table_this').DataTable({
                    responsive: false
     });

$('#button_cetak_hasil').hide();
$('#button_batal_selesai_input_tindakan').hide();


$('#form_input_tindakan').on('submit', function(e){
        e.preventDefault() 
       
        var id_pendaftaran = $('#id_pendaftaran').val();
        var id_tagihan = $('#id_tagihan').val();
        // var tindakan = [];
		// 		$('.value1').each(function(){
		// 			if($(this).is(":checked"))
		// 			{
		// 				tindakan.push($(this).val());
		// 			}
		// 		});
        var tindakan = $('#cari_tindakan').val();
      
        if(tindakan == "" || tindakan == null){
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
                        let res = JSON.parse(data)
                        if(res.code == 1){
                         errortoast(res.message)
                        } 
                        tampilTindakan()
						// $('#result').html(data);
					} , error: function(e){
                errortoast('Terjadi Kesalahan')
            }
		})
        $('#button_submit_input_tindakan').show('fast')
    })

    $(document).on('click','#button_selesai_input_tindakan',function(){
    
        var id_pendaftaran = $('#id_pendaftaran').val();
         
    
     $('#daftar_tindakan').html('');
     $('#daftar_tindakan').append(divLoaderNavy)
				$.ajax({
					url:"<?=base_url("pelayanan/C_Pelayanan/selesaiTindakan")?>",
					method:"POST",
					data:{id_pendaftaran:id_pendaftaran},
					success:function(data){
                        let res = JSON.parse(data)
                        $('#form_input_tindakan').hide('fast')     
                        $('#button_selesai_input_tindakan').hide('fast');
                        $('#button_cetak_hasil').show('fast');
                        $('#button_batal_selesai_input_tindakan').show('fast');
                        $('.tombol_hapus_tindakan').hide();
                        tampilTindakan()
					} , error: function(e){
                errortoast('Terjadi Kesalahan')
            }
		})
    })

    $(document).on('click','#button_batal_selesai_input_tindakan',function(){
       $('#button_cetak_hasil').hide('fast');
       $('#button_batal_selesai_input_tindakan').hide('fast');
       $('#button_selesai_input_tindakan').show('fast');
       $('#form_input_tindakan').show('fast')  
       $('.tombol_hapus_tindakan').show(); 
    });

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
        var id_m_status_tagihan = $('#id_m_status_tagihan').val();
       
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
                //   console.log()
                        if(id_m_status_tagihan == 2){
                            style="style='display:none;'";
                        } else {
                            style="";
                        }

                        $('#loader').hide()
                        $('#daftar_tindakan').append(
                            '<tr>'+
                                '<td>'+no+'</td>'+
                                '<td>'+data[i].nm_jns_tindakan+'</td>'+
                                '<td>'+data[i].nama_tindakan+'</td>'+
                                '<td><button '+style+'  title="Hapus Tindakan"  class="btn btn-danger btn-sm tombol_hapus_tindakan" data-idtindakan="'+data[i].id+'"><i class="fa fa-trash fa-sm"></i></button></td>'+
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

    select2ajax('cari_tindakan', '<?=base_url("pelayanan/C_Pelayanan/select2Tindakan")?>', 'nm_tindakan', 'nm_tindakan',2);
    function select2ajax(elementid, url, value, label, minInputText = 2){
    $("#"+elementid).select2({
        placeholder: "Cari Tindakan...",
        tokenSeparators: [',', ' '],
        minimumInputLength: minInputText,
        minimumResultsForSearch: 10,
        ajax: {
            url: url,
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
               
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nm_tindakan,
                            id: item.id_tindakan
                        }
                    })
                };
            }
        }
    });
  }

</script>