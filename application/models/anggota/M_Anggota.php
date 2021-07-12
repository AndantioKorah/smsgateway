<?php
	class M_Anggota extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function getAll()
        {
            $this->db->select('a.*, b.nama_bipra, b.keterangan')
            ->from('m_anggota a')
            ->join('m_bipra b', 'a.id_m_bipra = b.id')
            ->order_by('a.nama', 'asc');
            return $this->db->get()->result_array();
        }

        public function get($id)
        {
            $this->db->select('a.*, b.nama_bipra, b.keterangan')
            ->from('m_anggota a')
            ->join('m_bipra b', 'a.id_m_bipra = b.id')
            ->where('a.id', $id);
            return $this->db->get()->result_array();
        }

        public function searchByName($nama)
        {
            $this->db->select('a.*, b.nama_bipra, b.keterangan')
            ->from('m_anggota a')
            ->join('m_bipra b', 'a.id_m_bipra = b.id')
            ->like('a.nama', $nama)
            ->order_by('a.nama', 'asc');
            return $this->db->get()->result_array();
        }
	}
?>