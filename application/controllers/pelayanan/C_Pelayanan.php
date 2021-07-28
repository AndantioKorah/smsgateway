<?php

class C_Pelayanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pelayanan/M_Pelayanan', 'pelayanan');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
    }

    // public function inputTindakan(){
    //     $this->load->view('pelayanan/V_input_tindakan', null);
    // }

    // public function inputTindakan(){
    //     $data['result'] = 2;
    //     render('pelayanan/V_input_tindakan', 'pelayanan', 'tindakan', null);
    // }

    // public function inputTindakanDetail(){
    //     render('pelayanan/V_input_tindakan_detail', 'pelayanan', 'tindakan', null);
    // }



    public function loadDaftarPasien(){
        $data['result'] = 2;
        $this->load->view('pelayanan/V_DaftarPasien', $data);
    }

    public function loadViewInputTindakan($id_pendaftaran){
        $data['list_tindakan'] = $this->pelayanan->get_ListTindakan();
        $data['id_pendaftaran'] = $id_pendaftaran;
        $this->load->view('pelayanan/V_InputTindakanPasien', $data);
    }


    public function insertTindakan(){
        echo json_encode($this->pelayanan->insertTindakan());
    }


    // public function insertTindakan(){

    //     $check = $this->input->post('check_list');
    //       foreach($check as $object){
    //           $this->pelayanan->insertTindakan(array(
    //             'option' 		=> $object
    //         ));
    //       }
    //           redirect('warna');
    // }



   
}
