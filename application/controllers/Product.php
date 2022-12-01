<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function productList(){
		//CREATE OR REPLACE VIEW views_products AS SELECT products.*, product_category.name AS category_name, CONCAT(users.firstname," ",users.lastname) AS full_name FROM `products` LEFT JOIN product_category ON products.category_id = product_category.id LEFT JOIN users ON products.created_by = users.id
		session_write_close();

		$product_limit = $this->input->post("product_limit");
		$product_limit_start = $this->input->post("product_limit_start");

		//FOR DASHBOARD PRODUCT LIST START
		$category = $this->input->post("category");
		if($category){
			$category = implode(",", $category);
		}
		$search_name = $this->input->post("search_name");
		//FOR DASHBOARD PRODUCT LIST END
		
		//GET PRODUCTS
		$db_name = "views_products";
        $select =  "*";
        $order = ["column" => "id", "type" => "DESC"];
        $limit = ["limit"=> $product_limit, "limit_start"=> $product_limit_start];
        $where = "deleted_by = 0";

        //FOR DASHBOARD PRODUCT LIST START
        if($category != null){
        	$where .= " AND FIND_IN_SET(category_id, '$category')";
        }
        if($search_name != null){
        	$where .= " AND (name LIKE '%$search_name%')";
        }
        //FOR DASHBOARD PRODUCT LIST START

        $products = $this->global_model->get($db_name, $select, $where, $order, "multiple", $limit);

        foreach ($products as $key => $product) {
        	$products[$key]->{"encrypted_id"} = encryptData($product->id);
        	$products[$key]->{"category_name"} = $product->category_name? $product->category_name: 'No category';

        	//CHECK IF PRODUCT IS ALREADY IN WISHLIST
        	$product_id = $product->id;
        	$user_id = $this->session->userdata('user_id');
        	$wishlist = $this->global_model->get("views_wishlist", "id", "user_id = '{$user_id}' AND product_id = '{$product_id}'", "", "single", "");
        	$products[$key]->{"is_in_wishlist"} = $wishlist? true: false;
        }

        $this->data['products'] = $products;
        $this->data['where'] = $where;

        session_start();

        echo json_encode($this->data);
	}

	public function productCategoryList(){
		session_write_close();
		//GET PRODUCT CATEGORY
		$db_name = "product_category";
        $select =  "*";
        $where = "deleted_by = 0";
        $categories = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

        $this->data['categories'] = $categories;

        session_start();

		echo json_encode($this->data);
	}

	public function addToCart(){
		session_write_close();
		$id = $this->input->post('id');
		$id = decryptData($id);
		$user_id = $this->session->userdata('user_id');

		// //GET PRODUCTS
		$db_name = "views_products";
        $select =  "id, stock, name";
        $where = "deleted_by = 0 AND id = '$id'";
        $product = $this->global_model->get($db_name, $select, $where, "", "single", "");

        
        //CHECK IF PRODUCT DOES EXIST
        if(empty($product)){
        	$this->data['is_error'] = true;
        	$this->data['error_msg'] = "Product does not exist.";
        }
        else{
	        //CHECK IF PRODUCT HAS STOCK
	        if($product['stock'] == 0){
        		$this->data['is_error'] = true;
        		$this->data['error_msg'] = "There are only ".$product['stock']." stock for this product.";
        	}
        	else{
				$db_name = "views_cart";
		        $select =  "id, quantity, stock";
		        $where = "product_id = '$id' AND user_id = {$user_id}";
		        $product_on_cart = $this->global_model->get($db_name, $select, $where, "", "single", "");

		        //CHECK IF PRODUCT IS ALREADY ON CART
		        if($product_on_cart){
		        	$new_quantity = $product_on_cart['quantity'] + 1;
		        	$cart_id = $product_on_cart['id'];
		        	$params = [
	        			'quantity'=> $product['stock'],
	        			'updated_date'=> getTimeStamp(),
	        			'updated_by'=> $this->session->userdata('user_id'),
	        		];

		        	//CHECK IF NEW QUANTITY IS GREATER THAN THE PRODUCT'S STOCK
		        	if($new_quantity > $product['stock']){
		        		$params['quantity'] = $product['stock'];
		        		
		        		$this->data['error_msg'] = "There are only ".$product['stock']." stock for this product.";
		        		$this->data['is_error'] = true;
		        	}
		        	else{
		        		$params['quantity'] = $new_quantity;
		        		$this->data['is_error'] = false;
		        	}
		        	$this->global_model->update("cart", "id = '$cart_id'", $params);
		        }
		        //IF NOT IT WILL INSERT THE PRODUCT ON CART INSTEAD
		        else{
		        	$params = [
	        			'user_id'=> $this->session->userdata('user_id'),
	        			'product_id'=> $id,
	        			'quantity'=> 1,
	        			'created_date'=> getTimeStamp(),
	        			'created_by'=> $this->session->userdata('user_id'),
	        		];

	        		$insert = $this->global_model->insert('cart', $params);

	        		$this->data['is_error'] = false;

	        		//CREATE AUDIT TRAIL
			        $params = [
			            'user_id'=> $this->session->userdata('user_id'),
			            'code'=> 'CART',
			            'description'=> "Added product <strong>".$product['name']."</strong> to cart",
			            'created_date'=> getTimeStamp()
			        ];
			        $this->global_model->insert("audit_trail", $params);
		        }
        	}
        }
		
		session_start();
		echo json_encode($this->data);
	}

	public function removeToCart(){
		session_write_close();
		$id = $this->input->post('id');
		$id = decryptData($id);
		$user_id = $this->session->userdata('user_id');

		$db_name = "views_cart";
        $select =  "id, quantity, stock, name";
        $where = "product_id = '$id' AND user_id = {$user_id}";
        $product_on_cart = $this->global_model->get($db_name, $select, $where, "", "single", "");

        if($product_on_cart){
        	if($product_on_cart['quantity'] > $product_on_cart['stock']){
        		$quantity = $product_on_cart['stock'];
        	}
        	else{
        		$quantity = $product_on_cart['quantity'];
        	}

        	$new_quantity = $quantity - 1;
		    $cart_id = $product_on_cart['id'];

		    //IF QUANTITY REACHES 0 OR BELOW, REMOVE PRODUCT ON CART
		    if($new_quantity <= 0){
		    	$this->global_model->delete('cart', "id = '$cart_id'");

		    	//CREATE AUDIT TRAIL
		        $params = [
		            'user_id'=> $this->session->userdata('user_id'),
		            'code'=> 'CART',
		            'description'=> "Removed product <strong>".$product_on_cart['name']."</strong> from cart",
		            'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
		    }
		    else{
		    	$params = [
	    			'quantity'=> $new_quantity,
	    			'updated_date'=> getTimeStamp(),
	    			'updated_by'=> $this->session->userdata('user_id'),
	    		];

	    		$this->global_model->update("cart", "id = '$cart_id'", $params);
		    }
		    
		    $this->data['new_quantity'] = $new_quantity;
        }

        $this->data['is_error'] = false;
        
		session_start();
		echo json_encode($this->data);
	}

	public function cartTotalItem(){
		session_write_close();
		$user_id = $this->session->userdata('user_id');

		//GET CART
		$db_name = "views_cart";
        $select =  "quantity, stock";
        $where = "user_id = '$user_id' AND name != 'null'";
        $products = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

        $total_product_in_cart = 0;
        foreach ($products as $key => $product) {
        	if($product->quantity > $product->stock){
        		$total_product_in_cart += $product->stock;
        	}
        	else{
        		$total_product_in_cart += $product->quantity;
        	}
        }
        $this->data['total'] = $total_product_in_cart;

        session_start();

        echo json_encode($this->data);
	}

	public function cartItemList(){
		//CREATE OR REPLACE VIEW views_cart AS SELECT cart.*, products.name, products.code, products.price, products.price_without_vat, products.stock, products.category_name, products.image_path FROM `cart` LEFT JOIN views_products AS products ON cart.product_id = products.id
		session_write_close();

		$user_id = $this->session->userdata('user_id');
		$user_details = $this->global_model->get("users", "points_balance", "id = {$user_id}", "", "single", "");
		$this->data['points_balance'] = $user_details['points_balance'];

		//GET CART PRODUCTS
		$db_name = "views_cart";
        $select =  "*";
        $where = "user_id = '$user_id' AND name != 'null'";
        $products = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

        foreach ($products as $key => $product) {
        	$products[$key]->{"encrypted_product_id"} = encryptData($product->product_id);
        }

        $this->data['products'] = $products;

		session_start();

		echo json_encode($this->data);
	}

	public function checkOutCart(){
		session_write_close();

		$date_pickup = $this->input->post("date_pickup");
		$instruction = $this->input->post("instruction");
		$points_redeem = $this->input->post("points_redeem");
		$total_cart_product_amount = $this->input->post("total_cart_product_amount");
		$user_id = $this->session->userdata('user_id');

		$this->form_validation->set_rules('date_pickup','date pickup','required', array(
			'required'=> 'Please select date pickup.'
		));

		if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	if(strtotime($date_pickup) < strtotime(getTimeStamp())){
        		$this->data['is_error'] = true;
            	$this->data['error_msg'] = "You can't select previous date/time.";
        	}
        	else if($points_redeem > $total_cart_product_amount){
        		$this->data['is_error'] = true;
            	$this->data['error_msg'] = "Points redeem cannot be greater than the sub total amount.";
        	}
        	else{
        		//GET CART PRODUCTS
				$db_name = "views_cart";
		        $select =  "*";
		        $where = "user_id = '$user_id' AND name != 'null'";
		        $products = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

		        //GET ADMIN AND STAFF
		        $admins = $this->global_model->get("users", "id", "(user_type = 'admin' OR user_type = 'staff') AND is_active = 1 AND deleted_by = 0", ["column" => "id", "type" => "ASC"], "multiple", []);

		        if($products){
		        	$order_number = time() . rand(10*45, 100*98);
			        //INSERT ORDER HISTORY
			        $order_history_params = [
			        	"user_id"=> $user_id,
			        	"order_number"=> $order_number,
			        	// "total_items"=> $total_items,
			        	// "total_amount"=> $total_amount,
			        	"date_pickup"=> date('Y-m-d H:i:s', strtotime($date_pickup)),
			        	"instruction"=> $instruction,
			        	"points_redeem"=> $points_redeem,
			        	"status"=> "FOR PROCESS",
			        	"created_date"=> getTimeStamp(),
			        	"created_by"=> $user_id
			        ];
			        $insert_id = $this->global_model->insert("order_history", $order_history_params);

			        if($points_redeem > 0){
			        	$user = $this->global_model->get("users", "points_balance", "id = '$user_id'", [], "single", []);
			        	$new_points_balance = $user['points_balance'] - $points_redeem;
	        			$points_activity_params = [
			    			"user_id"=> $user_id,
			    			"reference_no"=> time() . rand(10*45, 100*98),
			    			"description"=> "Points redeemed in order #{$order_number}",
			    			"debit"=> 0,
			    			"credit"=> $points_redeem,
			    			"balance" => $new_points_balance,
			    			"created_date"=> getTimeStamp(),
			    			"created_by"=> $this->session->userdata("user_id")
			    		];
			    		$this->global_model->insert("points_activity", $points_activity_params);

			    		$user_params = [
		        			"points_balance"=> $new_points_balance
		        		];
		        		$this->global_model->update("users", "id = '$user_id'", $user_params);
			        }

			        //INSERT LOGS
			        $params = [
			        	'order_history_id'=> $insert_id,
			        	'status'=> 'FOR PROCESS',
			        	'title'=> 'Order placed',
			        	'description'=> 'Order was placed',
			        	'created_date'=> getTimeStamp(),
			        	"created_by"=> $user_id
			        ];
			        $this->global_model->insert("order_history_logs", $params);

			        $total_quantity = 0;
			        $total_amount = 0;
			        $order_history_products_params = [];
			        $products_params = [];
			        $products_history_params = [];
			        $bulk_admin_notifs_params = [];
			        //INSERT EACH PRODUCT ON ORDER HISTORY PRODUCTS
			        foreach ($products as $key => $product) {
			        	if($product->quantity <= $product->stock){
			        		$total_quantity += $product->quantity;
			        		$total_amount += ($product->quantity * $product->price);
			        		$order_history_products_params[] = [
			        			"order_history_id"=> $insert_id,
			        			"product_id"=> $product->product_id,
			        			"name"=> $product->name,
			        			"code"=> $product->code,
			        			"category_name"=> $product->category_name,
			        			"quantity"=> $product->quantity,
			        			"price"=> $product->price,
			        			"price_without_vat"=> $product->price_without_vat,
			        			"created_date"=> getTimeStamp(),
			        			"created_by"=> $user_id
			        		];

			        		$products_params[] = [
			        			"id"=> $product->product_id,
			        			"stock"=> $product->stock - $product->quantity,
			        		];

			        		//ADD TO HISTORY/LOGS OF PRODUCT
			        		$products_history_params[] = [
			        			"product_id"=> $product->product_id,
			        			"stock"=> $product->quantity,
			        			"new_stock"=> $product->stock - $product->quantity,
			        			"action_type"=> "minus",
			        			"description"=> "Stock(s) deducted.<br> Order Number <strong>{$order_number}</strong>",
			        			"created_date"=> getTimeStamp(),
			        			"created_by"=> $this->session->userdata("user_id")
			        		];

			        		//IF OUT OF STOCK NOTIFY ADMIN
			        		if(($product->stock - $product->quantity) <= 0){
			        			foreach ($admins as $key => $user) {
					                $bulk_admin_notifs_params[] = [
					                    "receiver"=> $user->id,
					                    "user_id"=> $user_id,
					                    "content"=> "Product <strong>{$product->name}</strong> is now out of stock.",
					                    "type"=> "PRODUCT",
					                    "source_table"=> "products",
					                    "source_id"=> $product->product_id,
					                    "read_status"=> 0,
					                    "created_date"=> getTimeStamp(),
					                    "created_by"=> $user_id
					                ];
					            }
			        		}
			        	}
			        }
			        $this->global_model->batch_insert_or_update("order_history_products", $order_history_products_params);
			        $this->global_model->batch_insert_or_update("products_history", $products_history_params);
			        if($bulk_admin_notifs_params){
			        	$this->global_model->batch_insert_or_update("notifications", $bulk_admin_notifs_params);
			        }
			        	
			        //UPDATE ORDER HISTORY TOTAL AMOUNT AND TOTAL QUANTITY
			        $update_order_history_params = [
			        	'total_quantity'=> $total_quantity,
			        	'total_amount'=> $total_amount,
			        	'grand_total'=> $total_amount - $points_redeem
			        ];
			        $this->global_model->update("order_history", "id = '$insert_id'", $update_order_history_params);

			        //UPDATE STOCK OF PRODUCT
			        $this->global_model->batch_insert_or_update("products", $products_params);

			        //CLEAR USER CART
			        $this->global_model->delete("cart", "user_id = '$user_id'");

			        //NOTIFY ADMIN AND STAFF
			        $bulk_insert_params = [];
		        	$users = $this->global_model->get("users", "id", "(user_type = 'admin' OR user_type = 'staff') AND is_active = 1 AND deleted_by = 0", ["column" => "id", "type" => "ASC"], "multiple", []);
		        	foreach ($users as $key => $user) {
		        		$bulk_insert_params[] = [
		        			"receiver"=> $user->id,
		        			"user_id"=> $user_id,
		        			"content"=> "Customer #customer_name placed an order with Order Number <a href='".base_url()."order-view/".encryptData($insert_id)."'>{$order_number}</a>.",
		        			"type"=> "NEW_ORDER",
		        			"source_table"=> "order_history",
		        			"source_id"=>$insert_id,
		        			"read_status"=> 0,
		        			"created_date"=> getTimeStamp(),
		        			"created_by"=> $user_id
		        		];
		        	}

		        	$this->global_model->batch_insert_or_update("notifications", $bulk_insert_params);

					$this->data['is_error'] = false;

					//CREATE AUDIT TRAIL
					$order_history_params['id'] = $insert_id;
					$order_history_products = $this->global_model->get("order_history_products", "*", "order_history_id = {$insert_id}", "", "multiple", "");
					$audit_details = [
						'details'=> $order_history_params,
						'items'=> $order_history_products
					];
			        $params = [
			        	'user_id'=> $user_id,
			        	'code'=> 'ORDER',
			        	'description'=> "Placed an order with Order Number <strong>{$order_number}</strong>",
			        	'new_details'=> json_encode($audit_details, JSON_PRETTY_PRINT),
			        	'created_date'=> getTimeStamp()
			        ];
			        $this->global_model->insert("audit_trail", $params);
				}
				else{
					$this->data['is_error'] = true;
            		$this->data['error_msg'] = 'No products to checkout.';
				}
        	}
        	
        }
		
		session_start();

		echo json_encode($this->data);
	}

	public function productPage(){
		$this->data['page_title'] = "Product";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('product/product');
		$this->load->view('layouts/footer');
	}

	public function productAddPage(){
		$this->data['page_title'] = "Product Add";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('product/product-add');
		$this->load->view('layouts/footer');
	}

	public function productSave(){
		$post = $this->input->post();

		$name = $post['name'];
		$price = $post['price'];
		$price_without_vat = $post['price_without_vat'];
		//$stock = $post['stock'];
		$category = isset($post['category'])? $post['category']: "";

		$is_error = false;
		$error_msg = "";

		//CHECK IF ACTION IS FOR UPDATE
		$action_type = "add";
		if(isset($post['encrypted_id'])){
			$action_type = "update";
		}

		if($action_type == "update"){
			$id = decryptData($post['encrypted_id']);
			$product_details = $this->global_model->get("views_products", "*", "id = {$id}", [], "single", []);

			//IF PRODUCT EXISTS
			$check_product_exists = $this->global_model->get("views_products", "id", "name = '{$name}'", [], "single", []);

			if($check_product_exists && $check_product_exists['id'] != $id){
				$is_error = true;
            	$error_msg .= "<p>Product already exist.</p>";
			}

			$this->form_validation->set_rules('name','name','required');
		}
		else{
			$this->form_validation->set_rules('name','name','required|is_unique[products.name]', array(
				'is_unique'=>"Product name already exist.",
			));
		}

		$this->form_validation->set_rules('price','price','required');
		$this->form_validation->set_rules('price_without_vat','price_without_vat','required');
		$this->form_validation->set_rules('category','category','required');

		if($this->form_validation->run() == FALSE){
            $is_error = true;
            $error_msg .= validation_errors();
        }
        else{
        	if(!is_numeric($price) && !floor($price)){
        		$is_error = true;
            	$error_msg .= "<p>Please enter correct price with vat.</p>";
        	}

        	if(!is_numeric($price_without_vat) && !floor($price_without_vat)){
        		$is_error = true;
            	$error_msg .= "<p>Please enter correct price without vat.</p>";
        	}

        	if($price_without_vat > $price){
        		$is_error = true;
            	$error_msg .= "<p>Price without vat should not be greater than price with vat.</p>";
        	}

        	if(!$is_error){
        		$target_dir = 'assets/uploads/products';
	
				if(!is_dir($target_dir))
				{
					mkdir($target_dir,0777,true);
				}

        		if($_FILES['file']['name']){
        			$type = $_FILES['file']['type'];
					$tmp_name =  $_FILES['file']['tmp_name'];
					$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					$new_file_name = uniqid().".{$ext}";
		        	$image_path = $target_dir.'/'.$new_file_name;
		        	$post['image_path'] = $image_path;
		        	move_uploaded_file($tmp_name,FCPATH.$image_path);

		        	if($action_type == "update"){
		        		if (file_exists(FCPATH.$product_details['image_path'])) {
							unlink(FCPATH.$product_details['image_path']);
						}
		        	}
		        }
		        else{
		        	if($action_type == "update"){
		        		$post['image_path'] = $product_details['image_path'];
		        	}
		        	else{
		        		$post['image_path'] = $target_dir.'/no-image-available.jpg';
		        	}
		        }

		        $post['category_id'] = $post['category'];
        		unset($post['category']);

		        if($action_type == "update"){
		        	$post['updated_date'] = getTimeStamp();
        			$post['updated_by'] = $this->session->userdata('user_id');
        			$product_id = decryptData($post['encrypted_id']);
        			unset($post['encrypted_id']);
        			$this->global_model->update("products", "id = {$id}" ,$post);

        			//CHECK CHANGES
        			$changes = [];
        			$fields = ["name", "price", "price_without_vat", "category_id"];
                    foreach ($fields as $field) {
                        if($product_details[$field] != $post[$field]){
                            if($field == "category_id"){
                            	$category_details = $this->global_model->get("product_category", "name", "id = ".$post[$field], [], "single", []);
                                $current_value = empty($product_details['category_name'])? 'no value': $product_details['category_name'];
                                $new_value = $category_details['name'];
                                $field = 'category name';
                            }
                            else{
                                $current_value = empty($product_details[$field])? 'no value': $product_details[$field];
                                $new_value = $post[$field];
                            }

                            $changes[] = "<span style='text-decoration:underline;'>".(ucwords($field))."</span>: <strong>(from)</strong> ".$current_value." <strong>(to)</strong> ".$new_value;
                        }
                    }

                    if($changes){
                        $changes_in_text = "Changes made on the following fields: \r<br>".implode("\r<br>", $changes);

	        			//CREATE AUDIT TRAIL
	        			$new_details = $this->global_model->get("views_products", "*", "id = {$id}", [], "single", []);
			            $params = [
			                'user_id'=> $this->session->userdata('user_id'),
			                'code'=> 'PRODUCT',
			                'description'=> "Updated product <strong>".$product_details['name']."</strong> <br> {$changes_in_text}",
			                'old_details'=> json_encode($product_details, JSON_PRETTY_PRINT),
			                'new_details'=> json_encode($new_details, JSON_PRETTY_PRINT),
			                'created_date'=> getTimeStamp()
			            ];
			            $this->global_model->insert("audit_trail", $params);
			        }
		        }
		        else{
		        	$post['code'] = time() . rand(10*45, 100*98);
		        	$post['created_date'] = getTimeStamp();
        			$post['created_by'] = $this->session->userdata('user_id');
        			$insert_id = $this->global_model->insert("products", $post);

        			//CREATE AUDIT TRAIL
		            $new_details = $this->global_model->get("views_products", "*", "id = {$insert_id}", [], "single", []);
		            $params = [
		                'user_id'=> $this->session->userdata('user_id'),
		                'code'=> 'PRODUCT',
		                'description'=> "Added new product <strong>".$post['name']."</strong>",
		                'new_details'=> json_encode($new_details, JSON_PRETTY_PRINT),
		                'created_date'=> getTimeStamp()
		            ];
		            $this->global_model->insert("audit_trail", $params);
		        }

        		$is_error = false;
        	}
        }


        $this->data['is_error'] = $is_error;
        $this->data['error_msg'] = $error_msg;

		echo json_encode($this->data);
	}

	public function productViewPage($hash_id){
		$id = decryptData($hash_id);

        $product_details = $this->global_model->get("views_products", "*", "id = {$id}", [], "single", []);
        $this->data['product_details'] = $product_details;

		$this->data['page_title'] = "Product View";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('product/product-view');
		$this->load->view('layouts/footer');
	}

	public function productEditPage($hash_id){
		$id = decryptData($hash_id);

        $product_details = $this->global_model->get("views_products", "*", "id = {$id}", [], "single", []);
        $this->data['product_details'] = $product_details;

		$this->data['page_title'] = "Product Edit";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('product/product-edit');
		$this->load->view('layouts/footer');
	}

	public function addStock(){
		$post = $this->input->post();

		$product_id = $post['product_id'];
		$stock = $post['stock'];

		$this->form_validation->set_rules('stock','stock','required');

		if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
        	$this->data['error_msg'] = validation_errors();
        }
        else{
			if(!is_numeric($stock)){
        		$this->data['is_error'] = true;
            	$this->data['error_msg'] = "<p>Please enter correct stock.</p>";
        	}
        	else{
        		$product = $this->global_model->get("products", "id,stock,name", "id = '$product_id'", [], "single", []);
        		$new_stock = $product['stock'] + $stock;

        		$products_params[] = [
        			"id"=> $product['id'],
			        "stock"=> $new_stock,
        		];
        		$this->global_model->batch_insert_or_update("products", $products_params);

        		$products_history_params = [
        			"product_id"=> $product['id'],
        			"stock"=> $stock,
        			"new_stock"=> $new_stock,
        			"action_type"=> "add",
        			"description"=> "Stock(s) added.",
        			"created_date"=> getTimeStamp(),
        			"created_by"=> $this->session->userdata("user_id")
        		];
        		$this->global_model->insert("products_history", $products_history_params);

        		$this->data['is_error'] = false;

        		//CREATE AUDIT TRAIL
        		$params = [
		        	'user_id'=> $this->session->userdata('user_id'),
		        	'code'=> 'PRODUCT',
		        	'description'=> "Added {$stock} stock(s) on product <strong>".$product['name']."</strong>",
		        	'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
        	}
		}

		echo json_encode($this->data);
	}

	public function productHistory(){
		$product_id = $this->input->post("product_id");

		$products = $this->global_model->get("products_history", "*", "product_id = '$product_id'", ["column" => "id", "type" => "DESC"], "multiple", []);
		$this->data['products'] = $products;

		echo json_encode($this->data);

	}

	public function wishListItem(){
		session_write_close();

		$user_id = $this->session->userdata('user_id');

		//GET CART PRODUCTS
        $wishlist = $this->global_model->get("views_wishlist", "*", "user_id = '$user_id' AND name != 'null'", "", "multiple", "");

        foreach ($wishlist as $key => $w) {
        	$wishlist[$key]->{"encrypted_product_id"} = encryptData($w->product_id);
        	$wishlist[$key]->{"encrypted_wishlist_id"} = encryptData($w->id);
        }

        $this->data['wishlist'] = $wishlist;

		session_start();

		echo json_encode($this->data);
	}

	public function wishListTotalItem(){
		session_write_close();
		$user_id = $this->session->userdata('user_id');

		//GET CART
        $wishlist = $this->global_model->get("views_wishlist", "count(*) as total", "user_id = '$user_id' AND name != 'null'", "", "single", "");

        $this->data['total'] = $wishlist['total'];

        session_start();

        echo json_encode($this->data);
	}

	public function removeToWishList(){
		session_write_close();
		$id = $this->input->post('id');
		$id = decryptData($id);

		//GET WISHLIST DETAILS
		$wishlist = $this->global_model->get("wishlist", "id,product_id", "id = '{$id}'", "", "single", "");
		if($wishlist){
			//GET PRODUCTS
			$product_id = $wishlist['product_id'];
	        $product = $this->global_model->get("views_products", "id,name", "id = {$product_id}", "", "single", "");
	        if($product){
	        	//CREATE AUDIT TRAIL
		        $params = [
		            'user_id'=> $this->session->userdata('user_id'),
		            'code'=> 'WISHLIST',
		            'description'=> "Removed product <strong>".$product['name']."</strong> from wishlist",
		            'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
	        }
	    }

		$this->global_model->delete('wishlist', "id = '$id'");

		$this->data['success'] = true;

		session_start();
		echo json_encode($this->data);
	}

	public function addToWishList(){
		session_write_close();
		$id = $this->input->post('id');
		$id = decryptData($id);
		$user_id = $this->session->userdata('user_id');

		// //GET PRODUCTS
        $product = $this->global_model->get("views_products", "id,name", "deleted_by = 0 AND id = '$id'", "", "single", "");

        //CHECK IF PRODUCT DOES EXIST
        if(!$product){
        	$this->data['success'] = false;
        	$this->data['error_msg'] = "Product does not exist.";
        }
        else{
        	//CHECK IF ALREADY IN CHECKLIST
        	$wishlist = $this->global_model->get("wishlist", "id", "user_id = '{$user_id}' AND product_id = '$id'", "", "single", "");
        	if($wishlist){
        		$this->data['success'] = false;
        		$this->data['error_msg'] = "Already in wish list.";
        	}
        	else{
        		$params = [
	    			'user_id'=> $this->session->userdata('user_id'),
	    			'product_id'=> $id,
	    			'created_date'=> getTimeStamp(),
	    			'created_by'=> $this->session->userdata('user_id'),
	    		];

	    		$insert = $this->global_model->insert('wishlist', $params);

	    		$this->data['success'] = true;

	    		//CREATE AUDIT TRAIL
		        $params = [
		            'user_id'=> $user_id,
		            'code'=> 'WISHLIST',
		            'description'=> "Added product <strong>".$product['name']."</strong> to wishlist",
		            'created_date'=> getTimeStamp()
		        ];
		        $this->global_model->insert("audit_trail", $params);
        	}   
        }
		
		session_start();
		echo json_encode($this->data);
	}

	public function removeProduct(){
		$product_id = $this->input->post('product_id');
		$user_id = $this->session->userdata('user_id');

		$result = [];
		$success = true;
		$msg = "";

		$params = [
			"deleted_by"=> $user_id,
			'deleted_date'=> getTimeStamp()
		];
		$this->global_model->update("products", "id = '{$product_id}'", $params);

		//GET PRODUCT DETAILS
		$product_details = $this->global_model->get("views_products", "*", "id = {$product_id}", [], "single", []);

		//CREATE AUDIT TRAIL
        $params = [
            'user_id'=> $this->session->userdata('user_id'),
            'code'=> 'PRODUCT',
            'description'=> "Removed product <strong>".$product_details['name']."</strong>",
            'new_details'=> json_encode($product_details, JSON_PRETTY_PRINT),
            'created_date'=> getTimeStamp()
        ];
        $this->global_model->insert("audit_trail", $params);

		$result = [
			'success'=> $success,
			'msg'=> $msg
		];
		echo json_encode($result);
	}

	public function wishlistPage(){
		$this->data['page_title'] = "Wishlist";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('product/wishlist');
		$this->load->view('layouts/footer');
	}

	public function wishlistData(){
		session_write_close();

		//GET CART PRODUCTS
        $wishlist = $this->global_model->get("views_wishlist", "*", "name != 'null'", "", "multiple", "");
        $this->data['wishlist'] = $wishlist;

		session_start();

		echo json_encode($this->data);
	}

}