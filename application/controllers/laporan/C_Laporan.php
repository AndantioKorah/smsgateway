<?php

class C_Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('laporan/M_Laporan', 'laporan');
        $this->load->model('general/M_General', 'general');
        $this->load->model('tagihan/M_Tagihan', 'tagihan');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
        $this->load->model('pembayaran/M_Pembayaran', 'pembayaran');
        $this->load->model('pelayanan/M_Pelayanan', 'pelayanan');
        $this->load->model('user/M_User', 'user');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function laporanPendaftaranPerPasien(){
        render('laporan/V_LaporanPendaftaranPerPasien', null, null, null);
    }

    public function searchLaporanPendaftaranPerPasien(){
        $data['parameter'] = $this->input->post();
        $data['result'] = $this->laporan->searchLaporanPendaftaranPerPasien();
        $this->session->set_userdata([
            'result_laporan_pendaftaran_per_pasien' => json_encode($data)
        ]);
        $this->load->view('laporan/V_LaporanPendaftaranPerPasienResult', $data);
    }

    public function saveResultLaporanPendaftaranPerPasien(){
        $params = json_decode($this->session->userdata('result_laporan_pendaftaran_per_pasien'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $this->load->view('laporan/V_LaporanPendaftaranPerPasienExcel', $data);
    }

    public function printResultLaporanPendaftaranPerPasien(){
        $params = json_decode($this->session->userdata('result_laporan_pendaftaran_per_pasien'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $this->load->view('laporan/V_LaporanPendaftaranPerPasienPrint', $data);
    }

}
