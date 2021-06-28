<div class="row">
    <!-- <div class="col-lg-12 col-md-6 col-sm-6">

    </div> -->
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
                <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <span class="nav-tabs-title">Pilih Menu:</span>
                    <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#kategori" data-toggle="tab">
                        Kategori
                        <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sub_kategori" onclick="loadSubKategori()" data-toggle="tab">
                        Sub Kategori
                        <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#item_barang" data-toggle="tab">
                        Item
                        <div class="ripple-container"></div>
                        </a>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="kategori">
                        <?php $this->load->view('barang/V_KategoriBarang')?>
                    </div>
                    <div class="tab-pane" id="sub_kategori">
                    </div>
                    <div class="tab-pane" id="item_barang">
                        <table class="table">
                        <tbody>
                            <tr>
                            <td>
                                <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    <span class="form-check-sign">
                                    <span class="check"></span>
                                    </span>
                                </label>
                                </div>
                            </td>
                            <td>گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا طراحان گرافیک برای صفحه‌آرایی، نخست از متن‌های آزمایشی؟</td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" title="ویرایش وظیفه" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="حذف" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                                </button>
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" checked>
                                    <span class="form-check-sign">
                                    <span class="check"></span>
                                    </span>
                                </label>
                                </div>
                            </td>
                            <td> از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا طراحان گرافیک برای صفحه‌آرایی، نخست از متن‌های آزمایشی ؟
                            </td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" title="ویرایش وظیفه" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="حذف" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                                </button>
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" checked>
                                    <span class="form-check-sign">
                                    <span class="check"></span>
                                    </span>
                                </label>
                                </div>
                            </td>
                            <td>از متن‌های آزمایشی و بی‌معنی استفاده می‌کنند تا صرفا به مشتری یا صاحب کار خود نشان دهند؟</td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" title="ویرایش وظیفه" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="حذف" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                                </button>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadSubKategori(){
        $('#sub_kategori').html('')
        $('#sub_kategori').append('<div id="loader" class="col-12 text-center"><h5><i class="fa fa-spin fa-spinner fa-3x"></i> LOADING...<h5></div>')
        $('#sub_kategori').load('<?=base_url("admin/C_Admin/loadSubKategori")?>', function(){
            $('#loader').hide()
        })
    }
</script>