<?php

class C_Parameter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General');
        $this->load->model('parameter/M_Parameter', 'parameter');
        // if($this->general_library->getRole() != 'programmer' && $this->general_library->getUserName() != 'prog' && !$this->general_library->isSessionExpired()){
        //     redirect('logout');
        // };
        $this->general_library->refreshParams();
    }

    public function settingApps(){
        $data['parameter_exp'] = $this->general_library->getParams('PARAM_EXP_APP');
        $data['parameter_last_login'] = $this->general_library->getParams('PARAM_LAST_LOGIN');
        $data['parameter_merchant_code'] = $this->general_library->getParams('PARAM_MERCHANT_CODE');
        render('V_AppsSetting', null, null, $data);
    }

    public function updateAppSetting(){
        $request = $this->parameter->updateAppSetting($this->input->post());
        $this->session->set_flashdata('message', $request['message']);
        redirect('apps/setting');
    }

    public function extendExpireDate(){
        $data['parameter_exp'] = $this->general_library->getParams('PARAM_EXP_APP');
        render('V_ExtExpDate', null, null, $data);
    }

    public function validateGeneratedCode(){
        
    }

    public function biosSerialNumber(){
        dd(encrypt('nikita', $this->general_library->getBiosSerialNum()));
    }
}
