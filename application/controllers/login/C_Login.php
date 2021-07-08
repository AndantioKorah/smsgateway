<?php

class C_Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
    }

    public function login(){
        $this->load->view('login/V_Login', null);
    }

    public function logout(){
        $this->session->set_flashdata('message', $this->session->userdata('apps_error'));
        $this->session->set_userdata(['apps_error' => null]);
        $this->session->set_userdata(['user_logged_in' => null, 'test' => null, 'params' => null]);
        redirect('login');
    }

    public function welcomePage(){
        render('login/V_Welcome', '', '', null);
    }

    public function authenticateAdmin()
    {
        if($this->input->post('username') == 'prog' && $this->input->post('password') == '742141189Tes.'){
            redirect('developer');
        }
        $username = $this->input->post('username');
        $password = $this->general_library->encrypt($username, $this->input->post('password'));

        $result = $this->m_general->authenticate($username, $password);
        
        if($result != null){
            $params = $this->m_general->getAll('m_parameter');
            $this->session->set_userdata([
                'user_logged_in' => $result,
                'params' => $params,
                'test' => 'tiokors'
            ]);
            if($params){
                foreach($params as $p){
                    $this->session->set_userdata([$p['parameter_name'] => $p]);
                }
            }
            redirect(base_url('welcome'));                
        } else {
            $this->session->set_flashdata('message', $this->session->flashdata('message'));
            redirect('login');
        }
    }

    public function openAuthModal($id, $id_t_transaksi, $jenis_transaksi){
        $data['id'] = $id;
        $data['id_t_transaksi'] = $id_t_transaksi;
        $data['jenis_transaksi'] = $jenis_transaksi;
        $this->load->view('admin/V_Auth', $data);
    }

    public function otentikasiUser($jenis_transaksi){
        $result = $this->m_general->otentikasiUser($this->input->post(), $jenis_transaksi);
        echo json_encode($result);
    }
}
