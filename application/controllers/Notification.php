<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
            redirect('login');
        }

		$this->load->model('global_model');

		$this->load->helper('date_helper');
		$this->load->helper('encryption_helper');
	}

	public function totalUnreadNotifications(){
		//CREATE OR REPLACE VIEW views_notifications AS SELECT notifications.*, CONCAT(users.firstname," ",users.lastname) AS customer_name, users.profile_path AS customer_profile_path FROM `notifications` LEFT JOIN users ON notifications.user_id = users.id
		session_write_close();

		$user_id = $this->session->userdata('user_id');

		//GET NOTIFICATIONS
        $notifications = $this->global_model->get("views_notifications", "count(id) as count", "receiver = '$user_id' AND read_status = 0", [], "single", []);
        $this->data['notifications'] = $notifications['count'];

		session_start();

		echo json_encode($this->data);
	}

	public function getNotifications(){
		session_write_close();

		$user_id = $this->session->userdata('user_id');
		//GET NOTIFICATIONS
        $notifications = $this->global_model->get("views_notifications", "*", "receiver = '$user_id'", ["column" => "created_date", "type" => "DESC"], "multiple", []);
        foreach ($notifications as $key => $notification) {
        	$notifications[$key]->{"created_date"} = date('M d, Y H:i a', strtotime($notification->created_date));
        	$notifications[$key]->{"content"} = str_replace("#customer_name", "<strong>".$notification->customer_name."</strong>", $notification->content);
        	$notifications[$key]->{"customer_profile_path"} = base_url().$notification->customer_profile_path;
        }

        $this->data['notifications'] = $notifications;

		session_start();

		echo json_encode($this->data);
	}

	public function readNotifications(){
		session_write_close();

		$user_id = $this->session->userdata('user_id');

        $update_data = [
            "read_status"=> 1,
        ];
        $this->global_model->update("notifications", "receiver = '$user_id' AND read_status = 0", $update_data);

        $this->data['is_error'] = false;

		session_start();

		echo json_encode($this->data);
	}

}