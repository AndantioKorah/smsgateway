<?php

class C_Telegram extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('telegram/M_Telegram', 'mtelegram');
        $this->load->library('telegramlib');
    }

    public function bot(){
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        
        if (strpos($message, "/start") === 0){
            $this->telegramlib->send_curl_exec('sendMessage', $chatID, 'Welcome to Nikita BOT :)');
        } 
    }
}
