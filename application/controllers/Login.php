<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('user_id')){
            redirect('dashboard');
        }

        // session_destroy();
        // $this->session->unset_userdata('user_id');

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function loginPage(){
		$this->data['page_title'] = "Login";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_icon_only');
		$this->load->view('login/login');
		$this->load->view('layouts/footer');
	}

	public function validateLogin(){
		$email = $this->input->post("email");
		$password = $this->input->post("password");

		$this->form_validation->set_rules('email','email','required');
        $this->form_validation->set_rules('password','password','required');

        if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	//GET USER INFORMATION
			$db_name = "users";
	        $select =  "*";
	        $where = "email = '$email'";
	        $order = ["column" => "id", "type" => "ASC"];
	        $user_details = $this->global_model->get($db_name, $select, $where, $order, "single", []);

	        if($user_details && password_verify($password, $user_details['password'])){
	        	$user_id = $user_details['id'];
	        	$user_email = $user_details['email'];
	        	if($user_details['is_verified']){
	        		$this->session->set_userdata('user_id', $user_id);
		        	$this->session->set_userdata('user_firstname', $user_details['firstname']);
		        	$this->session->set_userdata('user_lastname', $user_details['lastname']);
		        	$this->session->set_userdata('user_type', $user_details['user_type']);
		        	$this->data['is_error'] = false;
	        	}
	        	else{
	        		$this->data['encrypted_user_id'] = encryptData($user_id);
	        		$this->data['is_redirect_to_verification'] = true;
	        		$this->data['is_error'] = true;
	        		$this->data['error_msg'] = "Your account is not yet verified, you'll be redirected to verification page.";

	        		//UPDATE EXISTING ACTIVE OTP
			        $this->global_model->update("otp", "email = '$user_email' AND is_active = 1 AND module = 'email_verification'", ["is_active" => 0]);

			        $code = rand(100000, 999999);
			        $otp_params = [
			            'email'=> $user_email,
			            'code'=> $code,
			            'is_active'=> 1,
			            'module'=> 'email_verification',
			            //plus 20 mins
			            // 20 * 60 = 1200
			            'date_expiration'=> date('Y-m-d H:i:s',strtotime(getTimeStamp()) + 1200),
			            'created_date'=> getTimeStamp()
			        ];
			        $this->global_model->insert("otp", $otp_params);

			        // Load PHPMailer library
			        $this->load->library('PHPmailer_lib');
			        $mail = $this->phpmailer_lib->load();
			        $mail->addAddress($user_email);
			        $mail->Subject = "[".APPNAME."]For Email Verification";
			        $mail->isHTML(true);
			        $mail->Body = "
			            Good day! <br><br>
			            To verify your <strong>".APPNAME."</strong> account, please use this OTP:<br>
			            <strong>".$code."</strong>
			            <br><br>
			            This is only valid for 20 minutes. Do not share your OTP to anyone.
			        ";

			        $mail->send();
	        	}
	        }
	        else{
	        	$this->data['is_error'] = true;
	        	$this->data['error_msg'] = "Invalid email or password.";
	        }

	        $this->data['user_details'] = $user_details;
        	
        }

		echo json_encode($this->data);
	}

}