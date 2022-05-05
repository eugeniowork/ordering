<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function myWalletPage(){
		//GET USER INFORMATION
		$user_id = $this->session->userdata("user_id");
		$this->data['user_details'] = $this->global_model->get("users", "*", "id = '$user_id'", "", "single", []);

		$this->data['page_title'] = "Wallet Balance";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('wallet/my-wallet');
		$this->load->view('layouts/footer');
	}

	public function myWalletTransactions(){
		$user_id = $this->session->userdata("user_id");

		$this->data['transactions'] = $this->global_model->get("wallet_activity", "*", "user_id = '$user_id'", ["column" => "created_date", "type" => "DESC"], "multiple", []);

		echo json_encode($this->data);
	}
}