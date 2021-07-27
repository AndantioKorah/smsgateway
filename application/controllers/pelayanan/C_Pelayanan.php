<?php

class C_Pelayanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pelayanan/M_Pelayanan', 'pelayanan');
    }

    // public function inputTindakan(){
    //     $this->load->view('pelayanan/V_input_tindakan', null);
    // }

    public function inputTindakan(){
        $data['result'] = 2;
        render('pelayanan/V_input_tindakan', 'pelayanan', 'tindakan', null);
    }

    public function inputTindakanDetail(){
        render('pelayanan/V_input_tindakan_detail', 'pelayanan', 'tindakan', null);
    }



    public function loadDaftarPasien(){
        $data['result'] = 2;
        $this->load->view('pelayanan/V_DaftarPasien', $data);
    }



   
}
