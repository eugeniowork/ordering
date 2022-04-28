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

        echo json_encode($this->data);
	}

	public function productCategoryList(){
		//GET PRODUCT CATEGORY
		$db_name = "product_category";
        $select =  "*";
        $where = "deleted_by = 0";
        $categories = $this->global_model->get($db_name, $select, $where, "", "multiple", "");

        $this->data['categories'] = $categories;
		echo json_encode($this->data);
	}
}