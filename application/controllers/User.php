<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function verifyAccountPage($hash_id){
		$this->data['page_title'] = "Verify Account";

		$id = decryptData($hash_id);

		//GET USER INFORMATION
		$db_name = "users";
        $select =  "*";
        $where = "id = {$id}";
        $order = ["column" => "id", "type" => "ASC"];
        $user_details = $this->global_model->get($db_name, $select, $where, $order, "single");
        $email = $user_details['email'];
		$this->data['email'] = $email;

		if($user_details['is_verified']){
            redirect('login');
        }

		$this->load->view('layouts/header', $this->data);
		$this->load->view('user/verify-account', $this->data);
		$this->load->view('layouts/footer');
	}

	public function verifyAccount(){
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
	        $where = "email = '$email' AND is_active = 1";
	        $order = ["column" => "id", "type" => "DESC"];
	        $otp_details = $this->global_model->get($db_name, $select, $where, $order, "single");

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

			        //UPDATE USER AS ACCOUNT VERIFIED
			        $update_data = [
			            "is_verified"=> 1,
			            "is_active"=> 1
			        ];
			        $this->global_model->update("users", "email = '$email'", $update_data);

	        		$this->data['is_error'] = false;
	        	}
	        	
	        	$this->data['otp_details'] = $otp_details;
	        }
	        else{
	        	$this->data['is_error'] = true;
            	$this->data['error_msg'] = "Invalid verification code.";
	        }
	        
        }

        echo json_encode($this->data);
	}

	public function resendVerification(){
		$email = $this->input->post("email");

		//UPDATE EXISTING ACTIVE OTP
        $update_data = [
            "is_active"=> 0,
        ];
        $this->global_model->update("otp", "email = '$email' AND is_active = 1", $update_data);

        $code = rand(100000, 999999);
        $otp_params = [
            'email'=> $email,
            'code'=> $code,
            'is_active'=> 1,
            //plus 20 mins
            // 20 * 60 = 1200
            'date_expiration'=> date('Y-m-d H:i:s',strtotime(getTimeStamp()) + 1200),
            'date_created'=> getTimeStamp()
        ];
        $this->global_model->insert("otp", $otp_params);

        // Load PHPMailer library
        $this->load->library('PHPmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
        // Add a recipient
        $mail->addAddress($email);
        
        // Email subject
        $mail->Subject = "Account Verification";
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = "
            Good day! <br><br>
            Thank you for registering in <strong>AdU FacePay</strong>. To verify your account, please use this OTP:<br>
            <strong>".$code."</strong>
            <br><br>
            This is only valid for 20 minutes. Do not share your OTP to anyone.
        ";

        $mail->send();

		echo json_encode($email);
	}

}