<?php


class Account_model extends CI_Model
{
	public function getActiveAccountList()
	{
		$user_type = $this->session->user['user_type'];

		if ($user_type == 1 || $user_type == 2) {
			$user_id = $this->uri->segment(3);
			$this->db->select('customers.id, customers.cust_code, wallet.amount as wallet_balance, dealer.full_name as dealer_name, distributor.full_name as distributor_name, customers.full_name, customers.mobile')
				->from('customers')
				->join('wallet', 'customers.cust_code = wallet.cust_code', 'left')
				->join('users as dealer', 'dealer.user_id=customers.assigned_by_id', 'left')
				->join('users as distributor', 'distributor.user_id=dealer.assigned_by_id', 'left')
				->where('customers.is_deleted', '0')
				->where('customers.assigned_by_id', $user_id)
				->order_by('customers.id', 'desc');
		} else if ($user_type == 3) { // Distributor
			$this->db->select('customers.id, customers.cust_code, wallet.amount as wallet_balance, dealer.full_name as dealer_name, distributor.full_name as distributor_name, customers.full_name, customers.mobile')
				->from('customers')
				->join('wallet', 'customers.cust_code = wallet.cust_code', 'left')
				->join('users as dealer', 'dealer.user_id=customers.assigned_by_id', 'left')
				->join('users as distributor', 'distributor.user_id=dealer.assigned_by_id', 'left')
				->where('customers.is_deleted', '0')
				->order_by('customers.id', 'desc');
		} else if ($user_type == 4) { // Dealer
			$this->db->select('customers.id, customers.cust_code, wallet.amount as wallet_balance, dealer.full_name as dealer_name, distributor.full_name as distributor_name, customers.full_name, customers.mobile')
				->from('customers')
				->join('wallet', 'customers.cust_code = wallet.cust_code', 'left')
				->join('users as dealer', 'dealer.user_id=customers.assigned_by_id', 'left')
				->join('users as distributor', 'distributor.user_id=dealer.assigned_by_id', 'left')
				->where('customers.is_deleted', '0')
				->where('customers.assigned_by_id', $this->session->user['user_id'])
				->order_by('customers.id', 'desc');
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function getInactiveAccountList()
	{
		$this->db->select('customers.id, customers.cust_code, wallet.amount as wallet_balance, dealer.full_name as dealer_name, distributor.full_name as distributor_name, customers.full_name, customers.mobile')
			->from('customers')
			->join('wallet', 'customers.cust_code = wallet.cust_code', 'left')
			->join('users as dealer', 'dealer.user_id=customers.assigned_by_id', 'left')
			->join('users as distributor', 'distributor.user_id=dealer.assigned_by_id', 'left')
			->where('customers.is_deleted', '1')
			->order_by('customers.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotalUser($acc_status = '0')
	{
		$this->db->select('count(id) as customers')
			->from('customers')
			->where('customers.is_deleted', $acc_status);
		$query = $this->db->get();
		return $query->row();
	}

	public function getTotalAmount($acc_status = '0')
	{
		$this->db->select('SUM(amount) as balance')
			->from('wallet')
			->join('customers', 'customers.cust_code = wallet.cust_code')
			->where('customers.is_deleted', $acc_status);
		$query = $this->db->get();
		return $query->row();
	}

	public function getDetail($mobile)
	{
		$this->db->select('customers.full_name,customers.cust_code as id, wallet.amount as current_amount')
			->from('customers')
			->join('wallet', 'customers.cust_code = wallet.cust_code')
			->where('customers.mobile', $mobile);
		$query = $this->db->get();
		return $query->row();
	}
}
