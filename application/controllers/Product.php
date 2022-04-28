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
		$product_limit = $this->input->post("product_limit");
		$product_limit_start = $this->input->post("product_limit_start");

		//GET PRODUCTS
		$db_name = "products";
        $select =  "*";
        $where = "deleted_by = 0";
        $order = ["column" => "id", "type" => "DESC"];
        $limit = ["limit"=> $product_limit, "limit_start"=> $product_limit_start];
        $products = $this->global_model->get($db_name, $select, $where, $order, "multiple", $limit);

        foreach ($products as $key => $product) {
        	$products[$key]->{"encrypted_id"} = encryptData($product->id);
        }

        $this->data['products'] = $products;

        echo json_encode($this->data);
	}
}