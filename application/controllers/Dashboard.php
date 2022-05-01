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

			$this->load->view('dashboard/admin-dashboard', $this->data);
		}
		
		$this->load->view('layouts/footer');
	}

}
