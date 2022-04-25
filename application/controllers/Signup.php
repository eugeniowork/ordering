<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('global_model');

		$this->load->helper('date_helper');
	}

	public function index()
	{
		$this->data['page_title'] = "Signup";

		$this->load->view('layouts/header', $this->data);
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

        	if(!is_dir($target_dir))
			{
				mkdir($target_dir,0777,true);
			}

        	$params = [
				"lastname"=> $lastname,
				"firstname"=> $firstname,
				"middlename"=> $middlename,
				"phone_number"=> $phone_number,
				"email"=> $email,
				"password"=> password_hash($password, PASSWORD_DEFAULT),
				'created_date'=> getTimeStamp()
				// 'face_value' => $face_value? json_encode($face_value): "",
				// "face_value2"=> $face2_value? json_encode($face2_value): ""
			];

			$insert_id = $this->global_model->insert("users", $params);

			if($face_value){
				//FOR FACE 1
	            $face1_new_file_name = uniqid().".png";
	            move_uploaded_file($_FILES['face_image']['tmp_name'], $target_dir."/".$face1_new_file_name);
			}

            if($face2_value){
            	//FOR FACE 2
	            $face2_new_file_name = uniqid().".png";
	            move_uploaded_file($_FILES['face2_image']['tmp_name'], $target_dir."/".$face2_new_file_name);
            }
            
            $params = [
            	'user_id' => $insert_id,
				'face1_value' => $face_value? json_encode($face_value): "",
				'face1_path' => $face_value? $target_dir."/".$face1_new_file_name: "",
				"face2_value"=> $face2_value? json_encode($face2_value): "",
				'face2_path' => $face2_value? $target_dir."/".$face2_new_file_name: "",
				'created_date'=> getTimeStamp()
			];

            $insert_id = $this->global_model->insert("faces", $params);

			$this->data['params'] = $params;
			$this->data['is_error'] = false;
        }
        else{
        	$this->data['is_error'] = true;
        	$this->data['error_msg'] = $error_msg;
        }
		
		echo json_encode($this->data);
	}
}
