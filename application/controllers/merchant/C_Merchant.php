<?php

class C_Merchant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('merchant/M_Merchant', 'merchant');
        $this->load->library('telegramlib');
        if($this->general_library->getRole() != 'programmer' && $this->general_library->getUserName() != 'prog' && !$this->general_library->isSessionExpired()){
            redirect('logout');
        };
    }

    public function merchant(){
        render('merchant/V_Merchant', null, null, null);
    }

    public function insertMerchant(){
        $insert_data = $this->input->post();
        $this->merchant->insert('m_merchant', $insert_data);
    }

    public function loadMerchant(){
        $data['result'] = $this->general->getAll('m_merchant');
        $this->load->view('merchant/V_ListMerchant', $data);
    }

    public function deleteMerchant($id){
        $this->general->delete('id', $id, 'm_merchant');
    }

    public function generateCode(){
        $data['list_merchant'] = $this->general->getAll('m_merchant');
        $this->load->view('merchant/V_GenerateCode', $data);
    }

    public function createNewCode(){
        $res = $this->merchant->createNewCode($this->input->post());
        echo json_encode($res);
    }

}
