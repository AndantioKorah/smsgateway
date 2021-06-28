<?php

class C_Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/m_general', 'general');
        $this->load->model('laporan/M_Laporan', 'laporan');
        if(!$this->general_library->isLoggedIn(['kasir'])){
            redirect('logout');
        };
    }

    public function laporanTransaksi(){
        render('laporan/V_LaporanTransaksi', 'laporan', 'laporan_transaksi', null);
    }

    public function searchLaporanTransaksi(){
        list($data['result'], $data['total_tagihan'], $data['jumlah_orang']) = $this->laporan->searchLaporanTransaksi($this->input->post());
        $data['search'] = $this->input->post();
        $this->session->set_userdata([
            'result_laporan_transaksi' => json_encode($data)
        ]);
        $this->load->view('laporan/V_LaporanTransaksiResult', $data);
    }

    public function printLaporanTransaksi($flag_print = 0){
        $result = json_decode($this->session->userdata('result_laporan_transaksi'), true);
        $data['result'] = $result['result'];
        $data['search'] = $result['search'];
        $data['total_tagihan'] = $result['total_tagihan'];
        $data['jumlah_orang'] = $result['jumlah_orang'];
        $data['flag_print'] = $flag_print;
        $this->load->view('laporan/V_LaporanTransaksiPrint', $data);
    }

    public function laporanPenjualan(){
        $data['kategori'] = $this->general->getAllWithOrder('m_kategori_barang', 'nama_kategori', 'asc');
        $data['sub_kategori'] = $this->general->getAllWithOrder('m_sub_kategori_barang', 'nama_sub_kategori', 'asc');
        $data['item'] = $this->general->getAllWithOrder('m_item_barang', 'nama_item', 'asc');
        render('laporan/V_LaporanPenjualan', 'laporan', 'laporan_penjualan', $data);
    }

    public function searchLaporanPenjualan(){
        list($data['result'], $data['total_biaya']) = $this->laporan->searchLaporanPenjualan($this->input->post());
        $data['search'] = $this->input->post();
        $this->session->set_userdata([
            'result_laporan_penjualan' => json_encode($data)
        ]);
        $this->load->view('laporan/V_LaporanPenjualanResult', $data);
    }

    public function printLaporanPenjualan($flag_print = 0){
        $result = json_decode($this->session->userdata('result_laporan_penjualan'), true);
        $data['result'] = $result['result'];
        $data['search'] = $result['search'];
        $data['total_biaya'] = $result['total_biaya'];
        $data['flag_print'] = $flag_print;
        $this->load->view('laporan/V_LaporanPenjualanPrint', $data);
    }

    public function laporanPembayaran(){
        render('laporan/V_LaporanPembayaran', 'laporan', 'laporan_pembayaran', null);
    }

    public function searchLaporanPembayaran(){
        list($data['result'], $data['total_tagihan'], $data['total_pembayaran']) = $this->laporan->searchLaporanPembayaran($this->input->post());
        $data['search'] = $this->input->post();
        $this->session->set_userdata([
            'result_laporan_pembayaran' => json_encode($data)
        ]);
        $this->load->view('laporan/V_LaporanPembayaranResult', $data);
    }

    public function printLaporanPembayaran($flag_print = 0){
        $result = json_decode($this->session->userdata('result_laporan_pembayaran'), true);
        $data['result'] = $result['result'];
        $data['search'] = $result['search'];
        $data['total_tagihan'] = $result['total_tagihan'];
        $data['total_pembayaran'] = $result['total_pembayaran'];
        $data['flag_print'] = $flag_print;
        $this->load->view('laporan/V_LaporanPembayaranPrint', $data);
    }

    public function rekapHarian(){
        render('laporan/V_RekapHarian', 'laporan', 'rekap_harian', null);
    }

    public function searchRekapHarian(){
        list($data['kategori'], $data['sub_kategori'], $data['item'], $data['jumlah_item'], $data['jumlah_orang'], $data['transaksi'], 
        $data['total_biaya_transaksi'], $data['pembayaran'], $data['total_pembayaran'], $data['detail_transaksi'], $data['pengeluaran'], $data['total_pengeluaran'],
        $data['pembelian'], $data['total_pembelian']) = $this->laporan->searchRekapHarian($this->input->post());
        $data['search'] = $this->input->post();
        $this->session->set_userdata(['list_kategori_rekap' => json_encode($data['kategori'])]);
        $this->session->set_userdata(['list_sub_kategori_rekap' => json_encode($data['sub_kategori'])]);
        $this->session->set_userdata(['list_item_rekap' => json_encode($data['item'])]);
        $this->session->set_userdata(['search_params' => json_encode($data['search'])]);
        $this->session->set_userdata(['list_transaksi' => json_encode($data['transaksi'])]);

        $this->load->view('laporan/V_RekapHarianResult', $data);
    }

    public function pilihItemForCetakRekap(){
        $data['kategori'] = json_decode($this->session->userdata('list_kategori_rekap'), true);
        $data['sub_kategori'] = json_decode($this->session->userdata('list_sub_kategori_rekap'), true);
        $data['item'] = json_decode($this->session->userdata('list_item_rekap'), true);
        usort($data['kategori'], function($a, $b) {
            return $a['nama_kategori'] <=> $b['nama_kategori'];
        });
        usort($data['sub_kategori'], function($a, $b) {
            return $a['nama_sub_kategori'] <=> $b['nama_sub_kategori'];
        });
        usort($data['item'], function($a, $b) {
            return $a['nama_item'] <=> $b['nama_item'];
        });
        $this->load->view('laporan/V_PilihItemForCetakRekap', $data);
    }

    public function pilihItemForCetakRekap2(){
        $transaksi = json_decode($this->session->userdata('list_transaksi'), true);
        $data['transaksi'] = null;
        if($transaksi){
            foreach($transaksi as $d){
                if($d['status'] == 2){
                    $data['transaksi'][] = $d;
                }
            }
        }
        usort($data['transaksi'], function($a, $b) {
            return $a['tanggal_transaksi'] <=> $b['tanggal_transaksi'];
        });
        $this->load->view('laporan/V_PilihItemForCetakRekap2', $data);
    }

    public function createDataRekap(){
        $data['search'] = json_decode($this->session->userdata('search_params'), true);
        $data['data_cetak'] = $this->laporan->cetakRekap($this->input->post(), $data['search']);
        $this->session->set_userdata(['data_cetak' => json_encode($data['data_cetak'])]);
    }

    public function createDataRekap2(){
        $data['search'] = json_decode($this->session->userdata('search_params'), true);
        $data['data_cetak'] = $this->laporan->cetakRekap2($this->input->post(), $data['search']);
        $this->session->set_userdata(['data_cetak2' => json_encode($data['data_cetak'])]);
    }

    public function cetakRekap(){
        $data['search'] = json_decode($this->session->userdata('search_params'), true);
        $data['data_cetak'] = json_decode($this->session->userdata('data_cetak'), true);

        $this->load->view('laporan/V_CetakRekapHarian', $data);
    }

    public function cetakRekap2(){
        $data['search'] = json_decode($this->session->userdata('search_params'), true);
        $data['data_cetak'] = json_decode($this->session->userdata('data_cetak2'), true);

        $this->load->view('laporan/V_CetakRekapHarian2', $data);
    }

    public function saveRekapItem(){
        $data_post = $this->input->post();
        $data['search'] = json_decode($this->session->userdata('search_params'), true);
        $list_item = $this->laporan->saveRekapItem($data_post, $data['search']);
        $data['list_item'] = $list_item;
        $this->load->view('laporan/V_RekapItemPrint', $data);
    }
}