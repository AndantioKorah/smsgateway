<?php if($item){ ?>
    <div class="modal-header">
        <h5 class="modal-title">Update Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="form_update_item">
            <div class="row">
                <div class="col-12">
                    <label>Nama Item:</label>
                    <input class="form-control form-control-sm" readonly autocomplete="off" value="<?=$item['nama_item']?>" type="input" />
                </div>
                <div class="col-12">
                    <label>Kuantitas:</label>
                    <input class="form-control form-control-sm" autocomplete="off" style="display:none;" value="<?=$item['id']?>" name="id" type="input" />
                    <input class="form-control form-control-sm" autocomplete="off" style="display:none;" value="<?=$item['id_m_item_barang']?>" name="id_m_item_barang" type="input" />
                    <input class="form-control form-control-sm" autocomplete="off" style="display:none;" value="<?=$item['id_t_transaksi']?>" name="id_t_transaksi" type="input" />
                    <input class="form-control form-control-sm" oninput="onTypingEdit()" autocomplete="off" value="<?=$item['qty']?>" 
                    name="qty" id="qty_edit" type="number" />
                </div>
                <div class="col-12">
                    <label>Harga:</label>
                    <input class="form-control form-control-sm format_currency_this" oninput="onTypingEdit()" autocomplete="off" value="<?=formatCurrencyWithoutRp($item['harga_per_item'])?>" 
                    name="harga_per_item" id="harga_per_item_edit" type="input" />
                </div>
                <div class="col-12">
                    <label>Total:</label>
                    <input class="form-control form-control-sm format_currency_this" oninput="onTypingEdit()" autocomplete="off" readonly value="<?=formatCurrencyWithoutRp($item['total'])?>" 
                    name="total" id="total_edit" type="input" />
                </div>
                <div class="col-12">
                    <label>Catatan:</label>
                    <input class="form-control form-control-sm" autocomplete="off" value="<?=$item['catatan']?>" 
                    name="catatan" id="catatan_edit" type="input" />
                </div>
                
                <div class="col-12 text-right mt-2">
                    <button type="submit" class="btn btn-sm btn-navy">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            $('.format_currency_this').on('keypress', function(event){
                if(event.charCode >= 48 && event.charCode <= 57){
                    return true;
                } else {
                    return false;
                }
            })

            function formatRupiah(angka, prefix = "Rp ") {
                var number_string = angka.replace(/[^,\d]/g, "").toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? rupiah : "";
            }

            $('.format_currency_this').on('keyup', function(){
                $(this).val(formatRupiah($(this).val()))
            })
        })
        
        function rupiahkanEdit(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }

        function onTypingEdit(){
            let harga = $('#harga_per_item_edit').val().replace(/[^a-zA-Z0-9]/g, '');
            let qty = $('#qty_edit').val()
            let total_harga = harga * qty
            $('#total_edit').val(rupiahkanEdit(total_harga))
        }

        $('#form_update_item').on('submit', function(e){
            e.preventDefault()
            if($('#qty_edit').val() == "" || $('#qty_edit').val() == 0 || $('#qty_edit').val() < 0){
                errortoast('Kuantitas tidak valid')
                return false
            }
            if($('#harga_per_item_edit').val() == "" || $('#harga_per_item_edit').val() == 0 || $('#harga_per_item_edit').val() < 0){
                errortoast('Kuantitas tidak valid')
                return false
            }
            $.ajax({
                url: '<?=base_url("pos/C_Pos/updateItemBarang")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(data){
                    let resp = JSON.parse(data)
                    $('#total_biaya_val').html('<strong>'+rupiahkanWithRp(resp['new_total_biaya'])+'</strong>')
                    $('#label_list_total_biaya_'+'<?=$item['id_t_transaksi']?>').html('<strong>'+rupiahkanWithRp(resp['new_total_biaya'])+'</strong>')
                    reloadListDetailTransaksi()
                    reloadListTransaksi()
                    $('#custom_modal').modal('toggle');
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
<?php } else { ?>
    <div class="col-12 text-center"><h6>TERJADI KESALAHAN<br>hubungi customer service</h6></div>
<?php } ?>