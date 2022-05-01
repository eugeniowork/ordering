<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function myOrdersPage(){
		$this->data['page_title'] = "My Orders";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/my-orders');
		$this->load->view('layouts/footer');
	}

	public function myOrdersList(){
		session_write_close();

		$user_id = $this->session->userdata('user_id');

		//GET ORDERS
        $orders = $this->global_model->get("order_history", "*", "user_id = '$user_id' AND deleted_by = 0", ["column" => "id", "type" => "DESC"], "multiple", "");

        foreach ($orders as $key => $order) {
        	$order_history_id = $order->id;
        	$db_name = "order_history_products";
	        $select =  "*";
	        $where = "order_history_id = '$order_history_id' AND deleted_by = 0";
	        $products = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

	        $orders[$key]->{"products"} = $products;
	        $orders[$key]->{"created_date"} = date('M d, Y', strtotime($order->created_date));
	        $orders[$key]->{"encrypted_id"} = encryptData($order->id);
        }

        $this->data['orders'] = $orders;

		session_start();
		echo json_encode($this->data);
	}

	public function updateOrderStatus(){
		session_write_close();

		$order_id = $this->input->post("order_id");
		$order_id = decryptData($order_id);
		$reason = $this->input->post("reason");
		$user_id = $this->session->userdata('user_id');

		$this->form_validation->set_rules('reason','reason','required',array(
            'required'=> 'Please enter reason for cancelling order.'
        ));

		if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	$params = [
        		'status_remarks'=> $reason,
        		'status'=> 'CANCELLED',
        		'updated_by'=> $user_id,
        		'updated_date'=> getTimeStamp(),
        	];
        	$this->global_model->update("order_history", "id = '$order_id'", $params);

        	$this->data['is_error'] = false;
        }

		session_start();
		echo json_encode($this->data);
	}
}