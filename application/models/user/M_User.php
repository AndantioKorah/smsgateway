<?php
	class M_User extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function getAllUsers(){
            return $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama')
                            ->get()->result_array();
        }

        public function createUser($data){
            if($data['password'] != $data['konfirmasi_password']){
                return ['message' => 'Password dan Konfirmasi Password harus sama'];
            }
            if(strlen($data['password']) < 6){
                return ['message' => 'Panjang Password harus lebih dari 6 karakter'];
            }
            $exist = $this->db->select('username')
                                ->from('m_user')
                                ->where('username', $data['username'])
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if($exist){
                return ['message' => 'Username sudah digunakan'];
            }
            unset($data['konfirmasi_password']);
            $role = explode(';', $data['id_m_role']);
            $data['id_m_role'] = $role[0];
            $data['password'] = $this->general_library->encrypt($data['username'], $data['password']);
            $this->db->insert('m_user', $data);
            return ['message' => '0'];
        }

        public function deleteUser($id_m_user){
            $user = $this->db->select('*')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
            if($user['role_name'] != 'programmer'){
                $this->db->where('id', $id_m_user)
                    ->update('m_user', ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
            }
        }

        public function changePassword($data){
            if($data['password_baru'] != $data['konfirmasi_password']){
                return ['message' => 'Password Baru dan Konfirmasi Password Baru tidak sama'];
            }
            $password_lama = $this->general_library->encrypt($this->general_library->getUserName(), $data['password_lama']);
            $user = $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                                ->from('m_user a')
                                ->join('m_role b', 'a.id_m_role = b.id')
                                ->where('a.username', $this->general_library->getUserName())
                                ->where('a.password', $password_lama)
                                ->get()->result_array();
            if(!$user){
                return ['message' => 'Password Lama salah'];                
            } else {
                if(strlen($data['password_baru']) < 6){
                    return ['message' => 'Panjang Password harus lebih dari 6 karakter'];
                }
                $password_baru = $this->general_library->encrypt($this->general_library->getUserName(), $data['password_baru']);
                $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', ['password' => $password_baru]);
                if($this->db->affected_rows() > 0){
                    $this->session->set_userdata(['user_logged_in' => null]);
                    $user[0]['password'] = $password_baru;
                    $this->session->set_userdata([
                        'user_logged_in' => $user,
                        'test' => 'tiokors'
                    ]);
                    $this->general_library->refreshUserLoggedInData();
                    return ['message' => '0'];
                }
            }
            return ['message' => 'Terjadi Kesalahan'];
        }

        public function updateProfile($data){
            $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', $data);

            if($this->db->affected_rows() > 0){
                $this->session->set_userdata(['user_logged_in' => null]);

                $user = $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.id', $this->general_library->getId())
                            ->get()->result_array();

                $this->session->set_userdata([
                    'user_logged_in' => $user,
                    'test' => 'tiokors'
                ]);
                $this->general_library->refreshUserLoggedInData();
                return ['message' => '0'];
            }

            return ['message' => 'Terjadi Kesalahan'];
        }

        public function deleteProfilePict(){
            $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', ['profile_picture' => null]);

            if($this->db->affected_rows() > 0){
                $this->session->set_userdata(['user_logged_in' => null]);

                $user = $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.id', $this->general_library->getId())
                            ->get()->result_array();

                $this->session->set_userdata([
                    'user_logged_in' => $user,
                    'test' => 'tiokors'
                ]);
                $this->general_library->refreshUserLoggedInData();
                return ['message' => '0'];
            }

            return ['message' => 'Terjadi Kesalahan'];
        }

        public function updateProfilePicture($data){
            $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', ['profile_picture' => $data['data']['file_name']]);

            if($this->db->affected_rows() > 0){
                $this->session->set_userdata(['user_logged_in' => null]);
                
                $user = $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.id', $this->general_library->getId())
                            ->get()->result_array();

                $this->session->set_userdata([
                    'user_logged_in' => $user,
                    'test' => 'tiokors'
                ]);
                $this->general_library->refreshUserLoggedInData();
                return ['message' => '0'];
            }

            return ['message' => 'Terjadi Kesalahan'];
        }

        public function updateExpDateApp($data){
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
                    return ['message' => 'Password yang dimasukkan salahsssss'];
                }
                $second_password = $this->general_library->encrypt($data['username'], $data['second_password']);
                if($second_password != SECOND_PASSWORD){
                    return ['message' => 'Password yang dimasukkan salah'];
                }
                $this->db->where('parameter_name', $data['param_name'])
                            ->update('m_parameter', ['parameter_value' => $data['parameter_value_new'].' 23:59:59', 'updated_by' => $this->general_library->getId()]);
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
                    // $this->general_library->refreshParams();
                    return ['message' => 0];
                } else {
                    return ['message' => 'Terjadi Kesalahan'];
                }
            }
            return ['message' => 'Terjadi Kesalahan'];
        }
	}
?>