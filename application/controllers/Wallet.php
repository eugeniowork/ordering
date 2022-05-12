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
		$this->load->helper('receipt_helper');
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

	public function walletTransaction(){
		//CREATE OR REPLACE VIEW views_wallet_activity AS SELECT wallet_activity.*, CONCAT(users.firstname," ",users.lastname) as fullname FROM `wallet_activity` LEFT JOIN users ON wallet_activity.user_id = users.id
		session_write_close();
		if($this->session->userdata('user_type') == "user"){
			$user_id = $this->session->userdata("user_id");
			$this->data['transactions'] = $this->global_model->get("views_wallet_activity", "*", "user_id = '$user_id'", ["column" => "created_date", "type" => "DESC"], "multiple", []);
		}
		else{
			$this->data['transactions'] = $this->global_model->get("views_wallet_activity", "*", "", ["column" => "created_date", "type" => "DESC"], "multiple", []);
		}

		session_start();
		echo json_encode($this->data);
	}

	public function getCashInRequest(){
		//CREATE OR REPLACE VIEW views_cash_in_request AS SELECT cash_in_request.*, CONCAT(users.firstname," ",users.lastname) AS fullname, users.email, users.facepay_wallet_balance FROM `cash_in_request` LEFT JOIN users ON cash_in_request.user_id = users.id

		session_write_close();

		$user_id = $this->session->userdata("user_id");
		$status = $this->input->post("status");
		$date_today = getTimeStamp();

		if($this->session->userdata('user_type') == "user"){
			$where = "user_id = '$user_id' AND status = '$status' AND date_expiration > '$date_today' ";
			$results = $this->global_model->get("views_cash_in_request", "*",$where, ["column" => "created_date", "type" => "DESC"], "single", []);
			if($results){
				$results["encrypted_id"] = encryptData($results['id']);
				$results["date_expiration"] = date("M d, Y h:i a", strtotime($results['date_expiration']));
			}
		}
		else{
			$where = "status = '$status' AND date_expiration > '$date_today' ";
			$results = $this->global_model->get("views_cash_in_request", "*",$where, ["column" => "created_date", "type" => "DESC"], "multiple", []);
			foreach ($results as $key => $result) {
				$results[$key]->{"encrypted_id"} = encryptData($result->id);
				$results[$key]->{"created_date"} = date("M d, Y h:i a", strtotime($result->created_date));
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
	        			"content"=> "Customer #customer_name request Cash In amounting <span>&#8369;</span>{$converted_amount} with Reference No <a href='".base_url()."cash-in-view/".encryptData($insert_id)."'>{$reference_no}</a>.",
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

	public function cashInPage(){
		$this->data['page_title'] = "Cash In";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('wallet/cash-in');
		$this->load->view('layouts/footer');
	}

	public function cashInView($hash_id){
		$id = decryptData($hash_id);

		$cash_in = $this->global_model->get("views_cash_in_request", "*","id = {$id} ", ["column" => "created_date", "type" => "DESC"], "single", []);
		$this->data['cash_in'] = $cash_in;

		$user_id = $cash_in['user_id'];
		$user_details = $this->global_model->get("views_users", "*", "id = '$user_id'", [], "single", []);
		$this->data['user_details'] = $user_details;

		$this->data['page_title'] = "Cash In";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('wallet/cash-in-view');
		$this->load->view('layouts/footer');
	}

	public function sendCashInVerificationCode(){
		session_write_close();

		$email = $this->input->post("email");
		$reference_no = $this->input->post("reference_no");

		//UPDATE EXISTING ACTIVE OTP
        $update_data = [
            "is_active"=> 0,
        ];
        $this->global_model->update("otp", "email = '$email' AND is_active = 1 AND module = 'cash_in_verification'", $update_data);

        $code = rand(100000, 999999);
        $otp_params = [
            'email'=> $email,
            'code'=> $code,
            'is_active'=> 1,
            'module'=> 'cash_in_verification',
            //plus 20 mins
            // 20 * 60 = 1200
            'date_expiration'=> date('Y-m-d H:i:s',strtotime(getTimeStamp()) + 1200),
            'created_date'=> getTimeStamp()
        ];
        $this->global_model->insert("otp", $otp_params);

        // Load PHPMailer library
        $this->load->library('PHPmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
        // Add a recipient
        $mail->addAddress($email);
        
        // Email subject
        $mail->Subject = "[".APPNAME."]Cash In Verification";
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = "
            Good day! <br><br>
            To verify your cash in with reference no <strong>{$reference_no}</strong>, please use this OTP:<br>
            <strong>".$code."</strong>
            <br><br>
            This is only valid for 20 minutes.
        ";

        $mail->send();

        session_start();

		echo json_encode($email);
	}

	public function verifyCashInVerificationCode(){
		$code = $this->input->post("code");
		$email = $this->input->post("email");

		$this->form_validation->set_rules('code','code','required|min_length[6]|max_length[6]',array(
            'required'=> 'Please enter a 6 digit verification code.',
            'min_length'=> 'Please enter a 6 digit verification code.',
            'max_length'=> 'Please enter a 6 digit verification code.',
        ));

        if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	//GET USER LATEST OTP
			$db_name = "otp";
	        $select =  "*";
	        $where = "email = '$email' AND is_active = 1 AND module = 'cash_in_verification'";
	        $order = ["column" => "id", "type" => "DESC"];
	        $otp_details = $this->global_model->get($db_name, $select, $where, $order, "single", []);

	        if($otp_details){
	        	if($otp_details['code'] != $code){
	        		$this->data['is_error'] = true;
	        		$this->data['error_msg'] = "Invalid verification code.";
	        	}
	        	else if($otp_details['code'] == $code && strtotime(getTimeStamp()) > strtotime($otp_details['date_expiration']) ){
	        		$this->data['is_error'] = true;
	        		$this->data['error_msg'] = "Verification code expired.";
	        	}
	        	else{
	        		//UPDATE EXISTING ACTIVE OTP
			        $update_data = [
			            "is_active"=> 0,
			        ];
			        $this->global_model->update("otp", "email = '$email' AND is_active = 1", $update_data);

			        //UPDATE OTP TO VERIFIED
			        $update_data = [
			            "is_verified"=> 1,
			        ];
			        $this->global_model->update("otp", "id = ".$otp_details['id'], $update_data);

	        		$this->data['is_error'] = false;
	        	}
	        }
	        else{
	        	$this->data['is_error'] = true;
            	$this->data['error_msg'] = "Invalid verification code.";
	        }
        }

        echo json_encode($this->data);
	}

	public function confirmCashIn(){
		$cash_in_id = $this->input->post("cash_in_id");
		$cash_in_id = decryptData($cash_in_id);
		$cash_amount = $this->input->post("cash_amount");
		$is_authentication_successful = $this->input->post("is_authentication_successful");

		$this->form_validation->set_rules('cash_amount','cash amount','required',array(
            'required'=> 'Please enter cash amount'
        ));

		if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	if($is_authentication_successful == "false"){
				$this->data['error_msg'] = "Cash in failed.";
				$this->data['is_error'] = true;
			}
			else{
				$cash_in_details = $this->global_model->get("views_cash_in_request", "*","id = {$cash_in_id} ",[],"single", []);
				$customer_id = $cash_in_details['user_id'];
				$reference_no = $cash_in_details['reference_no'];

				if($cash_amount =< $cash_in_details['request_amount']){
					$this->data['error_msg'] = "Please enter amount that is equal or greater than <span>&#8369;</span>".number_format($cash_in_details['request_amount']);
					$this->data['is_error'] = true;
				}
				else{
					$user = $this->global_model->get("users", "id, email, facepay_wallet_balance", "id = '$customer_id'", [], "single", []);

					$cash_in_params = [
						'cash_amount'=> $cash_amount,
						'user_in_charge'=> $this->session->userdata('user_id'),
						'status'=> 'DONE',
						'updated_date'=> getTimeStamp(),
						'updated_by'=> $this->session->userdata('user_id'),
					];
					$this->global_model->update("cash_in_request", "id = '$cash_in_id'", $cash_in_params);

					//UPDATE USER FACEPAY WALLET BALANCE
					$new_facepay_wallet_balance = $user['facepay_wallet_balance'] + $cash_in_details['request_amount'];
	        		$user_params = [
	        			"facepay_wallet_balance"=> $new_facepay_wallet_balance
	        		];
	        		$this->global_model->update("users", "id = '$customer_id'", $user_params);

	        		//ADD FACEPAY WALLET ACITIVTY
	        		$wallet_activity_params = [
	        			"user_id"=> $customer_id,
	        			"reference_no"=> $reference_no,
	        			"description"=> "Cash In",
	        			"debit"=> $cash_in_details['request_amount'],
	        			"credit"=> 0,
	        			"balance" => $new_facepay_wallet_balance,
	        			"source_table"=> "cash_in_request",
	        			"source_id"=> $cash_in_id,
	        			"created_date"=> getTimeStamp(),
	        			"created_by"=> $this->session->userdata("user_id")
	        		];
	        		$this->global_model->insert("wallet_activity", $wallet_activity_params);

	        		//NOTIFY USER/CUSTOMER
	        		$content = "Cash In successful with Reference No <strong>{$reference_no}</strong>.";
	        		$notification_params = [
	        			"receiver"=> $customer_id,
	        			"user_id"=> $this->session->userdata('user_id'),
	        			"content"=> $content,
	        			"type"=> "CASH_IN",
	        			"source_table"=> "cash_in_request",
	        			"source_id"=>$cash_in_id,
	        			"read_status"=> 0,
	        			"created_date"=> getTimeStamp(),
	        			"created_by"=> $this->session->userdata('user_id')
	        		];
	        		$this->global_model->insert("notifications", $notification_params);

	        		$pdf_output = generateCashInReceipt($cash_in_id);

	        		// NOTIFY USER THROUGH EMAIL
		            $this->load->library('PHPmailer_lib');
		            $mail = $this->phpmailer_lib->load();
		            $mail->addAddress($user['email']);
		            $mail->Subject = "[".APPNAME."] CASH IN SUCCESSFUL";
		            $mail->isHTML(true);
		            $mail->Body = "
		                Good day! <br><br>
		                $content
		            ";
		            $mail->AddStringAttachment($pdf_output,"Receipt.pdf","base64","application/pdf");
		            $mail->send();

					$this->data['is_error'] = false;
				}
			}

        }
		
		echo json_encode($this->data);
	}

	public function cashInSuccessfulPage($hash_id){
		$id = decryptData($hash_id);

		$cash_in_details = $this->global_model->get("views_cash_in_request", "*","id = {$id} ",[],"single", []);
		$this->data['cash_in_details'] = $cash_in_details;

		if($cash_in_details['status'] != "DONE"){
			redirect("cash-in");
		}

		$this->data['page_title'] = "Cash In Successful";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_icon_only');
		$this->load->view('wallet/cash-in-successful');
		$this->load->view('layouts/footer');
	}

	public function cashInReceiptPdf($hash_id){
		$id = decryptData($hash_id);

		$cash_in_details = $this->global_model->get("views_cash_in_request", "*","id = {$id} ",[],"single", []);
		$this->data['cash_in_details'] = $cash_in_details;

		$user_in_charge_id = $cash_in_details['user_in_charge'];
		$user_in_charge_details = $this->global_model->get("users", "*", "id = '$user_in_charge_id'", [], "single", []);
		$this->data['user_in_charge_details'] = $user_in_charge_details;

		if($cash_in_details['status'] != "DONE"){
			redirect("cash-in");
		}

		$this->data['page_title'] = "Cash In Receipt";

		$this->load->view('wallet/cash-in-receipt-pdf', $this->data);
	}

	public function walletTransactionPage(){
		$this->data['page_title'] = "Wallet Transaction";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('wallet/wallet-transaction');
		$this->load->view('layouts/footer');
	}
}