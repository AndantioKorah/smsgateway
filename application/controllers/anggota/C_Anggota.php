<?php

class C_Anggota extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/m_general');
        $this->load->model('anggota/m_anggota');
    }

    public function get()
    {
        $data['bipra'] = $this->m_general->getAll('m_bipra');
        render('anggota/V_DaftarAnggota', 'anggota-baru', $data);
    }

    public function insertAnggota()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat' => $this->input->post('alamat'),
            'nomor_telpon' => $this->input->post('nomor_telepon'),
            'id_m_bipra' => $this->input->post('jenis_anggota'),
            'dokumen_gereja' => $_FILES['dokumen_gereja']['name'],
            'foto_profil' => $_FILES['foto_profil']['name'],
            'dokumen_negara' => $_FILES['dokumen_negara']['name'],
        );
        if($_FILES['dokumen_gereja']['name'] == null || $_FILES['dokumen_gereja']['name'] == ''){
            unset($data['dokumen_gereja']);
        } 
        if ($_FILES['dokumen_negara']['name'] == null || $_FILES['dokumen_negara']['name'] == ''){
            unset($data['dokumen_negara']);
        } 
        if ($_FILES['foto_profil']['name'] == null || $_FILES['foto_profil']['name'] == ''){
            unset($data['foto_profil']);
        }
        $this->general_library->uploadImage($_FILES['foto_profil'], 'foto_anggota');
        $this->general_library->uploadImage($_FILES['dokumen_gereja'], 'dokumen_gereja');
        $this->general_library->uploadImage($_FILES['dokumen_negara'], 'dokumen_negara');
        $this->m_general->insert('m_anggota', $data);
        $data['bipra'] = $this->m_general->getAll('m_bipra');
        render('anggota/V_DaftarAnggota', 'anggota-baru', $data);
    }

    public function getAllAnggota()
    {
        $data['anggota'] = $this->m_anggota->getAll();
        $this->load->view('anggota/V_DataAnggota', $data);
    }

    public function listAnggota()
    {
        render('anggota/V_ListAnggota', 'list-anggota', '');
    }

    public function detailAnggota($id)
    {  
        // $id = decrypt($id);
        $data['anggota'] = $this->m_anggota->get($id);
        $data['bipra'] = $this->m_general->getAll('m_bipra');
        render('anggota/V_DetailAnggota', 'detail-angota', $data);
    }
    
    public function deleteAnggota($id)
    {
        $this->m_general->delete('id', $id, 'm_anggota');
        redirect(base_url('anggota/list'));
    }

    public function editAnggota($id)
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat' => $this->input->post('alamat'),
            'nomor_telpon' => $this->input->post('nomor_telpon'),
            'id_m_bipra' => $this->input->post('id_m_bipra'),
            'dokumen_gereja' => $_FILES['dokumen_gereja']['name'],
            'foto_profil' => $_FILES['foto_profil']['name'],
            'dokumen_negara' => $_FILES['dokumen_negara']['name'],
        );
        if($_FILES['dokumen_gereja']['name'] == null || $_FILES['dokumen_gereja']['name'] == ''){
            unset($data['dokumen_gereja']);
        } 
        if ($_FILES['dokumen_negara']['name'] == null || $_FILES['dokumen_negara']['name'] == ''){
            unset($data['dokumen_negara']);
        } 
        if ($_FILES['foto_profil']['name'] == null || $_FILES['foto_profil']['name'] == ''){
            unset($data['foto_profil']);
        }
        $this->general_library->uploadImage($_FILES['foto_profil'], 'foto_anggota');
        $this->general_library->uploadImage($_FILES['dokumen_gereja'], 'dokumen_gereja');
        $this->general_library->uploadImage($_FILES['dokumen_negara'], 'dokumen_negara');
        $this->m_general->update('id', $id, 'm_anggota', $data);
        redirect(base_url('anggota/list'));
    }

    public function searchByName($nama)
    {
        $data['anggota'] = $this->m_anggota->searchByName($nama);
        $this->load->view('anggota/V_DataAnggota', $data);
    }

}
