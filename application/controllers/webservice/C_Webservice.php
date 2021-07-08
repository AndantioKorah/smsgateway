<?php

class C_Webservice extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('webservice/M_Webservice', 'mwebservice');
        $this->load->library('telegramlib');
        $this->load->library('webservicelib');
    }

    public function bot(){
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        
        if (strpos($message, "/start") === 0){
            $this->telegramlib->send_curl_exec('sendMessage', $chatID, 'Welcome to Nikita BOT :)');
        } 
    }

    public function codeValidation(){
        $req_json = json_decode(file_get_contents("php://input"), TRUE);
        $token = $_SERVER['HTTP_X_TOKEN'];
        $rsp = $this->mwebservice->codeValidation($req_json, $token);
        echo json_encode($rsp);
    }
}
