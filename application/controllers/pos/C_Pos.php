<?php

class C_Pos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('pos/M_Pos', 'pos');
        $this->load->model('admin/M_Admin', 'admin');
        if(!$this->general_library->isLoggedIn(['admin'])){
            redirect('logout');
        };
    }

    public function pos(){
        render('pos/V_Pos', 'kasir', 'kasir', null);
    }

    public function createNewTransaksi(){
        echo json_encode($this->pos->createNewTransaksi($this->input->post()));
    }

    public function reloadListTransaksi($id = 0, $year = '', $month = '', $date = ''){
        $data['id_active'] = $id;
        $data['transaksi'] = $this->pos->reloadListTransaksi($year, $month, $date);
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function loadTransaksiAktif($id = 0, $year = '', $month = '', $date = ''){
        $data['id_active'] = $id;
        $data['transaksi'] = $this->pos->loadTransaksiAktif($year, $month, $date);
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function searchTransaksi($id = 0){
        $data['transaksi'] = $this->pos->searchTransaksi($this->input->post());
        $data['id_active'] = $id;
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function searchTransaksiAktif($id = 0){
        $data['transaksi'] = $this->pos->searchTransaksiAktif($this->input->post());
        $data['id_active'] = $id;
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function loadTransaksiLunas($id = 0, $year = '', $month = '', $date = ''){
        $data['id_active'] = $id;
        $data['transaksi'] = $this->pos->loadTransaksiLunas($year, $month, $date);
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function searchTransaksiLunas($id = 0){
        $data['id_active'] = $id;
        $data['transaksi'] = $this->pos->searchTransaksiLunas($this->input->post());
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function loadTransaksiBelumLunas($id = 0, $year = '', $month = '', $date = ''){
        $data['id_active'] = $id;
        $data['transaksi'] = $this->pos->loadTransaksiBelumLunas($year, $month, $date);
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function searchTransaksiBelumLunas($id = 0){
        $data['id_active'] = $id;
        $data['transaksi'] = $this->pos->searchTransaksiBelumLunas($this->input->post());
        if(TRANSAKSI_TABLE_VIEW == 1){
            $this->load->view('pos/V_ListTransaksi2', $data);
        } else {
            $this->load->view('pos/V_ListTransaksi', $data);
        }
    }

    public function loadSelectedTransaksi($id){
        list($data['transaksi'], $data['detail_transaksi']) = $this->pos->loadSelectedTransaksi($id);
        $data['list_item'] = $this->general->getAllWithOrder('m_item_barang', 'nama_item', 'asc');
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_transaksi', $id, 1);
        $this->session->set_userdata([
            'transaksi' => $data['transaksi'],
            'detail_transaksi' => $data['detail_transaksi'],
            'pembayaran' => $data['pembayaran']
        ]);
        $this->load->view('pos/V_SelectedTransaksi', $data);
    }

    public function loadSelectedTransaksiFromLaporan($id){
        list($data['transaksi'], $data['detail_transaksi']) = $this->pos->loadSelectedTransaksi($id);
        $data['list_item'] = $this->general->getAllWithOrder('m_item_barang', 'nama_item', 'asc');
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_transaksi', $id, 1);
        $this->session->set_userdata([
            'transaksi' => $data['transaksi'],
            'detail_transaksi' => $data['detail_transaksi'],
            'pembayaran' => $data['pembayaran']
        ]);
        $this->load->view('pos/V_SelectedTransaksiFromLaporan', $data);
    }

    public function editTransaksi(){
        $data_edit = $this->input->post();
        $id = $data_edit['id'];
        unset($data_edit['id']);
        $this->pos->editTransaksi($data_edit, $id);
    }

    public function tambahDetailTransaksi(){
        $data_input = $this->input->post();
        $data_input['harga_per_item'] = clearString($data_input['harga_per_item']);
        $data_input['total'] = clearString($data_input['total']);
        $data_input['created_by'] = $this->general_library->getId();
        echo json_encode($this->pos->tambahDetailTransaksi($data_input));
    }

    public function loadDetailTransaksi($id, $flag_kasir = 1){
        $data['result'] = $this->pos->loadDetailTransaksi($id);
        $this->session->set_userdata('detail_transaksi', $data['result']);
        $data['pembayaran'] = $this->session->userdata('pembayaran');
        $data['transaksi'] = $this->session->userdata('transaksi');
        $data['flag_kasir'] = $flag_kasir;
        $this->load->view('pos/V_DetailTransaksi', $data);
    }

    public function deleteDetailTransaksi($id){
        echo json_encode($this->pos->deleteDetailTransaksi($id));
    }

    public function modalUpdateItemDetailTransaksi($id, $id_t_transaksi){
        $data['id'] = $id;
        $data['id_t_transaksi'] = $id_t_transaksi;
        $data['item'] = $this->pos->modalUpdateItemDetailTransaksi($id);
        $this->load->view('pos/V_UpdateItemDetailTransaksi', $data);
    }

    public function updateItemBarang(){
        echo json_encode($this->pos->updateItemBarang($this->input->post()));
    }

    public function deleteTransaksi($id){
        $this->pos->deleteTransaksi($id);
    }

    public function loadPembayaran($id, $flag_kasir = 1){
        // $data['pembayaran'] = $this->session->userdata('pembayaran');
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_transaksi', $id, 1);
        $data['transaksi'] = $this->general->getOne('t_transaksi', 'id', $id, 1);
        $data['flag_kasir'] = $flag_kasir;
        $this->load->view('pos/V_Pembayaran', $data);
    }

    public function createPembayaran($id_t_transaksi){
        $data = $this->input->post();
        $data['new_total_biaya'] = clearString($data['new_total_biaya']);
        $data['diskon_nominal'] = clearString($data['diskon_nominal']);
        if($data['diskon_presentase'] > 0){
            $data['diskon_nominal'] = ($data['diskon_presentase'] * $data['new_total_biaya']) / 100;
        }
        $data['diskon_nominal'] = clearString($data['diskon_nominal']);
        $data['new_total_biaya_after_diskon'] = clearString($data['new_total_biaya_after_diskon']);
        $data['jumlah_pembayaran'] = clearString($data['jumlah_pembayaran']);
        $data['kembalian'] = clearString($data['kembalian']);
        // $data['selisih'] = 0;
        if($data['jumlah_pembayaran'] < $data['new_total_biaya_after_diskon']){
            // $data['selisih'] =  $data['new_total_biaya_after_diskon'] - $data['jumlah_pembayaran'];
            $data['kembalian'] = 0;
        }
        $data['id_t_transaksi'] = $id_t_transaksi;
        $this->pos->createPembayaran($data);
    }

    public function deletePembayaran($id_t_pembayaran, $id_t_transaksi){
        $this->pos->deletePembayaran($id_t_pembayaran, $id_t_transaksi);
    }

    public function cetakBill(){
        $data['result'] = $this->session->userdata('detail_transaksi');
        $data['transaksi'] = $this->session->userdata('transaksi');
        $this->load->view('pos/V_CetakBill', $data);
    }

    public function cetakPembayaran(){
        $data['result'] = $this->session->userdata('detail_transaksi');
        $data['transaksi'] = $this->session->userdata('transaksi');
        $data['pembayaran'] = $this->session->userdata('pembayaran');
        $this->load->view('pos/V_CetakPembayaran', $data);
    }

    public function loadTransaksiForMerge($id = 0){
        list($data['result'], $data['current_transaksi'], $data['list_merge']) = $this->pos->getTransaksiForMerge($id);
        $this->load->view('pos/V_ListTransaksiForMerge', $data);
    }

    public function mergeBill($id_merge, $parent_id){
        echo json_encode($this->pos->mergeBill($id_merge, $parent_id));
    }

    public function deleteMerge($id_merge, $parent_id){
        echo json_encode($this->pos->deleteMerge($id_merge, $parent_id));
    }

}
