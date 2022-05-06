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

	public function getCashInRequest(){
		//CREATE OR REPLACE VIEW views_cash_in_request AS SELECT cash_in_request.*, CONCAT(users.firstname," ",users.lastname) AS fullname, users.email, users.facepay_wallet_balance FROM `cash_in_request` LEFT JOIN users ON cash_in_request.user_id = users.id

		session_write_close();

		$user_id = $this->session->userdata("user_id");
		$status = $this->input->post("status");
		$date_today = getTimeStamp();

		$where = "";

		if($this->session->userdata('user_type') == "user"){
			$where = "user_id = '$user_id' AND status = '$status' AND date_expiration > '$date_today' ";
			$results = $this->global_model->get("views_cash_in_request", "*",$where, ["column" => "created_date", "type" => "DESC"], "single", []);
			if($results){
				$results["encrypted_id"] = encryptData($results['id']);
				$results["date_expiration"] = date("M d, Y h:i a", strtotime($results['date_expiration']));
			}
		}
		else{
			$results = $this->global_model->get("views_cash_in_request", "*",$where, ["column" => "created_date", "type" => "DESC"], "multiple", []);
			foreach ($results as $key => $result) {
				$results[$key]->{"encrypted_id"} = encryptData($result->id);
			}
		}

		$this->data['results'] = $results;

		session_start();
		echo json_encode($this->data);
	}

	public function submitCashIn(){
		session_write_close();

		$user_id = $this->session->userdata("user_id");
		$amount = $this->input->post("amount");
		$date_today = getTimeStamp();

		$this->form_validation->set_rules('amount','amount','required',array(
            'required'=> 'Please enter amount.'
        ));

        if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	if(!is_numeric($amount) && !floor($amount)){
        		$this->data['is_error'] = true;
            	$this->data['error_msg'] = "Please enter correct amount.";
        	}
        	else{
        		$converted_amount = number_format($amount,2);
        		$reference_no = time() . rand(10*45, 100*98);

        		$this->global_model->update("cash_in_request", "user_id = '$user_id' AND status = 'PENDING'", ['status' => 'CANCELED']);
        		$cash_in_params = [
        			'user_id'=> $user_id,
        			'reference_no'=> $reference_no,
        			'request_amount'=> $amount,
        			'date_expiration'=> date('Y-m-d H:i:s',strtotime($date_today.' + 1 days')),
        			'status'=> 'PENDING',
        			'created_date'=> $date_today,
        			'created_by'=> $user_id
        		];
        		$insert_id = $this->global_model->insert("cash_in_request", $cash_in_params);

        		//NOTIFY ADMIN AND STAFF
		        $bulk_insert_params = [];
	        	$users = $this->global_model->get("users", "id", "(user_type = 'admin' OR user_type = 'staff') AND is_active = 1 AND deleted_by = 0", ["column" => "id", "type" => "ASC"], "multiple", []);
	        	foreach ($users as $key => $user) {
	        		$bulk_insert_params[] = [
	        			"receiver"=> $user->id,
	        			"user_id"=> $user_id,
	        			"content"=> "Customer #customer_name request Cash In amounting <span>&#8369;</span>{$converted_amount} with Reference No <a href='".base_url()."cash-in-request/".encryptData($insert_id)."'>{$reference_no}</a>.",
	        			"type"=> "NEW_ORDER",
	        			"source_table"=> "cash_in_request",
	        			"source_id"=>$insert_id,
	        			"read_status"=> 0,
	        			"created_date"=> getTimeStamp(),
	        			"created_by"=> $user_id
	        		];
	        	}

	        	$this->global_model->batch_insert_or_update("notifications", $bulk_insert_params);

        		$this->data['is_error'] = false;
        	}
        	
        }

        $this->data['amount'] = $amount;

		session_start();
		echo json_encode($this->data);
	}

	public function cancelMyCashIn(){
		session_write_close();

		$id = $this->input->post("id");
		$id = decryptData($id);

		$params = [
			"status"=> "CANCELED",
			"updated_date"=> getTimeStamp(),
			"updated_by"=> $this->session->userdata("user_id")
		];
		$this->global_model->update("cash_in_request", "id = '$id'", $params);

		$this->data['is_error'] = false;


		session_start();
		echo json_encode($this->data);
	}
}