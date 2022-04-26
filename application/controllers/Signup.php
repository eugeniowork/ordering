<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function index()
	{
		$this->data['page_title'] = "Signup";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('signup/signup');
		$this->load->view('layouts/footer');
	}

	public function signupSave(){
		$lastname = $this->input->post("lastname");
		$firstname = $this->input->post("firstname");
		$middlename = $this->input->post("middlename");
		$phone_number = $this->input->post("phone_number");
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$confirm_password = $this->input->post("confirm_password");
		$with_glasses = $this->input->post("with_glasses");
		$face_value = $this->input->post("face_value");
		$face2_value = $this->input->post("face2_value");

		$this->form_validation->set_rules('lastname','lastname','required',array(
            'required'=> 'Lastname is required'
        ));
        $this->form_validation->set_rules('firstname','firstname','required',array(
            'required'=> 'Firstname is required'
        ));
        $this->form_validation->set_rules('phone_number','phone_number','required',array(
            'required'=> 'Phone number is required'
        ));
        $this->form_validation->set_rules('email','email','required|is_unique[users.email]',array(
            'required'=> 'Email is required',
            'is_unique'=>"Email already exist.",
        ));
        $this->form_validation->set_rules('password','password','required|min_length[6]',array(
            'required'=> 'Password is required',
            'min_length'=> 'Password must be 6 characters long.'
        ));
        $this->form_validation->set_rules('confirm_password','confirm_password','required|matches[password]',array(
            'required'=> 'Confirm password is required',
            'matches'=>"Password does not match.",
        ));
        $this->form_validation->set_rules('face_value[]','face_value','required',array(
            'required'=> 'Face 1 is required.'
        ));

        if($with_glasses == "yes"){
        	$this->form_validation->set_rules('face2_value[]','face2_value','required',array(
	            'required'=> 'Face 2 is required.'
	        ));
        }

        $error_count = 0;
        $error_msg = "";

        if($this->form_validation->run() == FALSE){
            $this->data['status'] = "error";
            $error_count += 1;
            $error_msg .= validation_errors();
        }

        //VALIDATE PHONE NUMBER
        if($phone_number != ""){
            if(strlen($phone_number) != 7 && strlen($phone_number) != 9 && strlen($phone_number) != 11){
                $error_count +=1;
                $error_msg .= '<p>Please provide a valid phone number.</p><br>';
            }
            if (strlen($phone_number) == 11) {
                $regex = '/^[0]{1}[9]{1}[0-9]{9}$/i';

                if (!preg_match($regex, $phone_number)) {
                    $error_count += 1;
                    $error_msg .= '<p>Please provide a valid phone number that starts with 09.</p>';
                }
            }
        }

        if($error_count == 0){
        	$target_dir = 'assets/uploads/faces';
        	//CREATE DIRECTORY IF NOT EXIST
        	if(!is_dir($target_dir))
			{
				mkdir($target_dir,0777,true);
			}

			//INSERT USERS
        	$users_params = [
				"lastname"=> $lastname,
				"firstname"=> $firstname,
				"middlename"=> $middlename,
				"phone_number"=> $phone_number,
				"email"=> $email,
				"password"=> password_hash($password, PASSWORD_DEFAULT),
                "is_verified"=> 0,
                "is_active"=> 0,
				'created_date'=> getTimeStamp()
			];
			$user_id = $this->global_model->insert("users", $users_params);

			$faces_params = [
				'user_id' => $user_id,
				'created_date'=> getTimeStamp()
			];

			//FOR FACE 1
			if($face_value){
				//UPLOAD IMAGE OF FACE 1
	            $face1_new_file_name = uniqid().".png";
	            move_uploaded_file($_FILES['face_image']['tmp_name'], $target_dir."/".$face1_new_file_name);

	            $faces_params['face1_value'] = json_encode($face_value);
	            $faces_params['face1_path'] = $target_dir."/".$face1_new_file_name;
			}

			//FOR FACE 2
            if($face2_value){
            	if($with_glasses == "yes"){
            		//UPLOAD IMAGE OF FACE2
		            $face2_new_file_name = uniqid().".png";
		            move_uploaded_file($_FILES['face2_image']['tmp_name'], $target_dir."/".$face2_new_file_name);

		            $faces_params['face2_value'] = json_encode($face2_value);
	            	$faces_params['face2_path'] = $target_dir."/".$face2_new_file_name;
            	}
            }

            $this->global_model->insert("faces", $faces_params);

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
                Thank you for registering in <strong>".APPNAME."</strong>. To verify your account, please use this OTP:<br>
                <strong>".$code."</strong>
                <br><br>
                This is only valid for 20 minutes. Do not share your OTP to anyone.
            ";

            $mail->send();

            $this->data['encrypted_user_id'] = encryptData($user_id);
			$this->data['is_error'] = false;
        }
        else{
        	$this->data['is_error'] = true;
        	$this->data['error_msg'] = $error_msg;
        }

        
		
		echo json_encode($this->data);
	}
}
