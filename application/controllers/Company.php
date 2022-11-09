<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
	public function terms_and_condition(){
		$this->data['page_title'] = "Terms and Condition";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('company/terms-and-condition');
		$this->load->view('layouts/footer');
	}

	public function about_us(){
		$this->data['page_title'] = "About Us";

		$this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/header_buttons');
		$this->load->view('company/about-us');
		$this->load->view('layouts/footer');
	}
}
