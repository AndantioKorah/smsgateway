<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('profile');
			$this->load->library('form_validation');
			$this->load->helper('string');
			$this->load->database();
			$this->load->helper('url');
		}

	  // public function index(){
		// 	$data['mProfile'] = $this->profile->getAllProfile();
		// 	$this->load->view('welcome_message', $data);
	  // }
	  
	  public function delete(){
		$data = array(
			"id" => $this->uri->segment(3)
		);

		$this->profile->deleteProfile($data);
		redirect(base_url()."welcome/deleted");
		}
		
	  public function deleted(){
		  $this->index();
	  }
	  
	  public function fetch(){
		$data['mProfile'] = $this->profile->getById($this->uri->segment(3));
		$this->load->view('update', $data);
	  }
		
	public function updateData(){
		$id = $this->input->post("id");
		
		$dataArray = array (
			"nama" => $this->input->post("nama"),
			"alamat" => $this->input->post("alamat"),
			"no_telp" => $this->input->post("no_telp")
		);
		
		$this->profile->updateProfile($dataArray, $id);
		redirect(base_url()."welcome/updated");
	}

	public function insertNewData(){
		$dataArray = array (
			"nama" => $this->input->post("nama"),
			"alamat" => $this->input->post("alamat"),
			"no_telp" => $this->input->post("no_telp")
		);
		
		$this->profile->insertProfile($dataArray);
		redirect(base_url()."welcome/inserted");
	}
	
	public function updated(){
		  $this->index();
	  }
	  
	public function inserted(){
		  $this->index();
	  }
}