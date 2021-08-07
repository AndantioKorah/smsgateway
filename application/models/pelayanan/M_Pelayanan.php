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

        public function insertTindakanOld2(){
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
                    'id_m_nm_tindakan' => $id_tindakan,
                    'created_by' => $this->general_library->getId()
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
                    'created_by' => $this->general_library->getId()
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

           
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            $id_tagihan = $this->input->post('id_tagihan');
            $id_tindakan = $this->input->post('tindakan');
        //   dd($id_pendaftaran);
           
            $this->db->trans_begin();

            $this->db->select('*')
                ->from('m_tindakan as a')
                ->where('a.parent_id', $id_tindakan);
            $cekTindakan =  $this->db->get()->result();

            if($cekTindakan) {

                $this->db->select('a.biaya,a.nama_tindakan')
                ->from('m_tindakan as a')
                ->where('a.id', $id_tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();

                $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'nama_tindakan' => $dataTindakan['0']->nama_tindakan,
                    'id_m_nm_tindakan' => $id_tindakan
                );

                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();

                foreach($cekTindakan as $tindakan){
                
                    $data = array(
                        'id_t_pendaftaran' => $id_pendaftaran,
                        'id_m_nm_tindakan' => $tindakan->id,
                        'parent_id_tindakan' => $id_tindakan,
                        'nama_tindakan' => $tindakan->nama_tindakan
                    );
                    $this->db->insert('t_tindakan', $data);
                    $detail_tindakan[] = $tindakan->nama_tindakan;  
                }

                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'detail_tindakan' => json_encode($detail_tindakan),
                    'biaya' => $dataTindakan['0']->biaya,
                    'created_by' => $this->general_library->getId()
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);

            } else {
              
                $this->db->select('a.biaya,a.nama_tindakan')
                ->from('m_tindakan as a')
                ->where('a.id', $id_tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();
                

                 $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $id_tindakan,
                    'nama_tindakan' => $dataTindakan[0]->nama_tindakan
                );
                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();
                $detail_tindakan[] = $dataTindakan[0]->nama_tindakan;  
                
                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'detail_tindakan' => json_encode($detail_tindakan),
                    'biaya' => $dataTindakan['0']->biaya,
                    'created_by' => $this->general_library->getId()
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


        


        public function getTindakanPasienOld($id_pendaftaran)
    {
        // $id_pendaftaran = $this->input->post('id_pendaftaran');
        $this->db->select('a.id, a.id_m_nm_tindakan, b.nama_tindakan, b.biaya, c.nm_jns_tindakan, a.status')
            ->from('t_tindakan as a')
            ->join('m_nm_tindakan as b', 'b.id = a.id_m_nm_tindakan')
            ->join('m_jns_tindakan as c', 'c.id = b.id_m_jns_tindakan')
            ->where('a.id_t_pendaftaran', $id_pendaftaran)
            ->order_by('a.id', 'desc')
            ->where('a.flag_active', '1');
        return $this->db->get()->result_array();
    }

    public function getTindakanPasien($id_pendaftaran)
    {
        // $id_pendaftaran = $this->input->post('id_pendaftaran');
        $this->db->select('a.id, a.id_m_nm_tindakan, b.*')
            ->from('t_tindakan as a')
            ->join('m_tindakan as b', 'b.id = a.id_m_nm_tindakan')
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
         $this->db->select('*')
         ->from('t_tindakan as a')
         ->where('a.id', $id_tindakan)
         ->where('a.flag_active', 1);
          $cekTindakan =  $this->db->get()->result();

        $id = array(7,8); // You can set multiple check conditions here
        if (in_array($cekTindakan[0]->id_m_nm_tindakan, $id)) //Founds a match !
        {
           
            $this->db->select('*')
                ->from('t_tindakan as a')
                ->where('a.parent_id_tindakan', $cekTindakan[0]->id_m_nm_tindakan)
                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                ->where('a.flag_active', 1);
            $getTindakan =  $this->db->get()->result();
            // var_dump($getTindakan);
            // die();
            if($getTindakan){
                foreach($getTindakan as $tindakan){
                    $this->db->where('id', $tindakan->id)
                    ->update('t_tindakan', [
                        'updated_by' => $this->general_library->getId(),
                        'flag_active' => 0
                    ]);
                }
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
            }  
           
        } else {
          
            $this->db->where('id', $id_tindakan)
            ->update('t_tindakan', [
                'updated_by' => $this->general_library->getId(),
                'flag_active' => 0
            ]);
        }
        
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
        $this->db->select('*')
        ->from('t_tagihan as a')
        ->where('a.id_t_pendaftaran', $id_pendaftaran)
        ->where('a.flag_active', '1');
    return $this->db->get()->result();
    }


    public function select2TindakanOld(){
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

    public function select2Tindakan(){
        $params = $this->input->post('search_param'); 
       
        $id = ['1', '2'];

        $this->db->select('a.*,a.id as id_tindakan ')
        ->from('m_tindakan as a')
        ->like('nama_tindakan',$params)
        ->where_in('a.parent_id', $id);
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


    public function getRincianTindakanBu($id_pendaftaran){
        $list_parent_id = null;
        $data = null;
        $detail_tindakan = $this->db->select('a.*, b.nilai_normal, b.satuan, b.id_m_jns_tindakan, b.id as id_m_tindakan, b.parent_id, b.nama_tindakan')
                                ->from('t_tindakan a')
                                ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                ->where('a.flag_active', 1)
                                ->where('b.flag_active', 1)
                                ->order_by('a.id', 'asc')
                                ->get()->result_array();
       
        if($detail_tindakan){
            foreach($detail_tindakan as $dt){
                    $list_parent_id[] = $dt['id_m_jns_tindakan'];  
            }
            $list_parent_id = array_unique($list_parent_id);
        }
        // var_dump($list_jns_tindakan);
        // die();

        if($list_parent_id){
            $jns_tindakan = $this->db->select('a.id,a.nm_jns_tindakan')
                                ->from('m_jns_tindakan as a')
                                ->where_in('a.id', $list_parent_id)
                                // ->where('a.flag_active', 1)
                                ->get()->result_array();
            if($jns_tindakan){
                foreach($jns_tindakan as $j){
                    $data[$j['id']] = $j;
                }
            }
            foreach($detail_tindakan as $dt){
                $data[$dt['id_m_jns_tindakan']]['detail_tindakan'][] = $dt;
            }
        }
        return $data;
    }

    public function getRincianTindakan($id_pendaftaran){
        $data = null;
        $list_parent = null;
        $list_id_top_parent = null;
        $list_top_parent = null;
        $tindakan = $this->db->select('a.*, b.parent_id, b.id_m_jns_tindakan, b.id as id_m_tindakan')
                                    ->from('t_tindakan a')
                                    ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                    ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                    ->where('a.flag_active', 1)
                                    // ->group_by('a.id')
                                    ->get()->result_array();
        if($tindakan){
            $i = 0;
            foreach($tindakan as $t){
                if($t['parent_id_tindakan'] == 0){
                    $list_id_top_parent[] = $t['id_m_jns_tindakan'];
                    $list_parent[] = $t; 
                    array_splice($tindakan, $i, 1);
                    $i -= 1;
                }
                $i++;
            }
            $list_id_top_parent = array_unique($list_id_top_parent);
        }
        $list_top_parent = $this->db->select('*')
                                    ->from('m_jns_tindakan')
                                    ->where_in('id', $list_id_top_parent)
                                    ->get()->result_array();
        if($list_top_parent){
            foreach($list_top_parent as $ltp){
                $data[$ltp['id']] = $ltp;
            }
            foreach($list_parent as $lp){
                $data[$lp['id_m_jns_tindakan']]['tindakan'][$lp['id_m_nm_tindakan']] = $lp;
                $j = 0;
                foreach($tindakan as $t){
                    if($t['parent_id_tindakan'] == $lp['id_m_nm_tindakan']){
                        $data[$lp['id_m_jns_tindakan']]['tindakan'][$lp['id_m_nm_tindakan']]['detail_tindakan'][] = $t;
                        array_splice($tindakan, $j, 1);
                        $j -= 1;
                    }
                    $j++;
                }
            }
        }
        // dd($data);
        // fungsi ini akan berhenti jika $tindakan sudah null; tapi belum ada contoh, jadi belum lanjut
        return $data;
    }

    public function createHasil($id_t_tindakan, $data)
    {
        $this->db->where('id', $id_t_tindakan);
        $result = $this->db->update('t_tindakan', $data);        
    }


       
	}
?>