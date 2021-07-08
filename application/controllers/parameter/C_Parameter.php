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
        $this->load->library('webservicelib');
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
        $data['parameter_merchant_code'] = $this->general_library->getParams('PARAM_MERCHANT_CODE');
        render('V_ExtExpDate', null, null, $data);
    }

    public function validateGeneratedCode(){
        $data = $this->input->post();
        $data['request_time'] = date('Y-m-d H:i:s');
        $data['username'] = $this->general_library->getUserName();
        $req = $this->webservicelib->xrequest('code/validate', 'POST', $data);
        $resp['code'] = 0;
        $resp['message'] = "OK";
        if($req['result']){
            if($req['result']['code'] == 0){
                $extend = $this->parameter->extendExpireDate($req['result']['data']);
                if($extend == 1){
                    $resp['code'] = 1;
                    $resp['message'] = 'Terjadi Kesalahan';    
                }
            } else {
                $resp['code'] = 2;
                $resp['message'] = $req['result']['message'];
            }
        } else {
            $resp['code'] = 3;
            $resp['message'] = $req['message'];
        }
        echo json_encode($resp);
    }

    public function biosSerialNumber(){
        dd(encrypt('nikita', $this->general_library->getBiosSerialNum()));
    }
}
