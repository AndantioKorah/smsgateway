<?php
	class M_Webservice extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            date_default_timezone_set("Asia/Singapore");
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }
        
        public function codeValidation($data, $token){
            $response['code'] = 0;
            $response['message'] = null;
            $response['data'] = null;
            if($data && isset($data['generate_code']) && isset($data['kode_merchant']) && isset($data['request_time']) && isset($data['username'])){
                if(isValidTokenHeader($token, $data['kode_merchant'])){
                    $this->db->trans_begin();

                    $merchant = $this->db->select('*')
                                        ->from('m_merchant')
                                        ->where('kode_merchant', $data['kode_merchant'])
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                    if($merchant){
                        $code = $this->db->select('*')
                                        ->from('t_generate_code')
                                        ->where('id_m_merchant', $merchant['id'])
                                        ->where('generate_code', $data['generate_code'])
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                        if($code){
                            if($code['flag_used'] == 0){
                                // if($code['flag_expire'] == 0){
                                    // $hourdiff = round((strtotime($data['request_time']) - strtotime($code['created_date']))/3600, 1);
                                    // if($hourdiff < 2){ //kurang dari 2 jam
                                        $this->db->where('id', $code['id'])
                                                ->update('t_generate_code', 
                                                [
                                                    'flag_used' => 1,
                                                    'use_date' => date('Y-m-d H:i:s'),
                                                    'username' => $data['username']
                                                ]);
                                        $response['data'] = $code;
                                    // } else {
                                    //     $this->db->where('id', $code['id'])
                                    //             ->update('t_generate_code', 
                                    //             [
                                    //                 'flag_expire' => 1, 
                                    //                 'use_date' => date('Y-m-d H:i:s')
                                    //             ]);
                                    //     $response['code'] = 1;
                                    //     $response['message'] = 'Generated Code sudah melewati batas waktu dan tidak bisa dipakai';    
                                    // }
                                // } else {
                                //     $response['code'] = 1;
                                //     $response['message'] = 'Generated Code sudah expire';
                                // }
                            } else {
                                $response['code'] = 1;
                                $response['message'] = 'Generated Code sudah digunakan';    
                            }
                        } else {
                            $response['code'] = 1;
                            $response['message'] = 'Generated Code tidak ditemukan';    
                        }
                    } else {
                        $response['code'] = 1;
                        $response['message'] = 'Kode Merchant tidak ditemukan';
                    }
                    if($this->db->trans_status() == FALSE){
                        $this->db->trans_rollback();
                        $result['code'] = 2;
                        $result['message'] = 'Terjadi Kesalahan';
                    } else {
                        $this->db->trans_commit();
                    }
                } else {
                    $response['code'] = 1;
                    $response['message'] = 'Invalid Token';
                }
            } else {
                $response['code'] = 1;
                $response['message'] = 'Parameter tidak lengkap.';
                if(!isset($data['generate_code'])){
                    $response['message'] .= ' Parameter Generate Code tidak ada.';
                }
                if(!isset($data['kode_merchant'])){
                    $response['message'] .= ' Parameter Kode Merchant tidak ada.';
                }
                if(!isset($data['request_time'])){
                    $response['message'] .= ' Parameter Request Time tidak ada.';
                }
            }
            $log['url'] = base_url('code/validate');
            $log['request'] = json_encode($data);
            $log['response'] = json_encode($response);
            $log['username'] = $data['username'];
            $log['ip_address'] = get_client_ip();
            
            $this->db->insert('t_ws_log', $log);
            return $response;
        }

	}
?>