<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function myProfilePage(){
		//CREATE OR REPLACE VIEW views_users AS SELECT users.*, faces.face1_value, faces.face2_value FROM `users` LEFT JOIN faces ON users.id = faces.user_id
		$this->data['page_title'] = "My Profile";

		//GET USER INFORMATION
		$user_id = $this->session->userdata("user_id");
		$this->data['user_details'] = $this->global_model->get("users", "*", "id = '$user_id'", "", "single", []);

		//GET USER FACES
		$this->data['user_faces'] = $this->global_model->get("faces", "*", "user_id = '$user_id'", [], "single", []);

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/my-profile', $this->data);
		$this->load->view('layouts/footer');
	}

	public function customerPage(){
		$this->data['page_title'] = "Customer";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/customer', $this->data);
		$this->load->view('layouts/footer');
	}

	public function getUsers(){
		$user_type = $this->input->post("user_type");

		$users = $this->global_model->get("users", "*", "deleted_by = 0 AND FIND_IN_SET(user_type, '$user_type') ", [], "multiple", []);
		foreach ($users as $key => $user) {
			$users[$key]->{"encrypted_id"} = encryptData($user->id);
		}

		$this->data['users'] = $users;

		echo json_encode($this->data);
	}

	public function customerViewPage($hash_id){
		$id = decryptData($hash_id);

		$user_details = $this->global_model->get("users", "*", "id = {$id}", [], "single", []);
		$this->data['user_details'] = $user_details;

		$this->data['page_title'] = "Customer View";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/customer-view', $this->data);
		$this->load->view('layouts/footer');
	}

}