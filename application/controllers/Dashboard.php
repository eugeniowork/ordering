<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function logout(){
		if($this->session->userdata('user_id')){
            session_destroy();
            $this->session->unset_userdata('user_id');
        }
        
        redirect('');
	}

	public function dashboardPage(){
		$this->data['page_title'] = "Dashboard";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('dashboard/dashboard', $this->data);
		$this->load->view('layouts/footer');
	}
}
