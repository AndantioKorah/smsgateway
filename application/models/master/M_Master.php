<?php
	class M_Master extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function insertJenisPemeriksaan(){
            $data = array(
                'nm_jns_tindakan' => $this->input->post('nm_jns_tindakan'),
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_jns_tindakan', $data);

            $dataMtindakan = array(
                'nama_tindaakn' => $this->input->post('nm_jns_tindakan'),
                'id_m_jns_tindakan' => 0,
                'created_by' => $this->general_library->getId()
            );


        }

        public function deleteJenisPemeriksaan($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_jns_tindakan',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getMasterTindakan()
        {
            $this->db->select('b.nm_jns_tindakan, a.nama_tindakan, a.biaya, a.nilai_normal, a.satuan,
            a.id as id_tindakan,
            (SELECT (nama_tindakan) FROM m_tindakan where id = a.parent_id and parent_id != 0 limit 1)  as nama_tindakan_parent')
            ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
           
            ->where('a.flag_active', 1)
            ->order_by('a.id_m_jns_tindakan', 'asc')
        
            ->from('m_tindakan as a');
            return $this->db->get()->result_array(); 
        }


        public function createMasterTindakan(){


            $this->db->select('a.nm_jns_tindakan')
            ->from('m_jns_tindakan as a')
            ->where('a.id', $this->input->post('id_m_jns_tindakan'));
             $jnsPemeriksaan =  $this->db->get()->result();
            
              $nama_jns_tindakan = $jnsPemeriksaan[0]->nm_jns_tindakan;
            
             $this->db->select('a.id')
             ->from('m_tindakan as a')
             ->like('a.nama_tindakan', $jnsPemeriksaan[0]->nm_jns_tindakan)
             ->limit(1);
              $parent =  $this->db->get()->result();
             
              if($this->input->post('parent') == 0 || $this->input->post('parent') == ""){
              $parent_id = $parent[0]->id;
              } else {
              $parent_id = $this->input->post('parent');
              }
             
              if($this->input->post('biaya') == 0 || $this->input->post('biaya') == ""){
                $biaya = null;
                } else {
                $biaya = $this->input->post('parent');
                }
               

            $data = array(
                'id_m_jns_tindakan' => $this->input->post('id_m_jns_tindakan'),
                'nama_tindakan' => $this->input->post('nama_tindakan'),
                'biaya' => $biaya,
                'nilai_normal' => $this->input->post('nilai_normal'),
                'satuan' => $this->input->post('satuan'),
                'parent_id' => $parent_id,
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_tindakan', $data);
        }

        
        public function deleteMasterTindakan($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_tindakan',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        function get_option() {
            $this->db->select('*');
            $this->db->from('m_jns_tindakan');
            $this->db->where('flag_active',1);
            $query = $this->db->get();
            return $query->result();
        }

        function get_option_parent() {
            $this->db->select('*');
            $this->db->from('m_tindakan');
            $this->db->where('flag_active',1);
            $this->db->where('nilai_normal',null);
            $query = $this->db->get();
            return $query->result();
        }

        public function getMasterTindakanEdit($id){
            return $this->db->select('a.*, b.id as id_jns_tindakan, a.id as id_tindakan, b.nm_jns_tindakan')
                            ->from('m_tindakan a')
                            ->join('m_jns_tindakan b', 'a.id_m_jns_tindakan = b.id')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function editMasterTindakanSubmit(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $id_tindakan = $datapost['id_tindakan'];

            $data["nama_tindakan"] = $datapost["nama_tindakan"]; 
            if($datapost["biaya"] == ""){
                $data["biaya"] = null;
            } else {
                $data["biaya"] = $datapost["biaya"];
            }
           
            $data["nilai_normal"] = $datapost["nilai_normal"];
            $data["satuan"] = $datapost["satuan"]; 

            $this->db->where('id', $id_tindakan)
                    ->update('m_tindakan', $data);

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

        public function insertMasterDokter(){
            $data = array(
                'nama_dokter' => $this->input->post('nama_dokter'),
                'nomor_telepon' => $this->input->post('nomor_telepon'),
                'alamat' => $this->input->post('alamat'),
                'fee' => $this->input->post('fee'),
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_dokter', $data);
        }

        public function deleteMasterDokter($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_dokter',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getMasterDokterEdit($id){
            return $this->db->select('a.*, a.id as id_dokter')
                            ->from('m_dokter a')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function editMasterDokter(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $id_dokter = $datapost['id_dokter'];

            $data["nama_dokter"] = $datapost["nama_dokter"]; 
            $data["nomor_telepon"] = $datapost["nomor_telepon"];
            $data["alamat"] = $datapost["alamat"];


            $this->db->where('id', $id_dokter)
                    ->update('m_dokter', $data);

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