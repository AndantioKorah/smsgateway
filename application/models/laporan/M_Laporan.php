<?php
	class M_Laporan extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function searchLaporanPendaftaranPerPasien(){
            $data = $this->input->post();
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);

            return $this->db->select('a.*, b.nama_pasien, c.total_tagihan, c.status_tagihan')
                            ->from('t_pendaftaran a')
                            ->join('m_pasien b', 'a.norm = b.norm')
                            ->join('t_tagihan c', 'a.id = c.id_t_pendaftaran')
                            ->where('a.tanggal_pendaftaran >=', $tanggal_awal.' 00:00:00')
                            ->where('a.tanggal_pendaftaran <=', $tanggal_akhir.' 23:59:59')
                            ->order_by('a.tanggal_pendaftaran', 'desc')
                            ->get()->result_array();
        }
        
	}
?>