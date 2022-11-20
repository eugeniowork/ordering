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

        date_default_timezone_set("Asia/Manila");
	}

	public function logout(){
        //CREATE AUDIT TRAIL
        $params = [
            'user_id'=> $this->session->userdata('user_id'),
            'code'=> 'ACCOUNT',
            'description'=> 'Logged out',
            'created_date'=> getTimeStamp()
        ];
        $this->global_model->insert("audit_trail", $params);

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

        	$orders = $this->global_model->get("order_history", "sum(grand_total) as total_amount, sum(total_quantity) as total_quantity", "status = 'PICKED UP' AND deleted_by = 0 AND created_date >= '$first_day_this_month' AND created_date <= '$last_day_this_month'", [], "single", []);

        	$this->data['revenue'] = $orders['total_amount'];
        	$this->data['orders_this_week'] = $orders['total_quantity'];

        	$customers = $this->global_model->get("users", "count(id) as count", "user_type = 'user' AND deleted_by = 0", [], "single", []);
        	$this->data['customers'] = $customers['count'];

			$this->load->view('dashboard/admin-dashboard', $this->data);
		}
		
		$this->load->view('layouts/footer');
	}

	public function salesGraphData(){
		session_write_close();

		$filter = $this->input->post("filter");
    	$final_label = [];
    	$final_data_orders = [];
    	$final_data_revenue = [];

    	if($filter == "yearly"){
    		$start_year = "2020";
    	}
    	else{
    		$start_year = date('Y');
    	}
    	
    	for($year = $start_year; $year <= date('Y'); $year++){
    		if($filter == "weekly"){
    			$total_number_of_week = date("W", strtotime($year."-12-28"));
    			for($week = 0; $week < $total_number_of_week; $week++){
    				//$start_end = getStartAndEndDate($week + 1,$year);
    				//$final_label[] = $start_end['week_start']." to ".$start_end['week_end'];
    				$tmp_week = $week + 1;
    				$orders = $this->global_model->get("views_order_history", "sum(total_quantity) as total_quantity, sum(grand_total) as total_amount", "status = 'PICKED UP' AND deleted_by = 0 AND year = {$year} AND week = {$tmp_week}", [], "single", []);

    				$final_label[] = "Week ".($week + 1)." ".$year;
    				$final_data_orders[] = $orders['total_quantity']? $orders['total_quantity']: "0";
    				$final_data_revenue[] = $orders['total_amount']? $orders['total_amount']: "0";

    			}
    		}
    		else if($filter == "monthly"){
    			for($month = 1; $month <= 12; $month++){
    				$orders = $this->global_model->get("views_order_history", "sum(total_quantity) as total_quantity, sum(grand_total) as total_amount", "status = 'PICKED UP' AND deleted_by = 0 AND year = {$year} AND month = {$month}", [], "single", []);

    				$first_day_month = date('Y-m-01', strtotime($year."-".$month."-01"));
    				$final_label[] = date('M Y',strtotime($first_day_month));
    				$final_data_orders[] = $orders['total_quantity']? $orders['total_quantity']: "0";
    				$final_data_revenue[] = $orders['total_amount']? $orders['total_amount']: "0";
    			}
    		}
    		else if($filter == "yearly"){
    			$orders = $this->global_model->get("views_order_history", "sum(total_quantity) as total_quantity, sum(grand_total) as total_amount", "status = 'PICKED UP' AND deleted_by = 0 AND year = {$year}", [], "single", []);

    			$final_label[] = $year;
    			$final_data_orders[] = $orders['total_quantity']? $orders['total_quantity']: "0";
    			$final_data_revenue[] = $orders['total_amount']? $orders['total_amount']: "0";
    		}
    	}

    	$this->data['final_label'] = $final_label;
    	$this->data['final_data_orders'] = $final_data_orders;
    	$this->data['final_data_revenue'] = $final_data_revenue;

    	session_start();

    	echo json_encode($this->data);
	}

}
