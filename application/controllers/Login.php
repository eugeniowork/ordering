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
	        	$this->session->set_userdata('user_id', $user_details['id']);
	        	$this->session->set_userdata('user_firstname', $user_details['firstname']);
	        	$this->session->set_userdata('user_lastname', $user_details['lastname']);
	        	$this->data['is_error'] = false;
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