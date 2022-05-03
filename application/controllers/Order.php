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
		$remarks = $this->input->post("remarks");
		$user_id = $this->session->userdata('user_id');
		$status = $this->input->post("status");
		$user_type = $this->input->post("user_type");

		$this->form_validation->set_rules('status','status','required',array(
            'required'=> 'Status is required'
        ));

        if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	$params = [
	    		'status_remarks'=> $remarks,
	    		'status'=> $status,
	    		'updated_by'=> $user_id,
	    		'updated_date'=> getTimeStamp(),
	    	];
	    	$this->global_model->update("order_history", "id = '$order_id'", $params);


	    	if($status == "CANCELED"){
	    		//GET ORDERED PRODUCTS
        		$products_params = [];
		        $ordered_products = $this->global_model->get("order_history_products", "product_id, quantity", "order_history_id = '$order_id'", [], "multiple", []);
		        foreach ($ordered_products as $key => $product) {
		        	$product_id = $product->product_id;
		        	$product_details = $this->global_model->get("products", "stock", "id = '$product_id'", [], "single", []);

		        	$products_params[] = [
	        			"id"=> $product->product_id,
	        			"stock"=> $product_details['stock'] + $product->quantity,
	        		];
		        }
		        //RETURN STOCK
		        $this->global_model->batch_insert_or_update("products", $products_params);
	    	}

	    	//SEND EMAIL NOTIFICATION AND SYSTEM NOTIFICATION
        	if($user_type == "user"){

        	}
        	else{
        		$order_details = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
        		$customer_id = $order_details['user_id'];
        		$order_number = $order_details['order_number'];
        		
	        	$user = $this->global_model->get("users", "id, email", "id = '$customer_id'", [], "single", []);
	        	$content = "";

	        	//NOTIFY CUSTOMER
	        	if($status == "CANCELED"){
	        		$content = "Your order with Order Number <strong>{$order_number}</strong> has been canceled.";
	        	}
	        	else{
	        		$content = "Your order with Order Number <strong>{$order_number}</strong> is now ready to pickup.";
	        	}

	        	$insert_params = [
        			"receiver"=> $customer_id,
        			"user_id"=> $user_id,
        			"content"=> $content,
        			"type"=> "CHANGE_ORDER_STATUS",
        			"source_table"=> "order_history",
        			"source_id"=>$order_details['id'],
        			"read_status"=> 0,
        			"created_date"=> getTimeStamp(),
        			"created_by"=> $user_id
        		];

	        	$this->global_model->insert("notifications", $insert_params);

	        	// Load PHPMailer library
	            $this->load->library('PHPmailer_lib');

	            // PHPMailer object
	            $mail = $this->phpmailer_lib->load();
	            
	            // Add a recipient
	            $mail->addAddress($user['email']);
	            
	            // Email subject
	            $mail->Subject = "[".APPNAME."] ORDER ".$status;
	            
	            // Set email format to HTML
	            $mail->isHTML(true);
	            
	            // Email body content
	            $mail->Body = "
	                Good day! <br><br>
	                $content
	            ";

	            $mail->send();
        	}

	    	$this->data['is_error'] = false;
        }

		

		session_start();
		echo json_encode($this->data);
	}

	public function ongoingOrdersPage(){
		$this->data['page_title'] = "Customer Orders";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/ongoing-orders');
		$this->load->view('layouts/footer');
	}

	public function ongoingOrdersList(){
		//CREATE OR REPLACE VIEW views_order_history AS SELECT order_history.*, CONCAT(users.firstname,' ',users.lastname) AS fullname FROM order_history LEFT JOIN users ON users.id = order_history.user_id
		session_write_close();

        $orders = $this->global_model->get("views_order_history", "*", "deleted_by = 0 AND (status = 'FOR PROCESS' OR status = 'FOR PICKUP') ", ["column" => "created_date", "type" => "ASC"], "multiple", []);
        foreach ($orders as $key => $order) {
        	$orders[$key]->{"encrypted_id"} = encryptData($order->id);
        	$orders[$key]->{"date_pickup"} = date("M d, Y", strtotime($order->date_pickup));
        	$orders[$key]->{"created_date"} = date("M d, Y", strtotime($order->created_date));
        }
        $this->data['orders'] = $orders;

		session_start();
		echo json_encode($this->data);
	}

	public function ongoingOrdersView($hash_id){
		$order_id = decryptData($hash_id);

		$order = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
		$this->data['order'] = $order;

		$order_items = $this->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);
		$this->data['order_items'] = $order_items;

		$this->data['page_title'] = "Customer Order";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/ongoing-orders-view');
		$this->load->view('layouts/footer');
	}

	public function orderPaymentPage($hash_id){
		$order_id = decryptData($hash_id);

		$order = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
		$this->data['order'] = $order;

		$order_items = $this->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);
		$this->data['order_items'] = $order_items;

		$this->data['page_title'] = "Order Payment";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/order-payment');
		$this->load->view('layouts/footer');
	}

	public function saveCashOrderPayment(){
		session_write_close();

		$order_id = $this->input->post("order_id");
		$order_id = decryptData($order_id);
		$cash_amount = $this->input->post("cash_amount");

		$this->form_validation->set_rules('cash_amount','cash amount','required',array(
            'required'=> 'Please enter cash amount'
        ));

        if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	$order_details = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
        	$customer_id = $order_details['user_id'];
        	$order_number = $order_details['order_number'];

        	if($cash_amount < $order_details['total_amount']){
        		$this->data['is_error'] = true;
            	$this->data['error_msg'] = "Please enter amount that is equal or greater than <span>&#8369;</span>".number_format($order_details['total_amount'], 2);
        	}
        	else{
        		//UPDATE ORDER
        		$order_params = [
        			'status'=> 'PICKED UP',
        			'mode_of_payment'=> 'CASH',
        			'actual_date_pickup'=> getTimeStamp(),
        			'cash_payment_amount'=> $cash_amount,
        			'user_in_charge'=> $this->session->userdata('user_id'),
        			'updated_date'=> getTimeStamp(),
        			'updated_by'=> $this->session->userdata('user_id'),
        		];
        		$this->global_model->update("order_history", "id = '$order_id'", $order_params);

        		$user = $this->global_model->get("users", "id, email", "id = '$customer_id'", [], "single", []);

        		//NOTIFY USER/CUSTOMER
        		$content = "Payment successful for Order Number <strong>{$order_number}</strong> using Cash Payment.";
        		$notification_params = [
        			"receiver"=> $customer_id,
        			"user_id"=> $this->session->userdata('user_id'),
        			"content"=> $content,
        			"type"=> "ORDER_PAYMENT",
        			"source_table"=> "order_history",
        			"source_id"=>$order_details['id'],
        			"read_status"=> 0,
        			"created_date"=> getTimeStamp(),
        			"created_by"=> $this->session->userdata('user_id')
        		];
        		$this->global_model->insert("notifications", $notification_params);

        		// Load PHPMailer library
	            $this->load->library('PHPmailer_lib');

	            // PHPMailer object
	            $mail = $this->phpmailer_lib->load();
	            
	            // Add a recipient
	            $mail->addAddress($user['email']);
	            
	            // Email subject
	            $mail->Subject = "[".APPNAME."] ORDER PICKED UP";
	            
	            // Set email format to HTML
	            $mail->isHTML(true);
	            
	            // Email body content
	            $mail->Body = "
	                Good day! <br><br>
	                $content
	            ";

	            $mail->send();

				$this->data['is_error'] = false;
        	}
        }

		session_start();
		echo json_encode($this->data);
	}

	public function saveFacePayOrderPayment(){
		session_write_close();

		$order_id = $this->input->post("order_id");
		$order_id = decryptData($order_id);

		$order = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
		$this->data['order'] = $order;

		session_start();
		echo json_encode($this->data);
	}

	public function orderPaymentSuccessfulPage($hash_id){
		$this->data['page_title'] = "Order Payment Successful";
		$order_id = decryptData($hash_id);

		$order = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
		$this->data['order'] = $order;

		if($order['status'] != "PICKED UP"){
			redirect("ongoing-orders");
		}

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_icon_only');
		$this->load->view('order/order-payment-successful');
		$this->load->view('layouts/footer');
	}
}