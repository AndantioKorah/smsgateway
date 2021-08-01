<?php

class C_Tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('tagihan/M_Tagihan', 'tagihan');
        $this->load->model('general/M_General', 'general');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function loadTagihan($id_pendaftaran){
        $data['id_pendaftaran'] = $id_pendaftaran;
        $this->load->view('tagihan/V_Tagihan', $data);
    }

    public function loadTagihanHeader($id_pendaftaran){
        $data['sisa_harus_bayar'] = $this->tagihan->countTagihan($id_pendaftaran);
        $data['tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['uang_muka'] = $this->general->getOne('t_uang_muka', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $this->load->view('tagihan/V_TagihanHeader', $data);
    }

    public function loadRincianTagihan($id_pendaftaran){
        $data['rincian_tagihan'] = $this->tagihan->getRincianTagihan($id_pendaftaran);
        $this->load->view('tagihan/V_RincianTagihan', $data);
    }

}
