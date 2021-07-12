<?php
	class M_Merchant extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            $this->load->library('telegramlib');
            date_default_timezone_set("Asia/Singapore");
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function createNewCode($data){
            $resp['code'] = 0;
            $resp['message'] = 'ok';
            $resp['data'] = null;
            $resp['merchant'] = null;
            if(!$data){
                $resp['code'] = 1;
                $resp['message'] = 'Terjadi Kesalahan';
            }
            if(!isset($data['id_m_merchant'])){
                $resp['code'] = 1;
                $resp['message'] = 'Terjadi Kesalahan';
            } else {
                $insert_data = $data;
                $insert_data['exp_date'] = $insert_data['exp_date'].' 23:59:59';
                $insert_data['generate_code'] = strtoupper(generateRandomNumber(6));

                $resp['merchant'] = $this->db->select('*')
                                            ->from('m_merchant')
                                            ->where('id', $data['id_m_merchant'])
                                            ->where('flag_active', 1)
                                            ->get()->row_array();
                $data_telegram['message'] = '['.$resp['merchant']['nama_merchant'].'] - Generated Code: '.$insert_data['generate_code'].' ('.formatDateOnly($insert_data['exp_date']).')';
                // $data_telegram['message'] = 'Generated Code untuk '.$resp['merchant']['nama_merchant'].' adalah '.$insert_data['generate_code'].
                //                             ' diperpanjang sampai '.formatDateOnly($insert_data['exp_date']);
                $req = $this->telegramlib->send_curl_exec('GET', 'sendMessage', TELEGRAM_ID, $data_telegram);
                
                if(!$req['result']){
                    $resp['code'] = 1;
                    $resp['message'] = $req['message'];
                } else {
                    $this->db->trans_begin();

                    $this->insert('t_generate_code', $insert_data);

                    if($this->db->trans_status() == FALSE){
                        $this->db->trans_rollback();
                        $resp['code'] = 1;
                        $resp['message'] = 'Terjadi Kesalahan';
                    } else {
                        $this->db->trans_commit();
                        $resp['data'] = $insert_data;
                    }
                }
            }
            return $resp;
        }

	}
?>