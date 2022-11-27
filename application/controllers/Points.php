<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Points extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function index(){
		$this->data['page_title'] = "Points";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('points/points');
		$this->load->view('layouts/footer');
	}

	public function points_transaction(){
		session_write_close();
		if($this->session->userdata('user_type') == "user"){
			$user_id = $this->session->userdata("user_id");
			$this->data['transactions'] = $this->global_model->get("views_points_activity", "*", "user_id = '$user_id'", ["column" => "created_date", "type" => "DESC"], "multiple", []);
		}
		else{
			$this->data['transactions'] = $this->global_model->get("views_points_activity", "*", "", ["column" => "created_date", "type" => "DESC"], "multiple", []);
		}

		session_start();
		echo json_encode($this->data);
	}
}