<?php


class Approve extends CI_Controller
{
	function __construct() {
		parent::__construct();
		check_authentic_user();
		$this->load->model('Approve_model','approve');
		$this->load->model('Money_model','money');
		$this->load->model('wallet');
	}

	public function transfer(){
		$data['pay_types'] = $this->config->item('pay_type');
		$data['requests'] = $this->approve->getTransferRequest('add_money');
		$this->load->view('layout/header');
		$this->load->view('approve/transferList',$data);
		$this->load->view('layout/footer');
	}

	public function withdraw(){
		$data['pay_types'] = $this->config->item('pay_type');
		$data['requests'] = $this->approve->getTransferRequest('withdraw_money');

		$this->load->view('layout/header');
		$this->load->view('approve/withdrawList',$data);
		$this->load->view('layout/footer');
	}

	public function moneyTransfer($id, $cust_code){

		## Get request details
		$request_data = $this->approve->getTransferRequest('add_money', $id);
		$requested_amount = $request_data->amount;

		if (intval($requested_amount) > 0) {
			## Approve deposit request
			$affected_rows = $this->approve->approve_deposit_request($id);

			if ($affected_rows > 0) {
				## Update Wallet Balance
				$this->wallet->add_balance($cust_code, $requested_amount);

				## Add Transaction
				$txn_data = array(
					'cust_code' => $cust_code,
					'amount' => $requested_amount,
					'purpose' => 'Deposit Balance',
					'type' => 'CR',
				);
				$this->wallet->add_transaction($txn_data);

				$this->session->set_flashdata('msg', 'Transfered successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('approve/transfer');
			}
			else {
				$this->session->set_flashdata('msg', 'Failed to transfer');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('approve/transfer');
			}
		}
		else {
			$this->session->set_flashdata('msg', 'Invalid amount');
			$this->session->set_flashdata('msg_class', 'danger');
			redirect('approve/transfer');
		}
	}

	public function reject($id,$cust_code){
		$data_transfer = array(
			'id' => $id,
			'status' => 'F',
			'approved_by' => get_user(),
			'approved_on' => date('Y-m-d H:i:s')
		);
		$data_transfer_condition = array(
			'id' => $id
		);
		$update_transfer = $this->com->add($data_transfer,'add_money',$data_transfer_condition);

		if($update_transfer){
			$this->session->set_flashdata('msg', 'Canceled successfully');
			$this->session->set_flashdata('msg_class', 'success');
			redirect('approve/transfer');
		}else{
			$this->session->set_flashdata('msg', 'Failed to cancel');
			$this->session->set_flashdata('msg_class', 'danger');
			redirect('approve/transfer');
		}
	}

	public function rejectw($id,$cust_code){
		$data_transfer = array(
			'id' => $id,
			'status' => 'F',
			'approved_by' => get_user(),
			'approved_on' => date('Y-m-d H:i:s')
		);
		$data_transfer_condition = array(
			'id' => $id
		);
		$update_transfer = $this->com->add($data_transfer,'withdraw_money',$data_transfer_condition);

		if($update_transfer){
			$this->session->set_flashdata('msg', 'Canceled successfully');
			$this->session->set_flashdata('msg_class', 'success');
			redirect('approve/withdraw');
		}else{
			$this->session->set_flashdata('msg', 'Failed to cancel');
			$this->session->set_flashdata('msg_class', 'danger');
			redirect('approve/withdraw');
		}
	}

	public function moneyWihdraw($id, $cust_code){
		## Get Request details
		$requested_data = $this->approve->getTransferRequest('withdraw_money', $id);
		$requested_amount = $requested_data->amount;
		$trans_code = get_transaction_code();

		## Deduct balance from wallet
		$status = $this->wallet->deduct_balance($cust_code, $requested_amount);
		if ($status) {
			## Update withdraw request
			$this->approve->approve_withdraw_request($id, $trans_code);

			## Add Transaction
			$txn_data = array(
				'cust_code' => $cust_code,
				'trans_code' => $trans_code,
				'amount' => $requested_amount,
				'purpose' => 'Withdraw Balance',
				'type' => 'DR',
			);
			$this->wallet->add_transaction($txn_data);

			$this->session->set_flashdata('msg', 'Request Approved successfully');
			$this->session->set_flashdata('msg_class', 'success');
			redirect('approve/withdraw');
		}
		else {
			$this->session->set_flashdata('msg', 'Insufficient wallet balance');
			$this->session->set_flashdata('msg_class', 'danger');
			redirect('approve/withdraw');
		}
	}



}
