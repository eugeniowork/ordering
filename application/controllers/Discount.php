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

		$discounts = $this->global_model->get("discounts", "*", "deleted_by = 0", "", "multiple", []);
		foreach ($discounts as $key => $discount) {
			$discounts[$key]->{"value"} = $discount->type == "Amount"? "&#8369;".$discount->value: $discount->value."%";
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

	public function discount_add(){
		$this->data['page_title'] = "Discount Add";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('discount/discount-add');
		$this->load->view('layouts/footer');
	}

	public function discount_edit($hash_id){
		$id = decryptData($hash_id);

        $discount_details = $this->global_model->get("discounts", "*", "id = {$id}", [], "single", []);
        $this->data['discount_details'] = $discount_details;

		$this->data['page_title'] = "Discount Edit";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('discount/discount-edit');
		$this->load->view('layouts/footer');
	}

	public function discount_save(){
		$post = $this->input->post();

		$name = $post['name'];
		$code = $post['code'];
		$value = $post['value'];
		$type = $post['type'];

		$result = [];
		$success = true;
		$msg = "";

		//CHECK IF ACTION IS FOR UPDATE
		$action_type = "add";
		if(isset($post['encrypted_id'])){
			$action_type = "update";
		}

		if($action_type == "update"){
			$id = decryptData($post['encrypted_id']);

			//IF DISCOUNT CODE EXISTS
			$check_code_exists = $this->global_model->get("discounts", "id", "code = '{$code}'", [], "single", []);
			//IF DISCOUNT NAME EXISTS
			$check_name_exists = $this->global_model->get("discounts", "id", "name = '{$name}'", [], "single", []);

			$discount_details = $this->global_model->get("discounts", "*", "id = {$id}", [], "single", []);

			if($check_code_exists && $check_code_exists['id'] != $id){
				$success = false;
            	$msg .= "<p>Discount code already exist.</p>";
			}

			if($check_name_exists && $check_name_exists['id'] != $id){
				$success = false;
            	$msg .= "<p>Discount name already exist.</p>";
			}

			$this->form_validation->set_rules('name','name','required');
			$this->form_validation->set_rules('code','code','required');
		}
		else{
			$this->form_validation->set_rules('name','name','required|is_unique[discounts.name]', array(
				'is_unique'=>"Discount name already exist.",
			));
			$this->form_validation->set_rules('code','code','required|is_unique[discounts.code]', array(
				'is_unique'=>"Discount code already exist.",
			));
		}
		
		$this->form_validation->set_rules('value','value','required');
		$this->form_validation->set_rules('type','type','required');

		if($this->form_validation->run() == FALSE){
            $success = false;
            $msg .= validation_errors();
        }

        if($success){
        	if(!is_numeric($value) && !floor($value)){
        		$success = false;
            	$msg .= "<p>Please enter correct value.</p>";
        	}
        }

        if($success){
        	if(!in_array($type, ['Amount','Percentage'])){
        		$success = false;
        		$msg .= "Invalid type.";
        	}
        }

        if($success){
        	if($action_type == "update"){
	        	$post['updated_date'] = getTimeStamp();
    			$post['updated_by'] = $this->session->userdata('user_id');
    			unset($post['encrypted_id']);
    			$this->global_model->update("discounts", "id = {$id}" ,$post);

    			//CHECK CHANGES
    			$changes = [];
    			$fields = ["name", "code", "type", "value"];
                foreach ($fields as $field) {
                    if($discount_details[$field] != $post[$field]){
                        $current_value = empty($discount_details[$field])? 'no value': $discount_details[$field];
                            $new_value = $post[$field];

                        $changes[] = "<span style='text-decoration:underline;'>".(ucwords($field))."</span>: <strong>(from)</strong> ".$current_value." <strong>(to)</strong> ".$new_value;
                    }
                }

                if($changes){
                    $changes_in_text = "Changes made on the following fields: \r<br>".implode("\r<br>", $changes);

        			//CREATE AUDIT TRAIL
        			$new_details = $this->global_model->get("discounts", "*", "id = {$id}", [], "single", []);
		            $params = [
		                'user_id'=> $this->session->userdata('user_id'),
		                'code'=> 'DISCOUNT',
		                'description'=> "Updated discount <strong>".$discount_details['name']."</strong> <br> {$changes_in_text}",
		                'old_details'=> json_encode($discount_details, JSON_PRETTY_PRINT),
		                'new_details'=> json_encode($new_details, JSON_PRETTY_PRINT),
		                'created_date'=> getTimeStamp()
		            ];
		            $this->global_model->insert("audit_trail", $params);
		        }
    		}
    		else{
	        	$post['created_date'] = getTimeStamp();
    			$post['created_by'] = $this->session->userdata('user_id');
    			$insert_id = $this->global_model->insert("discounts", $post);

    			//CREATE AUDIT TRAIL
	            $new_details = $this->global_model->get("discounts", "*", "id = {$insert_id}", [], "single", []);
	            $params = [
	                'user_id'=> $this->session->userdata('user_id'),
	                'code'=> 'DISCOUNT',
	                'description'=> "Added new discount <strong>".$post['name']."</strong>",
	                'new_details'=> json_encode($new_details, JSON_PRETTY_PRINT),
	                'created_date'=> getTimeStamp()
	            ];
	            $this->global_model->insert("audit_trail", $params);
	        }
        }

        $result = [
	    	"success"=> $success,
	    	"msg"=> $msg
	    ];
        echo json_encode($result);
	}

	public function remove_discount(){
		$discount_id = $this->input->post('discount_id');
		$user_id = $this->session->userdata('user_id');

		$result = [];
		$success = true;
		$msg = "";

		$params = [
			"deleted_by"=> $user_id,
			'deleted_date'=> getTimeStamp()
		];
		$this->global_model->update("discounts", "id = '{$discount_id}'", $params);

		//GET PRODUCT DETAILS
		$discount_details = $this->global_model->get("discounts", "*", "id = {$discount_id}", [], "single", []);

		//CREATE AUDIT TRAIL
        $params = [
            'user_id'=> $this->session->userdata('user_id'),
            'code'=> 'DISCOUNT',
            'description'=> "Removed discount <strong>".$discount_details['name']."</strong>",
            'new_details'=> json_encode($discount_details, JSON_PRETTY_PRINT),
            'created_date'=> getTimeStamp()
        ];
        $this->global_model->insert("audit_trail", $params);

		$result = [
			'success'=> $success,
			'msg'=> $msg
		];
		echo json_encode($result);
	}
}