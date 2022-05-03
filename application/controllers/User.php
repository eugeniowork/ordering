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

}