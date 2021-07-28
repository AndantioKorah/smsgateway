<?php
	class M_Pelayanan extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        	//tampil data
		public function get_ListTindakan(){
			return $this->db->get('m_nm_tindakan')->result();
		}


        public function insertTindakan(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_tindakan = $this->input->post('tindakan');
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            // var_dump($data_tindakan);
            // die();
            $this->db->trans_begin();

            foreach($data_tindakan as $object){
                $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $object
                );
                $this->db->insert('t_tindakan', $data);
            }

            // $last_id_pendaftaran = $this->db->insert_id();

    

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }

   

       
	}
?>