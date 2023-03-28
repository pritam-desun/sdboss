<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_authentic_user();
		$this->load->model('Notification_model', 'notification');
		$this->load->model('Dashboard_model', 'dashboard');
		$this->load->model('Common_model', 'com');
	}

	public function index()
	{
		$query = $this->db->query("SELECT SUM(amount) as count FROM wallet_trans WHERE `type`='CR'
            GROUP BY DATE(created_on) ORDER BY created_on");
		$data['expences'] = json_encode(array_column($query->result(), 'count'), JSON_NUMERIC_CHECK);

		$query = $this->db->query("SELECT SUM(amount) as count FROM wallet_trans WHERE `type`='DR'
		GROUP BY DATE(created_on) ORDER BY created_on");
		$data['income'] = json_encode(array_column($query->result(), 'count'), JSON_NUMERIC_CHECK);

		$query = $this->db->query("SELECT DATE(created_on) as count FROM wallet_trans GROUP BY DATE(created_on) ORDER BY created_on");
		$data['date'] = json_encode(array_column($query->result(), 'count'), JSON_NUMERIC_CHECK);



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
		//Get Total Dealer
		$data['total_dealer'] = $this->dashboard->getTotalDealer();

		/* echo "<pre>";
		print_r($data['total_dealer']);
		die; */


		/* For New code */
		if ($this->session->user['user_type'] == 1) {

			/* Total Dealer Distributor */
			$data['total_distributor'] = $this->db->get_where('users', array('user_type' => 3))->num_rows();
			$data['total_dealer'] = $this->db->get_where('users', array('user_type' => 4))->num_rows();
			/* ----------------------- */

			$this->db->select(
				'
			customers.full_name as counter_name, 
			dealer.full_name as dealer_name, 
			distributor.full_name as distributor_name, 
			wallet.amount as wallet, 
			SUM(bidding.amount) AS bidding_amount,
			DATE_FORMAT(bidding.bid_on, "%d-%m-%Y-%h:%i%p") as bid_on,
			customers.mobile as counter_mobile_no, 
			SUM(CASE WHEN `bidding`.`status` = "L" THEN "0 " ELSE `wallet_trans`.`amount`END) AS win_amount',
				FALSE
			);
			$this->db->where('DATE(bidding.bid_on)', date('Y-m-d'));
			$this->db->where('wallet_trans.purpose', 'Winning Price');
			$this->db->where_in('bidding.status', ['W', 'L']);
			$this->db->join('customers', 'customers.cust_code=bidding.cust_code', 'left');
			$this->db->join('wallet_trans', 'bidding.cust_code=wallet_trans.cust_code', 'left');
			$this->db->join('wallet', 'customers.cust_code=wallet.cust_code', 'left');
			$this->db->join('users as dealer', 'customers.assigned_by_id=dealer.user_id', 'left');
			$this->db->join('users as distributor', 'dealer.assigned_by_id=distributor.user_id', 'left');
			//$this->db->group_by('bidding.id');
			$data['online_counter_results'] = $this->db->get('bidding')->result();

			/* echo $this->db->last_query();
			die; */
			/* echo "<pre>";
        print_r(array_merge($data['win'], $data['loss']));
        die; */
			// $data['results'] = array_merge($data['win'], $data['loss']);
			/* echo "<pre>";
			print_r($data['online_counter_results']);
			die; */
		} elseif ($this->session->user['user_type'] == 3) {
			$this->db->select(
				'
			customers.full_name as counter_name, 
			dealer.full_name as dealer_name, 
			distributor.full_name as distributor_name, 
			wallet.amount as wallet, 
			SUM(bidding.amount) AS bidding_amount,
			DATE_FORMAT(bidding.bid_on, "%d-%m-%Y-%h:%i%p") as bid_on,
			customers.mobile as counter_mobile_no, 
			SUM(CASE WHEN `bidding`.`status` = "L" THEN "0 " ELSE `wallet_trans`.`amount`END) AS win_amount',
				FALSE
			);
			$this->db->where('DATE(bidding.bid_on)', date('Y-m-d'));
			$this->db->where('wallet_trans.purpose', 'Winning Price');
			$this->db->where_in('bidding.status', ['W', 'L']);
			$this->db->where('customers.assigned_by_id', $this->session->user['user_id']);
			$this->db->join('customers', 'customers.cust_code=bidding.cust_code', 'left');
			$this->db->join('wallet_trans', 'bidding.cust_code=wallet_trans.cust_code', 'left');
			$this->db->join('wallet', 'customers.cust_code=wallet.cust_code', 'left');
			$this->db->join('users as dealer', 'customers.assigned_by_id=dealer.user_id', 'left');
			$this->db->join('users as distributor', 'dealer.assigned_by_id=distributor.user_id', 'left');
			//$this->db->group_by('bidding.id');
			$data['online_counter_results'] = $this->db->get('bidding')->result();
		} elseif ($this->session->user['user_type'] == 4) {
			$this->db->select(
				'
			customers.full_name as counter_name, 
			dealer.full_name as dealer_name, 
			distributor.full_name as distributor_name, 
			wallet.amount as wallet, 
			SUM(bidding.amount) AS bidding_amount,
			DATE_FORMAT(bidding.bid_on, "%d-%m-%Y-%h:%i%p") as bid_on,
			customers.mobile as counter_mobile_no, 
			SUM(CASE WHEN `bidding`.`status` = "L" THEN "0 " ELSE `wallet_trans`.`amount`END) AS win_amount',
				FALSE
			);
			$this->db->where('DATE(bidding.bid_on)', date('Y-m-d'));
			$this->db->where('wallet_trans.purpose', 'Winning Price');
			$this->db->where_in('bidding.status', ['W', 'L']);
			$this->db->where('customers.assigned_by_id', $this->session->user['user_id']);
			$this->db->join('customers', 'customers.cust_code=bidding.cust_code', 'left');
			$this->db->join('wallet_trans', 'bidding.cust_code=wallet_trans.cust_code', 'left');
			$this->db->join('wallet', 'customers.cust_code=wallet.cust_code', 'left');
			$this->db->join('users as dealer', 'customers.assigned_by_id=dealer.user_id', 'left');
			$this->db->join('users as distributor', 'dealer.assigned_by_id=distributor.user_id', 'left');
			//$this->db->group_by('bidding.id');
			$data['online_counter_results'] = $this->db->get('bidding')->result();

			/* echo "<pre>";
			print_r($data['online_counter_results']);
			die; */
		}

		/* ---------------------------- */

		$this->load->view('layout/header');
		$this->load->view('dashboard', $data);
		$this->load->view('layout/footer');
	}

	public function sendNotification()
	{
		$to = array();
		$title = $this->input->post('title');
		$msg_body = $this->input->post('msg_body');
		$allToken = $this->notification->getAllDeviceToken();
		//echo count($allToken);
		foreach ($allToken as $key => $token) {
			$result = send_notification($token->token, $title, $msg_body);
			//array_push($to, $token->token);
			if (count($allToken) == $key + 1) {
				$success = true;
			} else {
				$success = false;
			}
		}
		//$result = send_notification($to,$title,$msg_body);
		if ($success) {
			redirect('dashboard');
		}
	}

	public function sendImportantNotification()
	{
		$to = array();
		$title = $this->input->post('title');
		$msg_body = $this->input->post('msg_body');
		$allToken = $this->notification->getAllDeviceToken();
		$notification_data = array(
			'title' => $title,
			'body' => $msg_body,
		);
		$this->com->add($notification_data, 'tbl_notification');
		//echo count($allToken);
		foreach ($allToken as $key => $token) {
			$result = send_notification($token->token, $title, $msg_body);

			//array_push($to, $token->token);
			if (count($allToken) == $key + 1) {
				$success = true;
			} else {
				$success = false;
			}
		}
		//$result = send_notification($to,$title,$msg_body);
		if ($success) {
			redirect('dashboard');
		}
	}
}
