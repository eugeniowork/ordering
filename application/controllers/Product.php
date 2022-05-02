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

		// //GET PRODUCTS
		$db_name = "views_products";
        $select =  "id, stock";
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
		        $where = "product_id = '$id'";
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

		$db_name = "views_cart";
        $select =  "id, quantity, stock";
        $where = "product_id = '$id'";
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
		//CREATE OR REPLACE VIEW views_cart AS SELECT cart.*, products.name, products.code, products.price, products.stock, products.category_name, products.image_path FROM `cart` LEFT JOIN views_products AS products ON cart.product_id = products.id
		session_write_close();

		$user_id = $this->session->userdata('user_id');

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
		$user_id = $this->session->userdata('user_id');

		$this->form_validation->set_rules('date_pickup','date pickup','required', array(
			'required'=> 'Please select date pickup.'
		));

		if($this->form_validation->run() == FALSE){
            $this->data['is_error'] = true;
            $this->data['error_msg'] = validation_errors();
        }
        else{
        	if(strtotime($date_pickup) < strtotime(date('Y-m-d'))){
        		$this->data['is_error'] = true;
            	$this->data['error_msg'] = 'Please select date pickup from today onwards only.';
        	}
        	else{
        		//GET CART PRODUCTS
				$db_name = "views_cart";
		        $select =  "*";
		        $where = "user_id = '$user_id' AND name != 'null'";
		        $products = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

		        if($products){
		        	$order_number = time();
			        //INSERT ORDER HISTORY
			        $order_history_params = [
			        	"user_id"=> $user_id,
			        	"order_number"=> $order_number,
			        	// "total_items"=> $total_items,
			        	// "total_amount"=> $total_amount,
			        	"date_pickup"=> $date_pickup,
			        	"status"=> "FOR PROCESS",
			        	"created_date"=> getTimeStamp(),
			        	"created_by"=> $user_id
			        ];
			        $insert_id = $this->global_model->insert("order_history", $order_history_params);

			        $total_quantity = 0;
			        $total_amount = 0;
			        $order_history_products_params = [];
			        $products_params = [];
			        //INSERT EACH PRODUCT ON ORDER HISTORY PRODUCTS
			        foreach ($products as $key => $product) {
			        	if($product->quantity <= $product->stock){
			        		$total_quantity += $product->quantity;
			        		$total_amount += ($product->quantity * $product->price);
			        		$order_history_products_params[] = [
			        			"order_history_id"=> $insert_id,
			        			"product_id"=> $product->product_id,
			        			"name"=> $product->name,
			        			"category_name"=> $product->category_name,
			        			"quantity"=> $product->quantity,
			        			"price"=> $product->price,
			        			"created_date"=> getTimeStamp(),
			        			"created_by"=> $user_id
			        		];

			        		$products_params[] = [
			        			"id"=> $product->product_id,
			        			"stock"=> $product->stock - $product->quantity,
			        		];
			        	}
			        }
			        $this->global_model->batch_insert_or_update("order_history_products", $order_history_products_params);
			        	
			        //UPDATE ORDER HISTORY TOTAL AMOUNT AND TOTAL QUANTITY
			        $update_order_history_params = [
			        	'total_quantity'=> $total_quantity,
			        	'total_amount'=> $total_amount
			        ];
			        $this->global_model->update("order_history", "id = '$insert_id'", $update_order_history_params);

			        //UPDATE STOCK OF PRODUCT
			        $this->global_model->batch_insert_or_update("products", $products_params);

			        //CLEAR USER CART
			        $this->global_model->delete("cart", "user_id = '$user_id'");

			        //NOTIFY ADMIN AND STAFF
			        $bulk_insert_params = [];
		        	$users = $this->global_model->get("users", "id", "(user_type = 'admin' OR user_type = 'staff') AND is_active = 1 AND deleted_by = 0", [], "multiple", []);
		        	foreach ($users as $key => $user) {
		        		$bulk_insert_params[] = [
		        			"receiver"=> $user->id,
		        			"user_id"=> $user_id,
		        			"content"=> "Customer #customer_name placed an order with Order Number <strong>{$order_number}</strong>.",
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
}