<?php

class C_Backup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('backup/M_Backup', 'backup');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function backupDatabase(){
        $this->backup->backupDatabase();
    }
}
