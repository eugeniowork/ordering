<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function loginPage(){
		$this->data['page_title'] = "Login";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_icon_only');
		$this->load->view('user/login');
		$this->load->view('layouts/footer');
	}

}