<?php

class C_Admin extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('admin/M_Admin', 'admin');
        $this->load->model('general/M_General', 'general');
        if(!$this->general_library->isLoggedIn(['kasir'])){
            redirect('logout');
        };
    }

    public function dashboard(){
        render('admin/V_Dashboard', 'dashboard', 'dashboard', null);
    }

    public function index(){
        render('admin/V_WelcomeAdmin', 'welcome', 'welcome', null);
    }

    public function kategori_barang(){
        render('barang/V_KategoriBarang', 'master_barang', 'kategori_barang', null);
    }

    public function loadKategori(){
        $data['result'] = $this->general->getAllWithOrder('m_kategori_barang', 'created_date', 'desc');
        $this->load->view('barang/V_KategoriBarangItem', $data);
    }

    public function deleteKategori($id){
        $this->general->delete('id', $id, 'm_kategori_barang');
    }

    public function insert_kategori_barang(){
        $insert_data = $this->input->post();
        $this->admin->insert('m_kategori_barang', $insert_data);
    }

    public function searchKategori(){
        dd($this->input->post());
        echo json_encode($this->admin->searchKategori());
    }

    public function loadSubKategori(){
        $data['result'] = $this->admin->getAllSubKategoriBarang();
        $this->load->view('barang/V_SubKategoriBarangItem', $data);
    }

    public function sub_kategori_barang(){
        $data['list_kategori'] = $this->general->getAllWithOrder('m_kategori_barang', 'created_date', 'desc');
        render('barang/V_SubKategoriBarang', 'master_barang', 'sub_kategori_barang', $data);
    }

    public function insert_sub_kategori_barang(){
        $this->admin->insert('m_sub_kategori_barang', $this->input->post());
    }

    public function deleteSubKategori($id){
        $this->general->delete('id', $id, 'm_sub_kategori_barang');
    }

    public function insert_item(){
        $data = $this->input->post();
        $data['harga'] = clearString($data['harga']);
        $this->admin->insert('m_item_barang', $data);
    }

    public function item_barang(){
        $data['list_sub_kategori'] = $this->general->getAllWithOrder('m_sub_kategori_barang', 'created_date', 'desc');
        render('barang/V_ItemBarang', 'master_barang', 'item_barang', $data);
    }

    public function loadItem(){
        $data['result'] = $this->admin->getAllItem();
        $this->load->view('barang/V_ItemItem', $data);
    }

    public function deleteItembarang($id){
        $this->general->delete('id', $id, 'm_item_barang');
    }

    public function stock_barang(){
        $data['list_item'] = $this->general->getAllWithOrder('m_item_barang', 'nama_item', 'asc');
        render('barang/V_StockBarang', 'master_barang', 'stock_barang', $data);
    }

    public function loadStock($id){
        $data['result'] = $this->admin->getStockItem($id);
        $this->load->view('barang/V_ItemStockBarang', $data);
    }

    public function masterPengeluaran(){
        render('master/V_MasterPengeluaran', 'jenis_transaksi', 'master_pengeluaran', null);
    }

    public function insert_jenis_pengeluaran(){
        $this->admin->insert('m_jenis_pengeluaran', $this->input->post());
    }

    public function loadJenisPengeluaran(){
        $data['result'] = $this->general->getAllWithOrder('m_jenis_pengeluaran', 'created_date', 'desc');
        $this->load->view('master/V_MasterPengeluaranList', $data);
    }

    public function deleteJenisPengeluaran($id){
        $this->general->delete('id', $id, 'm_jenis_pengeluaran');
    }

    public function masterPembelian(){
        render('master/V_MasterPembelian', 'jenis_transaksi', 'master_pembelian', null);
    }

    public function insert_jenis_Pembelian(){
        $this->admin->insert('m_jenis_pembelian', $this->input->post());
    }

    public function loadJenisPembelian(){
        $data['result'] = $this->general->getAllWithOrder('m_jenis_pembelian', 'created_date', 'desc');
        $this->load->view('master/V_MasterPembelianList', $data);
    }

    public function deleteJenisPembelian($id){
        $this->general->delete('id', $id, 'm_jenis_pembelian');
    }

    public function transaksiPembelian(){
        render('pembelian/V_Pembelian', 'transaksi_pembelian', 'transaksi_pembelian', null);
    }

    public function searchTransaksiPembelian(){
        $data['result'] = $this->admin->searchTransaksiPembelian($this->input->post());
        $this->load->view('pembelian/V_RiwayatPembelian', $data);
    }

    public function createTransaksiPembelian(){
        echo json_encode($this->admin->createTransaksiPembelian($this->input->post()));
    }

    public function detailPembelian($id){
        list($data['pembelian'], $data['detail']) = $this->admin->detailPembelian($id);
        $data['jenis_pembelian'] = $this->general->getAllWithOrder('m_jenis_pembelian', 'nama_pembelian', 'asc');
        render('pembelian/V_PembelianDetail', 'transaksi_pembelian', 'transaksi_pembelian', $data);
    }

    public function loadListPembelianDetail($id){
        list($data['pembelian'], $data['detail']) = $this->admin->detailPembelian($id);
        $this->load->view('pembelian/V_ListPembelianDetail', $data);
    }

    public function createPembelianDetail(){
        $data = $this->input->post();
        $data['qty'] = clearString($data['qty']);
        $data['total_harga'] = clearString($data['total_harga']);
        $data['harga_per_item'] = clearString($data['harga_per_item']);
        $data['created_by'] = $this->general_library->getId();
        $this->admin->insert('t_pembelian_detail', $data);
    }

    public function deletePembelianDetail($id){
        $this->general->delete('id', $id, 't_pembelian_detail');
    }

    public function simpanTransaksiPembelian($id){
        $this->admin->simpanTransaksiPembelian($id, $this->input->post());
    }

    //pengeluaran
    public function transaksiPengeluaran(){
        render('pengeluaran/V_Pengeluaran', 'transaksi_pengeluaran', 'transaksi_pengeluaran', null);
    }

    public function searchTransaksiPengeluaran(){
        $data['result'] = $this->admin->searchTransaksiPengeluaran($this->input->post());
        $this->load->view('pengeluaran/V_RiwayatPengeluaran', $data);
    }

    public function createTransaksiPengeluaran(){
        echo json_encode($this->admin->createTransaksiPengeluaran($this->input->post()));
    }

    public function detailPengeluaran($id){
        list($data['pengeluaran'], $data['detail']) = $this->admin->detailPengeluaran($id);
        $data['jenis_pengeluaran'] = $this->general->getAllWithOrder('m_jenis_pengeluaran', 'nama_pengeluaran', 'asc');
        render('pengeluaran/V_pengeluaranDetail', 'transaksi_pengeluaran', 'transaksi_pengeluaran', $data);
    }

    public function loadListPengeluaranDetail($id){
        list($data['pengeluaran'], $data['detail']) = $this->admin->detailPengeluaran($id);
        $this->load->view('pengeluaran/V_ListPengeluaranDetail', $data);
    }

    public function createPengeluaranDetail(){
        $data = $this->input->post();
        $data['qty'] = clearString($data['qty']);
        $data['total_harga'] = clearString($data['total_harga']);
        $data['harga_per_item'] = clearString($data['harga_per_item']);
        $data['created_by'] = $this->general_library->getId();
        $this->admin->insert('t_pengeluaran_detail', $data);
    }

    public function deletePengeluaranDetail($id){
        $this->general->delete('id', $id, 't_pengeluaran_detail');
    }

    public function simpanTransaksiPengeluaran($id){
        $this->admin->simpanTransaksiPengeluaran($id, $this->input->post());
    }
	
	public function hapusTransaksiPembelian($id){
        $this->general->delete('id', $id, 't_pembelian');
    }
	
	public function hapusTransaksiPengeluaran($id){
        $this->general->delete('id', $id, 't_pengeluaran');
    }
}
