<?php
	class M_Parameter extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function updateAppSetting($data){
            $user = $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.username', 'prog')
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
            if($user){
                if($data['username'] != $user['username']){
                    return ['message' => 'Bukan User untuk Programmer'];
                }
                $password = $this->general_library->encrypt($data['username'], $data['password']);
                if($user['password'] != $password){
                    return ['message' => 'Password yang dimasukkan salah'];
                }
                $second_password = $this->general_library->encrypt($data['username'], $data['second_password']);
                if($second_password != SECOND_PASSWORD){
                    return ['message' => 'Password yang dimasukkan salah'];
                }
                if($data['parameter_name'] == 'PARAM_EXP_APP'){
                    $this->db->where('parameter_name', $data['parameter_name'])
                            ->update('m_parameter', ['parameter_value' => $data['parameter_value'].' 23:59:59', 'updated_by' => $this->general_library->getId()]);
                } else if ($data['parameter_name'] == 'PARAM_BIOS_SERIAL_NUMBER'){
                    $this->db->where('parameter_name', $data['parameter_name'])
                            ->update('m_parameter', ['parameter_value' => $data['parameter_value'], 'updated_by' => $this->general_library->getId()]);
                } else if ($data['parameter_name'] == 'PARAM_LAST_LOGIN'){
                    if($data['parameter_value'] < $data['old_parameter_value']){
                        return ['message' => 'Tidak boleh kurang dari Last Login sebelumnya'];
                    }
                    $this->db->where('parameter_name', $data['parameter_name'])
                            ->update('m_parameter', ['parameter_value' => $data['parameter_value'], 'updated_by' => $this->general_library->getId()]);
                } else if($data['parameter_name'] == 'PARAM_MERCHANT_CODE'){
                    $this->db->where('parameter_name', $data['parameter_name'])
                            ->update('m_parameter', ['parameter_value' => $data['parameter_value'], 'updated_by' => $this->general_library->getId()]);
                }
                if($this->db->affected_rows() > 0){
                    $this->session->set_userdata(['params' => null]);
                    
                    $params = $this->db->select('*')
                                ->from('m_parameter')
                                ->where('flag_active', 1)
                                ->get()->result_array();
                    // dd($params);
                    $this->session->set_userdata([
                        'params' => $params
                    ]);
                    // dd($this->session);
                    $this->general_library->refreshParams();
                    return ['message' => 0];
                } else {
                    return ['message' => 'Terjadi Kesalahan'];
                }
            }
            return ['message' => 'Terjadi Kesalahan'];
        }

        public function extendExpireDate($data){
            $code = 0;
            if($data){
                $this->db->where('parameter_name', 'PARAM_EXP_APP')
                        ->update('m_parameter',
                        [
                            'parameter_value' => $data['exp_date'],
                            'updated_by' => $this->general_library->getId()
                        ]);
            } else {
                $code = 1;
            }
            return $code;
        }
	}
?>