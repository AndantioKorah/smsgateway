<?php

class C_Parameter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/m_general');
        $this->load->model('parameter/m_parameter', 'parameter');
        // if($this->general_library->getRole() != 'programmer' && $this->general_library->getUserName() != 'prog' && !$this->general_library->isSessionExpired()){
        //     redirect('logout');
        // };
    }

    public function settingApps(){
        $data['parameter_exp'] = $this->general_library->getParams('PARAM_EXP_APP');
        $data['parameter_last_login'] = $this->general_library->getParams('PARAM_LAST_LOGIN');
        render('V_AppsSetting', null, null, $data);
    }

    public function updateExpDateApp(){
        $request = $this->parameter->updateExpDateApp($this->input->post());
        $this->session->set_flashdata('message', $request['message']);
        redirect('apps/setting');
    }

    public function biosSerialNumber(){
        dd($this->general_library->getBiosSerialNum());
    }
}
