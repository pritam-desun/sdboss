<?php


class Dashboard_model extends CI_Model
{
	public function getAllDeviceToken()
	{
		$this->db->select('token')
			->from('device_token');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotalActiveUsers()
	{
		$user_id =  NULL;
		if ($this->session->user['user_type'] == 3) {
			$user_id = array_column($this->db->get_where('users', ['assigned_by_id' => $this->session->user['user_id']])->result(), 'user_id');
			/* $this->db->select('cust_code');
			$this->db->where_in('customers.assigned_by_id', $user_id);
			$cust_code = array_column($this->db->get('customers')->result(), 'cust_code'); */
			/* echo "<pre>";
			print_r($user_id);
			die; */
		}
		$this->db->select('COALESCE(COUNT(id),0) as total_user');
		$this->db->from('customers');
		if ($this->session->user['user_type'] == 1) {
			$this->db->where(['is_active' => '1', 'is_deleted' => '0']);
		} elseif ($this->session->user['user_type'] == 3) {
			$this->db->where(['is_active' => '1', 'is_deleted' => '0']);
			if (empty($user_id)) {
				$this->db->where('assigned_by_id IS NULL');
			} else {
				$this->db->where_in('assigned_by_id', $user_id);
			}
		} elseif ($this->session->user['user_type'] == 4) {
			$this->db->where(['is_active' => '1', 'is_deleted' => '0', 'assigned_by_id' => $this->session->user['user_id']]);
		}

		$query = $this->db->get();
		/* echo $this->db->last_query();
		exit; */
		return $query->row();
	}

	public function getTotalWithdrawRequest()
	{
		$this->db->select('SUM(amount) as total_amount')
			->from('withdraw_money')
			->join('customers', 'customers.cust_code = withdraw_money.cust_code', 'left')
			->where('customers.is_active', '1')
			->where('customers.is_deleted', '0')
			->where('withdraw_money.status', 'p');
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		return $query->row();
	}

	public function getTotalWithdrawalToday()
	{
		$this->db->select('SUM(amount) as total_amount')
			->from('withdraw_money')
			->join('customers', 'customers.cust_code = withdraw_money.cust_code', 'left')
			->where('customers.is_active', '1')
			->where('customers.is_deleted', '0')
			->where('withdraw_money.status', 'S')
			->where('withdraw_money.approved_on', date('Y-m-d'));
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		return $query->row();
	}

	public function getTotalBalanceRequest()
	{
		$this->db->select('SUM(amount) as total_amount')
			->from('add_money')
			->join('customers', 'customers.cust_code = add_money.cust_code', 'left')
			->where('customers.is_active', '1')
			->where('customers.is_deleted', '0')
			->where('add_money.status', 'P');
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		return $query->row();
	}

	public function getTotalDepositToday()
	{
		$this->db->select('SUM(amount) as total_amount')
			->from('add_money')
			->join('customers', 'customers.cust_code = add_money.cust_code', 'left')
			->where('customers.is_active', '1')
			->where('customers.is_deleted', '0')
			->where('add_money.status', 'S')
			->where('add_money.approved_on', date('Y-m-d'));
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		return $query->row();
	}

	public function getTotalWalletBalance()
	{
		$cust_code = '';
		if ($this->session->user['user_type'] == 3) {
			$user_id = array_column($this->db->get_where('users', ['assigned_by_id' => $this->session->user['user_id']])->result(), 'user_id');
			if (empty($user_id)) {

				$cust_code = false;
			} else {
				$this->db->select('cust_code');
				$this->db->where_in('customers.assigned_by_id', $user_id);
				$cust_code = array_column($this->db->get('customers')->result(), 'cust_code');
			}
		} elseif ($this->session->user['user_type'] == 4) {
			$this->db->select('cust_code');
			$cust_code = array_column($this->db->get_where('customers', ['assigned_by_id' => $this->session->user['user_id']])->result(), 'cust_code');
		}

		$this->db->select('COALESCE(SUM(amount),0) as total_amount');
		$this->db->from('wallet');
		$this->db->join('customers', 'customers.cust_code = wallet.cust_code', 'left');
		$this->db->where('customers.is_active', '1');
		if ($this->session->user['user_type'] == 3) {
			if ($cust_code) {
				$this->db->where_in('customers.cust_code', $cust_code);
			} else {
				$this->db->where_in('customers.cust_code', ['0']);
			}
		} elseif ($this->session->user['user_type'] == 4) {
			if ($cust_code) {
				$this->db->where_in('customers.cust_code', $cust_code);
			} else {
				$this->db->where_in('customers.cust_code', ['0']);
			}
		}
		$this->db->where('customers.is_deleted', '0');
		$query = $this->db->get();
		/* echo $this->db->last_query();
		exit; */
		return $query->row();
	}

	public function getTotalDealer()
	{
		if ($this->session->user['user_type'] == 3) {
			$this->db->where('users.assigned_by_id', $this->session->user['user_id']);
		}

		return $this->db->get('users')->num_rows();
	}
}
