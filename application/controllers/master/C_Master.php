<?php

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('master/M_Master', 'master');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function jenisPemeriksaan(){
        render('master/V_JenisPemeriksaan', 'master', 'jenis_pemeriksaan', null);
    }

    public function tindakan(){
        $data=array('get_category'=> $this->master->get_option()); 
        render('master/V_MasterTindakan', 'master', 'tindakan', $data);
    }

    public function loadJenisPemeriksaan(){
        $data['result'] = $this->general->getAllWithOrder('m_jns_tindakan', 'nm_jns_tindakan', 'asc');
        $this->load->view('master/V_JenisPemeriksaanItem', $data);
    }

    public function loadMasterTindakan(){
        $data['result'] = $this->master->getMasterTindakan();
        $this->load->view('master/V_masterTindakanItem', $data);
    }

    public function createJenisPemeriksaan(){
        echo json_encode($this->master->insertJenisPemeriksaan());
    }

    public function deleteJenisPemeriksaan($id){
        echo json_encode($this->master->deleteJenisPemeriksaan($id));
    }

    public function deleteMasterTindakan($id){
        echo json_encode($this->master->deleteMasterTindakan($id));
    }

    

    public function createMasterTindakan(){
        $this->master->createMasterTindakan();
    }

    public function editMasterTindakan($id_tindakan){
        $data['tindakan'] = $this->master->getMasterTindakanEdit($id_tindakan);
  
        $this->load->view('master/V_EditMasterTindakan', $data);
    }

    public function editMasterTindakanSubmit(){
        echo json_encode($this->master->editMasterTindakanSubmit());
    }

    public function masterDokter(){
        render('master/V_MasterDokter', 'master', 'master_dokter', null);
    }

    public function loadMasterDokter(){
        $data['result'] = $this->general->getAllWithOrder('m_dokter', 'nama_dokter', 'asc');
        $this->load->view('master/V_MasterDokterItem', $data);
    }

    public function createMasterDokter(){
        echo json_encode($this->master->insertMasterDokter());
    }

    public function deleteMasterDokter($id){
        echo json_encode($this->master->deleteMasterDokter($id));
    }


    public function loadEditMasterDokter($id_dokter){
        $data['dokter'] = $this->master->getMasterDokterEdit($id_dokter);
        $this->load->view('master/V_EditMasterDokter', $data);
    }

    public function editMasterDokter(){
        echo json_encode($this->master->editMasterDokter());
    }




}
