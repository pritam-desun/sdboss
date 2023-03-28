<?php
class Money extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		check_authentic_user();
		$this->load->model('Money_model', 'money');
		$this->load->model('wallet');
	}

	function addition()
	{
		$this->form_validation->set_rules('amount', 'Money', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('layout/header');
			$this->load->view('money/addition');
			$this->load->view('layout/footer');
		} else {
			$trans_code = 'TRANS' . time();
			$customer_id = $this->input->post('customer_id', TRUE);
			$amount = $this->input->post('amount', TRUE);

			## Update Wallet
			$this->wallet->add_balance($customer_id, $amount);

			## Add Transaction
			$txn_data = array(
				'cust_code' => $customer_id,
				'trans_code' => $trans_code,
				'amount' => $amount,
				'purpose' => 'Add Balance',
				'type' => 'CR',
				'source_type' => 'a',
			);
			$this->wallet->add_transaction($txn_data);

			$this->session->set_flashdata('msg', 'Money added successfully');
			$this->session->set_flashdata('msg_class', 'success');
			redirect('money/addition');
		}
	}

	function sendmoneydistributor()
	{
		/* For Super Admin */
		if ($this->session->user['user_type'] == 1) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$amount = $this->input->post('amount');
				$user_id = $this->input->post('user_id');
				$user_type = $this->input->post('user_type');
				$wallet_balance = $this->input->post('wallet_balance');
				$wallet_balance = $this->db->get_where('users', array('user_id' => $user_id))->row()->wallet;
				$this->db->trans_start();
				$this->db->update('users', ['wallet' => ($amount + $wallet_balance)], ['user_id' => $user_id]);
				$data['user_id'] = $user_id;
				$data['user_type'] = $user_type;
				$data['amount'] = $amount;
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->session->user['id'];
				$this->db->insert('distributor_dealer_wallet', $data);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('msg', 'Money not added');
					$this->session->set_flashdata('msg_class', 'error');
				} else {
					$this->session->set_flashdata('msg', 'Money added successfully');
					$this->session->set_flashdata('msg_class', 'success');
				}
				redirect('money/sendmoneydistributor');
			}
			$this->load->view('layout/header');
			$this->load->view('money/sendmoneydistributor');
			$this->load->view('layout/footer');
		}
		/* -------------- */

		/* For Distributor */
		if ($this->session->user['user_type'] == 3) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$amount = $this->input->post('amount');
				$user_id = $this->input->post('user_id');
				$user_type = $this->input->post('user_type');
				$wallet_balance = $this->input->post('wallet_balance');

				$distributor_id = $this->session->user['user_id'];

				/* For Checking balance in wallet */
				$distributor_wallet_balance = $this->db->get_where('users', array('user_id' => $distributor_id))->row()->wallet;
				/* ------------------------------ */
				if ($distributor_wallet_balance >= $amount) {
					$distributor_amount = ($distributor_wallet_balance - $amount);
					$dealer_wallet_balance = $this->db->get_where('users', array('user_id' => $user_id))->row()->wallet;

					$this->db->trans_start();
					$this->db->update('users', ['wallet' => $distributor_amount], ['user_id' => $distributor_id]);
					$this->db->update('users', ['wallet' => ($amount + $dealer_wallet_balance)], ['user_id' => $user_id]);
					$this->db->select('MAX(id) + 1 as AUTO_INCREMENT');
					$distributor_auto_id = $this->db->get('distributor_dealer_wallet')->row()->AUTO_INCREMENT;
					/* Distributor Wallet Trns */
					$data['user_id'] = $this->session->user['user_id'];
					$data['user_type'] = $this->session->user['user_type'];
					$data['amount'] = $distributor_amount;
					$data['trans_code'] = "TRANS" . str_pad($distributor_auto_id, 4, "0");
					$data['trans_type'] = "DR";
					$data['created_at'] = date('Y-m-d H:i:s');
					$data['created_by'] = $this->session->user['user_id'];

					$this->db->insert('distributor_dealer_wallet', $data);
					/* ----------------------- */

					/* Dealer Wallet trans */
					$dealer_auto_id = $this->db->insert_id() + 1;
					$data['user_id'] = $user_id;
					$data['user_type'] = $user_type;
					$data['amount'] = $amount + $dealer_wallet_balance;
					$data['trans_code'] = "TRANS" . str_pad($dealer_auto_id, 4, "0");
					$data['trans_type'] = "CR";
					$data['created_at'] = date('Y-m-d H:i:s');
					$data['created_by'] = $this->session->user['user_id'];

					$this->db->insert('distributor_dealer_wallet', $data);
					/* ------------------- */
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$this->session->set_flashdata('msg', 'Money not added');
						$this->session->set_flashdata('msg_class', 'error');
						redirect('money/sendmoneydistributor');
					}
					$this->session->set_flashdata('msg', 'Money added successfully in dealer wallet');
					$this->session->set_flashdata('msg_class', 'success');
					redirect('money/sendmoneydistributor');
				} else {
					$this->session->set_flashdata('msg', 'insufficient balence ..');
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('money/sendmoneydistributor');
				}
			}
			$this->load->view('layout/header');
			$this->load->view('money/sendmoneydistributor');
			$this->load->view('layout/footer');
		}
		/* -------------- */

		/* For Dealer */
		if ($this->session->user['user_type'] == 4) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$amount = $this->input->post('amount');
				$user_id = $this->input->post('counter_id');
				$user_type = $this->input->post('user_type');
				$wallet_balance = $this->input->post('wallet_balance');

				$dealer_id = $this->session->user['user_id'];

				/* For Checking balance in wallet */
				$dealer_wallet_balance = $this->db->get_where('users', array('user_id' => $dealer_id))->row()->wallet;
				/* ------------------------------ */
				if ($dealer_wallet_balance >= $amount) {
					$dealer_amount = ($dealer_wallet_balance - $amount);
					$counter_code = $this->db->get_where('customers', array('id' => $user_id))->row()->cust_code;
					$counter_wallet_balance = $this->db->get_where('wallet', array('cust_code' => $counter_code))->row()->amount;

					$this->db->trans_start();
					$this->db->update('users', ['wallet' => $dealer_amount], ['user_id' => $dealer_id]);
					$this->db->update('wallet', ['amount' => ($amount + $counter_wallet_balance)], ['cust_code' => $counter_code]);
					$this->db->select('MAX(id) + 1 as AUTO_INCREMENT');
					$dealer_auto_id = $this->db->get('distributor_dealer_wallet')->row()->AUTO_INCREMENT;
					/* dealer Wallet Trns */
					$data['user_id'] = $this->session->user['user_id'];
					$data['user_type'] = $this->session->user['user_type'];
					$data['amount'] = $dealer_amount;
					$data['trans_code'] = "TRANS" . str_pad($dealer_auto_id, 4, "0");
					$data['trans_type'] = "DR";
					$data['created_at'] = date('Y-m-d H:i:s');
					$data['created_by'] = $this->session->user['user_id'];

					$this->db->insert('distributor_dealer_wallet', $data);
					/* ----------------------- */

					/* coutomer Wallet trans */
					$this->db->select('MAX(id) + 1 as AUTO_INCREMENT');
					$cust_auto_id = $this->db->get('wallet_trans')->row()->AUTO_INCREMENT;
					$data1['cust_code'] = $counter_code;
					$data1['trans_code'] = "TRANS" . str_pad($cust_auto_id, 4, "0", STR_PAD_LEFT);
					$data1['amount'] = $amount + $counter_wallet_balance;
					$data1['purpose'] = "Credit from dealer";
					$data1['type'] = 'CR';
					$data1['source_type'] = 'w';
					$data1['created_on'] = date('Y-m-d H:i:s');
					$this->db->insert('wallet_trans', $data1);
					/* ------------------- */
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$this->session->set_flashdata('msg', 'isufficient balance !!');
						$this->session->set_flashdata('msg_class', 'danger');
						redirect('money/sendmoneydistributor');
					}
					$this->session->set_flashdata('msg', 'Money added successfully in counter wallet');
					$this->session->set_flashdata('msg_class', 'success');
					redirect('money/sendmoneydistributor');
				} else {
					$this->session->set_flashdata('msg', 'insufficient balence ..');
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('money/sendmoneydistributor');
				}
			}
			$data['counters'] = $this->db->get_where('customers', ['assigned_by_id' => $this->session->user['user_id']])->result();
			$this->load->view('layout/header');
			$this->load->view('money/sendmoneydistributor', $data);
			$this->load->view('layout/footer');
		}
		/* --------- */
	}
	function deduction()
	{
		$this->form_validation->set_rules('amount', 'Money', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('layout/header');
			$this->load->view('money/deduction');
			$this->load->view('layout/footer');
		} else {
			$trans_code = 'TRANS' . time();
			$customer_id = $this->input->post('customer_id', TRUE);
			$amount = $this->input->post('amount', TRUE);

			## Deduct Balance
			$status = $this->wallet->deduct_balance($customer_id, $amount);
			if ($status) {
				## Add Transaction
				$txn_data = array(
					'cust_code' => $customer_id,
					'trans_code' => $trans_code,
					'amount' => $amount,
					'purpose' => 'Deduct Balance',
					'type' => 'DR',
					'source_type' => 'a'
				);
				$this->wallet->add_transaction($txn_data);

				$this->session->set_flashdata('msg', 'Money deducted successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('money/deduction');
			} else {
				$this->session->set_flashdata('msg', 'Insufficient wallet balance');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('money/deduction');
			}
		}
	}

	public function details($type)
	{
		if ($type == 'a') {
			$trans_type = 'CR';
			$data['type'] = "Addition";
		} else {
			$trans_type = 'DR';
			$data['type'] = "Deduction";
		}
		$today_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
		$ten_days_prev_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -5 day'));
		$data['transactions'] = $this->money->getTransDetails($trans_type, $today_date, $ten_days_prev_date);
		$this->load->view('layout/header');
		$this->load->view('money/details', $data);
		$this->load->view('layout/footer');
	}
	public function get_dr()
	{
		$data = [];
		$tblrow = array();
		$data['data'] = [];
		$lists = $this->money->getTransDetails('DR');
		foreach ($lists as $list) {
			$tblrow['full_name']      = $list->full_name == '' ? 'N/A' : $list->full_name;
			$tblrow['mobile']       = $list->mobile == '' ? 'N/A' : $list->mobile;
			$tblrow['amount']       = $list->amount == '' ? 'N/A' : $list->amount;
			$tblrow['created_on']       = date_format(date_create($list->created_on), "d-m-Y");
			array_push($data['data'], $tblrow);
		}
		echo json_encode($data);
	}

	public function getUserListByType()
	{
		$user_type = $this->input->post('user_type');

		if ($this->session->user['user_type'] == 3) {
			$this->db->where('users.assigned_by_id', $this->session->user['user_id']);
		}
		$results = $this->db->get_where('users', array('user_type' => $user_type))->result();
		$html = '';
		if (@count($results) > 0) {
			$html .= '<option value="">Choose...</option>';
			foreach ($results as $key => $result) {
				$html .= '<option value="' . $result->user_id . '">' . $result->full_name . ' (' . $result->phone_no . ')</option>';
			}
		} else {
			$html = '<option> No users Found</option>';
		}

		echo $html;
	}

	public function getUserWalletBalance()
	{
		$user_id = $this->input->post('user_id');
		$this->db->select('wallet');
		$wallet_balance = $this->db->get_where('users', array('user_id' => $user_id))->row();

		echo !empty($wallet_balance) ? $wallet_balance->wallet : '0.00';
	}

	public function getCounterWalletBalance()
	{
		$counter_id = $this->input->post('counter_id');
		$customer = $this->db->get_where('customers', array('id' => $counter_id))->row();
		$wallet_balance = $this->db->get_where('wallet', array('cust_code' => $customer->cust_code))->row();

		echo !empty($wallet_balance) ? $wallet_balance->amount : '0.00';
	}
}
