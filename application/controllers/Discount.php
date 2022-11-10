<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends CI_Controller {
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
		$this->data['page_title'] = "Discounts";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('discount/discount');
		$this->load->view('layouts/footer');
	}

	public function get_discounts(){

		$discounts = $this->global_model->get("discounts", "*", "", [], "multiple", []);
		foreach ($discounts as $key => $discount) {
			$discounts[$key]->{"percentage"} = $discount->percentage."%";
			$discounts[$key]->{"encrypted_id"} = encryptData($discount->id);
		}
		$this->data['discounts'] = $discounts;

		echo json_encode($this->data);
	}

	public function discount_view($hash_id){
		$id = decryptData($hash_id);

        $discount_details = $this->global_model->get("discounts", "*", "id = {$id}", [], "single", []);
        $this->data['discount_details'] = $discount_details;

		$this->data['page_title'] = "Discount View";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('discount/discount-view');
		$this->load->view('layouts/footer');
	}
}