<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function myProfilePage(){
		//CREATE OR REPLACE VIEW views_users AS SELECT users.*, faces.face1_value, faces.face2_value FROM `users` LEFT JOIN faces ON users.id = faces.user_id
		$this->data['page_title'] = "My Profile";

		//GET USER INFORMATION
		$user_id = $this->session->userdata("user_id");
		$this->data['user_details'] = $this->global_model->get("users", "*", "id = '$user_id'", "", "single", []);

		//GET USER FACES
		$this->data['user_faces'] = $this->global_model->get("faces", "*", "user_id = '$user_id'", [], "single", []);

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/my-profile', $this->data);
		$this->load->view('layouts/footer');
	}

	public function customerPage(){
		$this->data['page_title'] = "Customer";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/customer', $this->data);
		$this->load->view('layouts/footer');
	}

	public function getUsers(){
		$user_type = $this->input->post("user_type");

		$users = $this->global_model->get("users", "*", "deleted_by = 0 AND FIND_IN_SET(user_type, '$user_type') ", [], "multiple", []);
		foreach ($users as $key => $user) {
			$users[$key]->{"encrypted_id"} = encryptData($user->id);
		}

		$this->data['users'] = $users;

		echo json_encode($this->data);
	}

	public function customerViewPage($hash_id){
		$id = decryptData($hash_id);

		$user_details = $this->global_model->get("users", "*", "id = {$id}", [], "single", []);
		$this->data['user_details'] = $user_details;

		$this->data['page_title'] = "Customer View";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/customer-view', $this->data);
		$this->load->view('layouts/footer');
	}

	public function employeePage(){
		$this->data['page_title'] = "Employee";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/employee', $this->data);
		$this->load->view('layouts/footer');
	}

	public function employeeViewPage($hash_id){
		$id = decryptData($hash_id);

		$user_details = $this->global_model->get("users", "*", "id = {$id}", [], "single", []);
		$this->data['user_details'] = $user_details;

		$this->data['page_title'] = "Employee View";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/employee-view', $this->data);
		$this->load->view('layouts/footer');
	}

	public function employeeAddPage(){
		$this->data['page_title'] = "Employee Add";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/employee-add', $this->data);
		$this->load->view('layouts/footer');
	}

	public function employeeSave(){
		$post = $this->input->post();

		$lastname = $post['lastname'];
		$firstname = $post['firstname'];
		$middlename = $post['middlename'];
		$user_type = isset($post['user_type'])? $post['user_type']: "";
		$email = $post['email'];
		$password = $post['password'];
		$confirm_password = $post['confirm_password'];

		$this->form_validation->set_rules('lastname','lastname','required');
        $this->form_validation->set_rules('firstname','firstname','required');
        $this->form_validation->set_rules('user_type','role','required');
        $this->form_validation->set_rules('email','email','required|is_unique[users.email]|trim|valid_email',array(
            'is_unique'=>"Email already exist.",
            'valid_email'=> "Enter a valid email"
        ));
        $this->form_validation->set_rules('password','password','required|min_length[6]',array(
            'min_length'=> 'Password must be 6 characters long.'
        ));
        $this->form_validation->set_rules('confirm_password','confirm password','required|matches[password]',array(
            'matches'=>"Password does not match.",
        ));

        $is_error = false;
        $error_msg = "";

        if($this->form_validation->run() == FALSE){
            $is_error = true;
            $error_msg = validation_errors();
        }
        else{
        	unset($post['confirm_password']);
        	$post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        	$post['created_date'] = getTimeStamp();
        	$post['created_by'] = $this->session->userdata('user_id');
        	$post['is_active'] = 1;
        	$post['is_verified'] = 1;
        	$post['profile_path'] = "assets/uploads/profile/default-user-icon.jpg";

        	$this->global_model->batch_insert_or_update("users", [$post]);

        	$is_error = false;
        }

        $this->data['is_error'] = $is_error;
        $this->data['error_msg'] = $error_msg;

		echo json_encode($this->data);
	}

	public function changeUserStatus(){
		$status = $this->input->post("status");
		$user_id = $this->input->post("user_id");

		$this->form_validation->set_rules('status','status','required');

		$is_error = false;
        $error_msg = "";

		if($this->form_validation->run() == FALSE){
            $is_error = true;
            $error_msg = validation_errors();
        }
        else{
        	$params = [
    			'is_active'=> $status,
    			'updated_date'=> getTimeStamp(),
    			'updated_by'=> $this->session->userdata('user_id'),
    		];
        	$this->global_model->update("users", "id = '$user_id'", $params);

        	$is_error = false;
        }

        $this->data['is_error'] = $is_error;
        $this->data['error_msg'] = $error_msg;

        echo json_encode($this->data);
	}

}