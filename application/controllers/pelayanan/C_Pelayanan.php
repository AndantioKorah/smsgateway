<?php

class C_Pelayanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pelayanan/M_Pelayanan', 'pelayanan');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
    }


    public function loadViewInputTindakan($id_pendaftaran){
        $data['list_tindakan'] = $this->pelayanan->get_ListTindakan();
        $data['id_pendaftaran'] = $id_pendaftaran;
        $this->load->view('pelayanan/V_InputTindakanPasien', $data);
    }


    public function insertTindakan(){
        echo json_encode($this->pelayanan->insertTindakan());
    }


}
