<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function auditTrailPage(){
		$this->data['page_title'] = "Audit Trail";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('audit/audit-trail');
		$this->load->view('layouts/footer');
	}

	public function getAuditTrail(){
		$date_from = $this->input->post('date_from')." 00:00:00";
		$date_to = $this->input->post('date_to')." 23:59:59";

		$audit_trail_list = $this->global_model->get("views_audit_trail", "*", "created_date >= '{$date_from}' AND created_date <= '{$date_to}'", ["column" => "created_date", "type" => "DESC"], "multiple", []);

		foreach ($audit_trail_list as $key => $audit) {
			$audit_trail_list[$key]->{"created_date_text"} = date("F d, Y h:i a", strtotime($audit->created_date));
			$audit_trail_list[$key]->{"name"} = $audit->firstname." ".$audit->lastname;
		}

		$this->data['audit_trail_list'] = $audit_trail_list;
		echo json_encode($this->data);
	}
}