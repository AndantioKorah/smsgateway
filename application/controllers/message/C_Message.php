<?php

class C_Message extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->library('Nexmolib', 'nexmolib');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function individuMessage(){
        $data['list_jenis_pesan'] = $this->general->getAllWithOrder('m_jenis_pesan', 'jenis_pesan', 'asc');
        render('message/V_SendIndividuMessage', '', '', $data);
    }

    public function sendIndividuMessage(){
        $data = $this->input->post();
        $sendMessage = $this->nexmolib->sendMessage('POST', $data);
        dd($sendMessage);
    }
}
