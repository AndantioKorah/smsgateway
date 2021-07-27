<?php if($result){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped" style="width:100%;" id="data_table">
            <thead>
                <th class="text-center">No</th>
                <th>Nama Pasien</th>
                <th>Tanggal Daftar</th>
                <th>Nomor Lab</th>
                <th></th>
            </thead>
            <tbody>
           <tr>
               <td>1</td>
               <td>Testing</td>
               <td>10-10-2021</td>
               <td>12345</td>
               <td> 
               <a href="<?=base_url('user/setting')?>">
               <button type="button" data-toggle="modal"  class="btn btn-sm btn-info"
                            data-tooltip="tooltip" title="Tambah Role"><i class="fa fa-user"></i> Pilih</button>                
                </a>
               </td>
           </tr>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="add_role_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-xl">
            <div class="modal-content">
                <div id="add_role_modal_content">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            let table = $('#data_table').DataTable({
                responsive: false
            });
            $('[data-tooltip="tooltip"]').tooltip();
        })

        function openAddRoleModal(id){
            $('#add_role_modal_content').html('')
            $('#add_role_modal_content').append(divLoaderNavy)
            $('#add_role_modal_content').load('<?=base_url("user/C_User/addRoleForMenu")?>'+'/'+id, function(){

            })
        }

        function hapus(id){
            if(confirm('Apakah Anda yakin ingin menghapus data ini ?')){
                $.ajax({
                    url: '<?=base_url("user/C_User/deleteMenu/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        window.location=""
                        // loadMenu()
                    }, error: function(e){
                        alert('Terjadi Kesalahan')
                    }
                })   
            }
        }
    </script>
<?php } else { ?>
    <div class="col-12 text-center"><h6>Belum ada Data Menu</h6></div>
<?php } ?>