<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_authentic_user();
		$this->load->model('Notification_model','notification');
		$this->load->model('Dashboard_model','dashboard');
		$this->load->model('Common_model','com');
	}

	public function index()
	{

		$query = $this->db->query("SELECT SUM(amount) as count FROM wallet_trans WHERE `type`='CR'
            GROUP BY DATE(created_on) ORDER BY created_on");
        $data['expences'] = json_encode(array_column($query->result(), 'count'),JSON_NUMERIC_CHECK);

        $query = $this->db->query("SELECT SUM(amount) as count FROM wallet_trans WHERE `type`='DR'
		GROUP BY DATE(created_on) ORDER BY created_on");
        $data['income'] = json_encode(array_column($query->result(), 'count'),JSON_NUMERIC_CHECK);

		$query = $this->db->query("SELECT DATE(created_on) as count FROM wallet_trans GROUP BY DATE(created_on) ORDER BY created_on");
        $data['date'] = json_encode(array_column($query->result(), 'count'),JSON_NUMERIC_CHECK);

		//Get Total Number of active users
		$data['users'] = $this->dashboard->getTotalActiveUsers();
		//Get Total Amount of withdraw request
		$data['withdraw_request'] = $this->dashboard->getTotalWithdrawRequest();
		//Get Total Amount of balance request
		$data['balance_request'] = $this->dashboard->getTotalBalanceRequest();
		//Get Total Amount of Wallet
		$data['wallet_balance'] = $this->dashboard->getTotalWalletBalance();
		//Get Total Amount of withdraw approved request for today
		$data['withdrawal_today'] = $this->dashboard->getTotalWithdrawalToday();
		//Get Total Amount of balance request approved today
		$data['deposit_today'] = $this->dashboard->getTotalDepositToday();


		$this->load->view('layout/header');
		$this->load->view('dashboard',$data);
		$this->load->view('layout/footer');
	}

	public function sendNotification(){
		$to = array();
		$title = $this->input->post('title');
		$msg_body = $this->input->post('msg_body');
		$allToken = $this->notification->getAllDeviceToken();
		//echo count($allToken);
		foreach($allToken as $key => $token){
			$result = send_notification($token->token,$title,$msg_body);
			//array_push($to, $token->token);
			if(count($allToken) == $key+1 ){
				$success = true;
			}else{
				$success = false;
			}
		}
		//$result = send_notification($to,$title,$msg_body);
		if($success){
			redirect('dashboard');
		}
	}

	public function sendImportantNotification(){
		$to = array();
		$title = $this->input->post('title');
		$msg_body = $this->input->post('msg_body');
		$allToken = $this->notification->getAllDeviceToken();
		$notification_data = array(
			'title' => $title,
			'body' => $msg_body,
		);
		$this->com->add($notification_data,'tbl_notification');
		//echo count($allToken);
		foreach($allToken as $key => $token){
			$result = send_notification($token->token,$title,$msg_body);

			//array_push($to, $token->token);
			if(count($allToken) == $key+1 ){
				$success = true;
			}else{
				$success = false;
			}
		}
		//$result = send_notification($to,$title,$msg_body);
		if($success){
			redirect('dashboard');
		}
	}


}
