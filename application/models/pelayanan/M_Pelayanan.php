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
		public function getListTindakan(){
			// return $this->db->get('m_nm_tindakan')->result();
            $this->db->select('a.id as id_tindakan, a.nama_tindakan, a.biaya, b.nm_jns_tindakan,
            CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan ) as nm_tindakan
            ')
            // $this->db->select('*')
            ->from('m_nm_tindakan as a')
            ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
            ->where('a.flag_active', '1');
        return $this->db->get()->result();
		}


        public function insertTindakanOld(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_tindakan = $this->input->post('tindakan');
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            $id_tagihan = $this->input->post('id_tagihan');
            // var_dump($data_tindakan);
            // die();
            $this->db->trans_begin();

            foreach($data_tindakan as $tindakan){

                $this->db->select('a.biaya,a.nama_tindakan')
                ->from('m_nm_tindakan as a')
                ->where('a.id', $tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();
                // var_dump($dataTindakan['0']->biaya);
                // die();

                $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $tindakan
                );
                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();

                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'biaya' => $dataTindakan['0']->biaya,
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);
            }

            // $last_id_pendaftaran = $this->db->insert_id();

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }

        public function insertTindakan(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_tindakan = $this->input->post('tindakan');
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            $id_tagihan = $this->input->post('id_tagihan');
            $id_tindakan = $this->input->post('tindakan');
            // var_dump($id_tindakan);
            // die();
            $this->db->trans_begin();

            $this->db->select('*')
                ->from('t_tindakan as a')
                ->where('a.id_m_nm_tindakan', $id_tindakan)
                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                ->where('a.flag_active', 1);
            $cekTindakan =  $this->db->get()->result();
            // var_dump($cekTindakan);
            // die();

            if($cekTindakan) {
                $res['code'] = 1;
                $res['message'] = 'Tindakan Sudah ada';
               
            } else {
                $this->db->select('a.biaya,a.nama_tindakan')
                ->from('m_nm_tindakan as a')
                ->where('a.id', $id_tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();

                $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $id_tindakan
                );
                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();

                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'biaya' => $dataTindakan['0']->biaya,
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);
            }


                
            

            // $last_id_pendaftaran = $this->db->insert_id();

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }


        public function getTindakanPasien()
    {
        $id_pendaftaran = $this->input->post('id_pendaftaran');
        $this->db->select('a.id, a.id_m_nm_tindakan, b.nama_tindakan, b.biaya, c.nm_jns_tindakan, a.status')
            ->from('t_tindakan as a')
            ->join('m_nm_tindakan as b', 'b.id = a.id_m_nm_tindakan')
            ->join('m_jns_tindakan as c', 'c.id = b.id_m_jns_tindakan')
            ->where('a.id_t_pendaftaran', $id_pendaftaran)
            ->order_by('a.id', 'desc')
            ->where('a.flag_active', '1');
        return $this->db->get()->result_array();
    }

    public function delTindakanPasien(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        
    
        $id_tindakan = $this->input->post('idtindakan');
        $id_pendaftaran = $this->input->post('id_pendaftaran');
 
        $this->db->trans_begin();

        $this->db->where('id', $id_tindakan)
                ->update('t_tindakan', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);

        $this->db->where('id_reference', $id_tindakan)
                 ->where('id_t_pendaftaran', $id_pendaftaran)
                ->update('t_tagihan_detail', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function getTagihan($id_pendaftaran){
        $this->db->select('a.id')
        ->from('t_tagihan as a')
        ->where('a.id_t_pendaftaran', $id_pendaftaran)
        ->where('a.flag_active', '1');
    return $this->db->get()->result();
    }


    public function select2Tindakan(){
        // return $this->db->get('m_nm_tindakan')->result();
        $params = $this->input->post('search_param'); 
        // var_dump($query);
        // die();

        $this->db->select('a.id as id_tindakan, a.nama_tindakan, a.biaya, b.nm_jns_tindakan,
        CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan ) as nm_tindakan
        ')
        ->from('m_nm_tindakan as a')
        ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
        ->like('nama_tindakan',$params)
        ->where('a.flag_active', '1');
    return $this->db->get()->result();
    }


    public function selesaiTindakan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        

        $id_pendaftaran = $this->input->post('id_pendaftaran');
 
        $this->db->trans_begin();

        $this->db->where('id_t_pendaftaran', $id_pendaftaran)
                ->update('t_tindakan', [
                    'updated_by' => $this->general_library->getId(),
                    'status' => 1
                ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

       
	}
?>