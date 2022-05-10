<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function logout(){
		if($this->session->userdata('user_id')){
            session_destroy();
            $this->session->unset_userdata('user_id');
        }
        
        redirect('');
	}

	public function dashboardPage(){
		$this->data['page_title'] = "Dashboard";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('layouts/header_buttons');
		if ($this->session->userdata("user_type") == "user") {
			$this->load->view('dashboard/dashboard', $this->data);
		}
		else{
			$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
			$last_day_this_month  = date('Y-m-t');

			$products = $this->global_model->get("products", "sum(stock) as total_stocks", "deleted_by = 0", [], "single", []);
        	$this->data['total_stocks'] = $products['total_stocks'];

        	$orders = $this->global_model->get("order_history", "sum(total_amount) as total_amount, sum(total_quantity) as total_quantity", "status = 'PICKED UP' AND deleted_by = 0 AND created_date >= '$first_day_this_month' AND created_date <= '$last_day_this_month'", [], "single", []);

        	$this->data['revenue'] = $orders['total_amount'];
        	$this->data['orders_this_week'] = $orders['total_quantity'];

        	$customers = $this->global_model->get("users", "count(id) as count", "user_type = 'user' AND deleted_by = 0", [], "single", []);
        	$this->data['customers'] = $customers['count'];

			$this->load->view('dashboard/admin-dashboard', $this->data);
		}
		
		$this->load->view('layouts/footer');
	}

	public function salesGraphData(){
		$months_array = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    	$list_label_orders = [];
    	$list_data_orders = [];
    	$list_label_revenue = [];
    	$list_data_revenue = [];
    	for($year = date('Y'); $year <= date('Y'); $year++){
    		for($month = 1; $month <= 12; $month++){
    			$first_day_month = date('Y-m-01', strtotime($year."-".$month."-01"));
    			$last_day_month = date('Y-m-t', strtotime($year."-".$month."-01"));

    			$orders = $this->global_model->get("order_history", "sum(total_quantity) as total_quantity, sum(total_amount) as total_amount", "status = 'PICKED UP' AND deleted_by = 0 AND created_date >= '$first_day_month' AND created_date <= '$last_day_month'", [], "single", []);

    			$list_label_orders[] = date('M Y',strtotime($first_day_month));
    			$list_data_orders[] = $orders['total_quantity']? $orders['total_quantity']: "0";

    			$list_label_revenue[] = date('M Y',strtotime($first_day_month));
    			$list_data_revenue[] = $orders['total_amount']? $orders['total_amount']: "0";
    		}
    	}

    	$this->data['list_label_orders'] = $list_label_orders;
    	$this->data['list_data_orders'] = $list_data_orders;
    	$this->data['list_label_revenue'] = $list_label_revenue;
    	$this->data['list_data_revenue'] = $list_data_revenue;

    	echo json_encode($this->data);
	}

}
