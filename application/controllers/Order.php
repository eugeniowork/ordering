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
		$this->load->helper('receipt_helper');
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

	    	$order_details = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
    		$customer_id = $order_details['user_id'];
    		$order_number = $order_details['order_number'];

	    	if($status == "CANCELED"){
	    		//GET ORDERED PRODUCTS
        		$products_params = [];
        		$products_history_params = [];
		        $ordered_products = $this->global_model->get("order_history_products", "product_id, quantity", "order_history_id = '$order_id'", [], "multiple", []);
		        foreach ($ordered_products as $key => $product) {
		        	$product_id = $product->product_id;
		        	$product_details = $this->global_model->get("products", "stock", "id = '$product_id'", [], "single", []);

		        	$products_params[] = [
	        			"id"=> $product->product_id,
	        			"stock"=> $product_details['stock'] + $product->quantity,
	        		];

	        		//ADD TO HISTORY/LOGS OF PRODUCT
	        		$products_history_params[] = [
	        			"product_id"=> $product->product_id,
	        			"stock"=> $product->quantity,
	        			"new_stock"=> $product_details['stock'] + $product->quantity,
	        			"action_type"=> "add",
	        			"description"=> "Stock(s) returned.<br> Order Number <strong>{$order_number}</strong>",
	        			"created_date"=> getTimeStamp(),
	        			"created_by"=> $this->session->userdata("user_id")
	        		];
		        }
		        //RETURN STOCK
		        $this->global_model->batch_insert_or_update("products", $products_params);
		        $this->global_model->batch_insert_or_update("products_history", $products_history_params);
	    	}

	    	//SEND EMAIL NOTIFICATION AND SYSTEM NOTIFICATION
        	if($user_type == "user"){

        	}
        	else{
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

	    	//CREATE AUDIT TRAIL
	    	$order_history_products = $this->global_model->get("order_history_products", "*", "order_history_id = {$order_id}", "", "multiple", "");
			$audit_details = [
				'details'=> $order_details,
				'items'=> $order_history_products
			];
	        $params = [
	            'user_id'=> $user_id,
	            'code'=> 'ORDER',
	            'description'=> "Changed status of Order Number <strong>{$order_number}</strong> to <strong>{$status}</strong>",
	            'new_details'=> json_encode($audit_details, JSON_PRETTY_PRINT),
	            'created_date'=> getTimeStamp()
	        ];
	        $this->global_model->insert("audit_trail", $params);
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
		//CREATE OR REPLACE VIEW views_order_history AS SELECT order_history.*, DATE_FORMAT(order_history.created_date, "%Y") as year, DATE_FORMAT(order_history.created_date, "%m") as month, DATE_FORMAT(order_history.created_date, "%d") as day, DATE_FORMAT(order_history.created_date, "%u") as week, CONCAT(users.firstname,' ',users.lastname) AS fullname FROM order_history LEFT JOIN users ON users.id = order_history.user_id
		session_write_close();

        $orders = $this->global_model->get("views_order_history", "*", "deleted_by = 0 AND (status = 'FOR PROCESS' OR status = 'FOR PICKUP') AND fullname IS NOT NULL", ["column" => "created_date", "type" => "ASC"], "multiple", []);
        foreach ($orders as $key => $order) {
        	$orders[$key]->{"encrypted_id"} = encryptData($order->id);
        	$orders[$key]->{"date_pickup"} = date("M d, Y h:i A", strtotime($order->date_pickup));
        	$orders[$key]->{"created_date"} = date("M d, Y h:i A", strtotime($order->created_date));
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

		$user_id = $order['user_id'];
		$user_details = $this->global_model->get("views_users", "*", "id = '$user_id'", [], "single", []);
		$this->data['user_details'] = $user_details;

		$this->data['page_title'] = "Order Payment";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/order-payment');
		$this->load->view('layouts/footer');
	}

	public function saveCashOrderPayment(){
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
        		$ordered_products = $this->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);
        		
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

				$pdf_output = generateOrderReceipt($order_id);

        		// NOTIFY USER THROUGH EMAIL
	            $this->load->library('PHPmailer_lib');
	            $mail = $this->phpmailer_lib->load();
	            $mail->addAddress($user['email']);
	            $mail->Subject = "[".APPNAME."] ORDER PICKED UP";
	            $mail->isHTML(true);
	            $mail->Body = "
	                Good day! <br><br>
	                $content
	            ";
	            $mail->AddStringAttachment($pdf_output,"Receipt.pdf","base64","application/pdf");
	            $mail->send();

				$this->data['is_error'] = false;

				//CREATE AUDIT TRAIL
				$audit_details = [
					'details'=> $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []),
					'items'=> $ordered_products
				];
		        $params = [
		        	'user_id'=> $this->session->userdata('user_id'),
		        	'code'=> 'ORDER',
		        	'description'=> "Picked up order with Order Number <strong>{$order_number}</strong> using cash payment",
		        	'new_details'=> json_encode($audit_details, JSON_PRETTY_PRINT),
		        	'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
        	}
        }

		echo json_encode($this->data);
	}

	public function saveFacePayOrderPayment(){
		$order_id = $this->input->post("order_id");
		$order_id = decryptData($order_id);
		$is_face_pay_successful = $this->input->post("is_face_pay_successful");

		if($is_face_pay_successful == "false"){
			$this->data['error_msg'] = "FacePay payment method failed.";
			$this->data['is_error'] = true;
		}
		else{
			$order_details = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
			$order_amount = $order_details['total_amount'];
			$customer_id = $order_details['user_id'];
        	$order_number = $order_details['order_number'];

        	$user = $this->global_model->get("users", "id, email, facepay_wallet_balance", "id = '$customer_id'", [], "single", []);
        	if($user['facepay_wallet_balance'] < $order_amount){
        		$this->data['error_msg'] = "Not enough FacePay wallet balance.<br> Balance: <strong><span>&#8369;</span>".number_format($user['facepay_wallet_balance'], 2)."</strong>";
        		$this->data['is_error'] = true;
        	}
        	else{
        		$ordered_products = $this->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);

        		//UPDATE ORDER
        		$order_params = [
        			'status'=> 'PICKED UP',
        			'mode_of_payment'=> 'FACE PAY',
        			'actual_date_pickup'=> getTimeStamp(),
        			'user_in_charge'=> $this->session->userdata('user_id'),
        			'updated_date'=> getTimeStamp(),
        			'updated_by'=> $this->session->userdata('user_id'),
        		];
        		$this->global_model->update("order_history", "id = '$order_id'", $order_params);

        		$new_facepay_wallet_balance = $user['facepay_wallet_balance'] - $order_amount;
        		//UPDATE USER FACEPAY WALLET BALANCE
        		$user_params = [
        			"facepay_wallet_balance"=> $new_facepay_wallet_balance
        		];
        		$this->global_model->update("users", "id = '$customer_id'", $user_params);

        		//ADD FACEPAY WALLET ACITIVTY
        		$wallet_activity_params = [
        			"user_id"=> $customer_id,
        			"reference_no"=> time() . rand(10*45, 100*98),
        			"description"=> "Order payment",
        			"debit"=> 0,
        			"credit"=> $order_amount,
        			"balance" => $new_facepay_wallet_balance,
        			"source_table"=> "order_history",
        			"source_id"=> $order_id,
        			"created_date"=> getTimeStamp(),
        			"created_by"=> $this->session->userdata("user_id")
        		];
        		$this->global_model->insert("wallet_activity", $wallet_activity_params);

        		//NOTIFY USER/CUSTOMER
        		$content = "Payment successful for Order <strong>#{$order_number}</strong> using FacePay Payment.";
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

				$pdf_output = generateOrderReceipt($order_id);

        		// NOTIFY USER THROUGH EMAIL
	            $this->load->library('PHPmailer_lib');
	            $mail = $this->phpmailer_lib->load();
	            $mail->addAddress($user['email']);
	            $mail->Subject = "[".APPNAME."] ORDER PICKED UP";
	            $mail->isHTML(true);
	            $mail->Body = "
	                Good day! <br><br>
	                $content
	            ";
	            $mail->AddStringAttachment($pdf_output,"Receipt.pdf","base64","application/pdf");
	            $mail->send();

        		$this->data['is_error'] = false;

        		//CREATE AUDIT TRAIL
				$audit_details = [
					'details'=> $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []),
					'items'=> $ordered_products
				];
		        $params = [
		        	'user_id'=> $this->session->userdata('user_id'),
		        	'code'=> 'ORDER',
		        	'description'=> "Picked up order with Order Number <strong>{$order_number}</strong> using FacePay payment",
		        	'new_details'=> json_encode($audit_details, JSON_PRETTY_PRINT),
		        	'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
        	}
			
		}

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

	public function sendPaymentVerificationCode(){
		session_write_close();

		$email = $this->input->post("email");
		$order_number = $this->input->post("order_number");

		//UPDATE EXISTING ACTIVE OTP
        $update_data = [
            "is_active"=> 0,
        ];
        $this->global_model->update("otp", "email = '$email' AND is_active = 1 AND module = 'order_payment_verification'", $update_data);

        $code = rand(100000, 999999);
        $otp_params = [
            'email'=> $email,
            'code'=> $code,
            'is_active'=> 1,
            'module'=> 'order_payment_verification',
            //plus 20 mins
            // 20 * 60 = 1200
            'date_expiration'=> date('Y-m-d H:i:s',strtotime(getTimeStamp()) + 1200),
            'created_date'=> getTimeStamp()
        ];
        $this->global_model->insert("otp", $otp_params);

        // Load PHPMailer library
        $this->load->library('PHPmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
        // Add a recipient
        $mail->addAddress($email);
        
        // Email subject
        $mail->Subject = "[".APPNAME."]Order Payment Verification";
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = "
            Good day! <br><br>
            To verify your payment for Order <strong>#{$order_number}</strong>, please use this OTP:<br>
            <strong>".$code."</strong>
            <br><br>
            This is only valid for 20 minutes.
        ";

        $mail->send();

        session_start();

		echo json_encode($email);
	}

	public function verifyPaymentVerificationCode(){
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
	        $where = "email = '$email' AND is_active = 1 AND module = 'order_payment_verification'";
	        $order = ["column" => "id", "type" => "DESC"];
	        $otp_details = $this->global_model->get($db_name, $select, $where, $order, "single", []);

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

	        		$this->data['is_error'] = false;
	        	}
	        }
	        else{
	        	$this->data['is_error'] = true;
            	$this->data['error_msg'] = "Invalid verification code.";
	        }
        }

        echo json_encode($this->data);
	}

	public function orderReceiptPdf($hash_id){
		$id = decryptData($hash_id);

		$this->data['page_title'] = "Order Receipt";

		$order = $this->global_model->get("views_order_history", "*", "id = '$id'", [], "single", []);
		$this->data['order'] = $order;

		$products = $this->global_model->get("order_history_products", "*", "order_history_id = '$id'", [], "multiple", []);
		$this->data['products'] = $products;

		$user_in_charge_id = $order['user_in_charge'];
		$user_in_charge_details = $this->global_model->get("users", "*", "id = '$user_in_charge_id'", [], "single", []);
		$this->data['user_in_charge_details'] = $user_in_charge_details;

		if($order['status'] != "PICKED UP"){
			redirect("ongoing-orders");
		}

		$this->load->view('order/order-receipt-pdf', $this->data);
	}

	public function ordersHistoryPage(){
		$this->data['page_title'] = "Orders History";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/orders-history');
		$this->load->view('layouts/footer');
	}

	public function ordersHistoryList(){
		session_write_close();

		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

        $orders = $this->global_model->get("views_order_history", "*", "deleted_by = 0 AND (status != 'FOR PROCESS' AND status != 'FOR PICKUP') ", ["column" => "created_date", "type" => "DESC"], "multiple", []);
        foreach ($orders as $key => $order) {
        	$orders[$key]->{"encrypted_id"} = encryptData($order->id);
        	$orders[$key]->{"date_pickup"} = date("M d, Y h:i A", strtotime($order->date_pickup));
        	$orders[$key]->{"created_date"} = date("M d, Y h:i A", strtotime($order->created_date));
        	if($order->status == "CANCELED"){
        		$orders[$key]->{"actual_date_pickup"} = "N/A";
        	}
        	else{
        		$orders[$key]->{"actual_date_pickup"} = date("M d, Y h:i A", strtotime($order->actual_date_pickup));
        	}
        }
        $this->data['orders'] = $orders;

		session_start();
		echo json_encode($this->data);
	}

	public function ordersHistoryView($hash_id){
		$order_id = decryptData($hash_id);

		$order = $this->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);
		$this->data['order'] = $order;

		$order_items = $this->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);
		$this->data['order_items'] = $order_items;

		$this->data['page_title'] = "Orders History";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('order/orders-history-view');
		$this->load->view('layouts/footer');
	}
}