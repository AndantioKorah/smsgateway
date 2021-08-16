<?php

class C_Maintenance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('maintenance/M_Maintenance', 'maintenance');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function indexBackupDatabase(){
        // $this->maintenance->backupDatabase();
        render('maintenance/V_BackupDb', null, null, null);
    }

    public function backupDatabase(){
        $this->maintenance->backupDatabase();
    }

    public function loadHistoryBackup(){
        $data['result'] = $this->maintenance->getHistoryBackup();
        $this->load->view('maintenance/V_HistoryBackup', $data);
    }

    public function previewFile($id){
        $data = $this->general->getOne('t_maintenance', 'id', $id, 1);
        $file = fopen(base_url($data['url_file']),"r");
        // Output lines until EOF is reached
        while(!feof($file)) {
            $line = fgets($file);
            echo $line. "<br>";
        }

        fclose($file);
    }
}
