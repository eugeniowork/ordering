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
		$approval_status = $this->input->post("approval_status");

		$where = "deleted_by = 0 AND FIND_IN_SET(user_type, '$user_type')";
		if($approval_status){
			$where .= "AND FIND_IN_SET(approval_status, '$approval_status')";
		}
		$users = $this->global_model->get("users", "*", $where, [], "multiple", []);
		foreach ($users as $key => $user) {
			$users[$key]->{"encrypted_id"} = encryptData($user->id);
		}

		$this->data['users'] = $users;

		echo json_encode($this->data);
	}

	public function customerApproval(){
		$user_id = $this->input->post("user_id");
		$approval_status = $this->input->post("approval_status");
		$approval_remarks = $this->input->post("approval_remarks");

		$result = [];
		$success = true;
		$msg = "";

		//VALIDATE USER
    	$user_details = $this->global_model->get("users", "*", "id = '{$user_id}'", [], "single", []);
		if(!$user_details){
			$success = false;
			$msg = "User does not exist.";
		}

		//VALIDATE STATUS
		if(!in_array($approval_status, ['APPROVED','DISAPPROVED'])){
			$success = false;
			$msg = "Unable to approve/disapprove customer.";
		}

		if($success){
			$params = [
				'approval_status'=> strtoupper($approval_status),
			];
			$this->global_model->update("users", "id = '{$user_id}'", $params);

			//INSERT TO USER HISTORY
            $this->global_model->insert("users_approval_history", [
                'user_id'=> $user_id,
                'approval_status'=> $approval_status,
                'description'=> $approval_remarks,
                'created_date'=> getTimeStamp(),
                'created_by'=> $this->session->userdata('user_id')
            ]);

            $msg = "Successfully ".strtolower($approval_status)." customer";
            $customer_name = $user_details['firstname']." ".$user_details['lastname'];

            //EMAIL NOTIF
	        $this->load->library('PHPmailer_lib');
	        // PHPMailer object
	        $mail = $this->phpmailer_lib->load();
	        // Add a recipient
	        $mail->addAddress($user_details['email']);
	        // Email subject
	        $mail->Subject = "[".APPNAME."] ACCOUNT ".($approval_status == "DISAPPROVED"? "DISAPPROVAL": "APPROVAL");

	        $link = base_url()."login";
	        // Email body content
	        if($approval_status == "DISAPPROVED"){
	        	$mail->Body = "
		           Dear {$customer_name}, <br><br>
		           Thank you for registering at our website.<br>
		           Unfortunately, we are unable to approve your account.<br>
		        ";
	        }
	        else{
	        	$mail->Body = "
		           Dear {$customer_name}, <br><br>
		           Thank you for registering at our website.<br>
		           We're happy to let you know that your <strong>".APPNAME."</strong> account has been approved.<br>
		           You can now login your account <a href='".$link."'>here</a>
		        ";
	        }
	        
	        // Set email format to HTML
	        $mail->isHTML(true);

	        $mail->send();

	        //CREATE AUDIT TRAIL
	        $params = [
	        	'user_id'=> $this->session->userdata('user_id'),
	        	'code'=> 'ACCOUNT',
	        	'description'=> ucfirst(strtolower($approval_status))." customer <strong>{$customer_name}</strong>",
	        	'created_date'=> getTimeStamp()
	        ];
	        $this->global_model->insert("audit_trail", $params);
		}

		$result = [
	    	"success"=> $success,
	    	"msg"=> $msg
	    ];
        echo json_encode($result);
	}

	public function customerViewPage($hash_id){
		$id = decryptData($hash_id);

		//CREATE OR REPLACE VIEW view_users_approval_history AS SELECT uah.*, users.firstname, users.lastname, users.middlename FROM `users_approval_history` AS uah LEFT JOIN users ON users.id = uah.created_by
		$user_details = $this->global_model->get("users", "*", "id = {$id}", [], "single", []);
		$this->data['user_details'] = $user_details;

		//get approval history
		$approval_history = $this->global_model->get("view_users_approval_history", "*", "user_id = {$id}", ["column" => "created_date", "type" => "DESC"], "multiple", []);
		$this->data['approval_history'] = $approval_history;

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
        //VALIDATE PASSWORD
        if($password != ""){
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            if(!$uppercase || !$lowercase || !$number || !$specialChars || mb_strlen($password) < 6) {
                $is_error = true;
                $error_msg = 'Password should be at least 6 characters in length and must contain at least one upper case letter, one lower case letter, one number, and one special character.';
            }
        }

        if(!$is_error){
        	unset($post['confirm_password']);
        	$post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        	$post['created_date'] = getTimeStamp();
        	$post['created_by'] = $this->session->userdata('user_id');
        	$post['is_active'] = 1;
        	$post['is_verified'] = 1;
        	$post['approval_status'] = 'N/A';
        	$post['profile_path'] = "assets/uploads/profile/default-user-icon.jpg";

        	$this->global_model->batch_insert_or_update("users", [$post]);

        	$is_error = false;

        	//CREATE AUDIT TRAIL
        	$customer_name = $post['firstname']." ".$post['lastname'];
	        $params = [
	        	'user_id'=> $this->session->userdata('user_id'),
	        	'code'=> 'ACCOUNT',
	        	'description'=> "Added employee <strong>{$customer_name}</strong>",
	        	'created_date'=> getTimeStamp()
	        ];
	        $this->global_model->insert("audit_trail", $params);
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
        	//GET USER DETAILS
        	$user_details = $this->global_model->get("users", "*", "id = '{$user_id}'", [], "single", []);

        	$params = [
    			'is_active'=> $status,
    			'updated_date'=> getTimeStamp(),
    			'updated_by'=> $this->session->userdata('user_id'),
    		];
        	$this->global_model->update("users", "id = '$user_id'", $params);

        	$is_error = false;

        	//CHECK FIRST IF THERE'S REALLY A CHANGES
        	if($user_details['is_active'] != $status){
        		//CREATE AUDIT TRAIL
	        	$customer_name = $user_details['firstname']." ".$user_details['lastname'];
		        $params = [
		        	'user_id'=> $this->session->userdata('user_id'),
		        	'code'=> 'ACCOUNT',
		        	'description'=> "Changed status of ".($user_details['user_type'] == 'user'? 'customer': 'employee')." <strong>{$customer_name}</strong> to ".($status? '<strong>active</strong>': '<strong>inactive</strong>'),
		        	'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
        	}
        }

        $this->data['is_error'] = $is_error;
        $this->data['error_msg'] = $error_msg;

        echo json_encode($this->data);
	}

	public function changePasswordPage(){
		$this->data['page_title'] = "Change Password";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		$this->load->view('user/change-password', $this->data);
		$this->load->view('layouts/footer');
	}

	public function checkPassword(){
        $password = $this->input->post('password');

        // Validate password strength
        $upper_case = preg_match('@[A-Z]@', $password);
        $lower_case = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $special_chars = preg_match('@[^\w]@', $password);
        $six_char_long = mb_strlen($password) < 6? false: true;

        $this->data['upper_case'] = $upper_case;
        $this->data['lower_case'] = $lower_case;
        $this->data['number'] = $number;
        $this->data['special_chars'] = $special_chars;
        $this->data['six_char_long'] = $six_char_long;

        echo json_encode($this->data);
    }

    public function changePasswordSave(){
    	$id = $this->session->userdata('user_id');
		$email = $this->input->post("email");
		$old_password = $this->input->post("old_password");
		$new_password = $this->input->post("new_password");
		$confirm_password = $this->input->post("confirm_password");

		$result = [];
		$success = true;
		$msg = "";

        $this->form_validation->set_rules('old_password','old_password','required',array(
            'required'=> 'Old password is required'
        ));

		$this->form_validation->set_rules('new_password','new_password','required|min_length[6]',array(
            'required'=> 'New password is required'
        ));
        $this->form_validation->set_rules('confirm_password','confirm_password','required|matches[new_password]',array(
            'required'=> 'Confirm password is required',
            'matches'=>"Password does not match.",
        ));

        if($this->form_validation->run() == FALSE){
            $this->data['status'] = "error";
            $success = false;
            $msg = validation_errors();
        }

        //VALIDATE PASSWORD
        if($new_password != ""){
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $new_password);
            $lowercase = preg_match('@[a-z]@', $new_password);
            $number    = preg_match('@[0-9]@', $new_password);
            $specialChars = preg_match('@[^\w]@', $new_password);
            if(!$uppercase || !$lowercase || !$number || !$specialChars || mb_strlen($new_password) < 6) {
                $success = false;
                $msg = 'Password should be at least 6 characters in length and must contain at least one upper case letter, one lower case letter, one number, and one special character.';
            }
        }

        if($success){
        	$user_details = $this->global_model->get("users", "*", "id = '{$id}'", [], "single", []);
        	if($user_details && password_verify($old_password, $user_details['password'])){
        		$params = [
					"password"=> password_hash($new_password, PASSWORD_DEFAULT),
					'updated_date'=> getTimeStamp(),
					'updated_by'=> $user_details['id']
				];
				$this->global_model->update("users", "id = '{$id}'", $params);

				//CREATE AUDIT TRAIL
		        $params = [
		            'user_id'=> $user_details['id'],
		            'code'=> 'ACCOUNT',
		            'description'=> 'Changed password',
		            'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
        	}
        	else{
				$success = false;
                $msg = 'Old password does not match.';
        	}
        }

        $result = [
	    	"success"=> $success,
	    	"msg"=> $msg
	    ];
        echo json_encode($result);
	}
}