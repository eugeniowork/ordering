<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{

		$this->data['page_title'] = "Home";

		$this->load->view('layouts/header', $this->data);
		$this->load->view('home/home');
		$this->load->view('layouts/footer');
	}
}
