<?php

class C_User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('user/M_User', 'user');
        if(!$this->general_library->isLoggedIn(['kasir'])){
            redirect('logout');
        };
    }

    public function roles(){
        render('user/V_Roles', 'user_management', 'roles', null);
    }

    public function createRole(){
        $this->user->insert('m_role', $this->input->post());
    }

    public function loadRoles(){
        $data['result'] = $this->general->getAllWithOrder('m_role', 'nama', 'asc');
        $this->load->view('user/V_RolesItem', $data);
    }

    public function users(){
        // $data['roles'] = $this->general->getAllWithOrder('m_role', 'nama', 'asc');
        render('user/V_Users', 'user_management', 'users', null);
    }

    public function openAddRoleModal($id_m_user){
        $data['user'] = $this->general->getOne('m_user', 'id', $id_m_user, 1);
        $data['roles'] = $this->general->getAllWithOrder('m_role', 'nama', 'asc');
        $this->load->view('user/V_AddRoleModal', $data);
    }

    public function loadRoleForUser($id_m_user){
        $data['list_user_role'] = $this->user->getUserRole($id_m_user);
        $data['id_m_user'] = $id_m_user;
        $this->load->view('user/V_RoleItemModal', $data);
    }

    public function deleteRoleForUser($id_m_user){
        $this->general->delete('id', $id_m_user, 'm_user_role');
    }

    public function addRoleForUser(){
        echo json_encode($this->user->addRoleForUser($this->input->post()));
    }

    public function loadUsers(){
        $data['result'] = $this->user->getAllUsers();
        $this->load->view('user/V_UsersItem', $data);
    }

    public function createUser(){
        $data = $this->input->post();
        echo json_encode($this->user->createUser($data));
    }

    public function deleteUser($id_m_user){
        $this->user->deleteUser($id_m_user);
    }

    public function userSetting(){
        render('user/V_UserSetting', null, null, null);
    }

    public function changePassword(){
        $message = $this->user->changePassword($this->input->post());
        $this->session->set_flashdata('message', $message['message']);
        redirect('user/setting');
    }

    public function updateProfile(){
        $message = $this->user->updateProfile($this->input->post());
        $this->session->set_flashdata('message', $message['message']);
        redirect('user/setting');
    }

    public function updateProfilePict(){
        $photo = $_FILES['profilePict']['name'];
        $upload = $this->general_library->uploadImage('profile_picture','profilePict');
        if($upload['code'] != 0){
            $this->session->set_flashdata('message', $upload['message']);
        } else {
            $message = $this->user->updateProfilePicture($upload);
            $this->session->set_flashdata('message', $message['message']);
        }
        redirect('user/setting');
    }

    public function deleteProfilePict(){
        $message = $this->user->deleteProfilePict();
        $this->session->set_flashdata('message', $message['message']);
        redirect('user/setting');
    }
}
