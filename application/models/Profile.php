<?php
	class Profile extends CI_Model
	{
		public function getAllProfile() {
			$this->db->select("*");
			$this->db->from("m_profile");
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function getById($id) {
			$this->db->select("*");
			$this->db->from("m_profile");
			$this->db->where("id", $id);
			$query = $this->db->get()->result_array();
			return $query;
		}

		public function insertProfile($data){
			$nama = $data["nama"];
			$alamat = $data["alamat"];
			$no_telp = $data["no_telp"];
			
			$this->db->trans_begin();
	
			$this->db->insert("m_profile", $data);
			
			$this->db->query("INSERT INTO m_profile_backup (nama, alamat, no_telp) VALUES ('$nama','$alamat','$no_telp')");
			
			if($this->db->trans_status() == FALSE){
				$this->db->trans_rollback();
				echo "Failed Input Data;";
			} else {
				$this->db->trans_commit();
				echo "Success Input Data";
			}
		}
		
		public function updateProfile($data, $id){
			$this->db->where("id", $id);
			$this->db->update("m_profile", $data);
		}

		public function deleteProfile($id){
			$this->db->delete("m_profile", $id);
		}
	}
?>