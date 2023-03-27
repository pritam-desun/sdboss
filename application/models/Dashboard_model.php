<?php


class Dashboard_model extends CI_Model
{
		public function getAllDeviceToken(){
			$this->db->select('token')
				->from('device_token');
			$query = $this->db->get();
			return $query->result();
		}

		public function getTotalActiveUsers(){
			$this->db->select('COUNT(id) as total_user')
				->from('customers')
				->where(['is_active' => '1', 'is_deleted' => '0']);
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			return $query->row();
		}

		public function getTotalWithdrawRequest(){
			$this->db->select('SUM(amount) as total_amount')
				->from('withdraw_money')
				->join('customers','customers.cust_code = withdraw_money.cust_code','left')
				->where('customers.is_active','1')
				->where('customers.is_deleted','0')
				->where('withdraw_money.status','p');
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			return $query->row();
		}

		public function getTotalWithdrawalToday(){
			$this->db->select('SUM(amount) as total_amount')
				->from('withdraw_money')
				->join('customers','customers.cust_code = withdraw_money.cust_code','left')
				->where('customers.is_active','1')
				->where('customers.is_deleted','0')
				->where('withdraw_money.status','S')
				->where('withdraw_money.approved_on',date('Y-m-d'));
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			return $query->row();
		}

		public function getTotalBalanceRequest(){
			$this->db->select('SUM(amount) as total_amount')
				->from('add_money')
				->join('customers','customers.cust_code = add_money.cust_code','left')
				->where('customers.is_active','1')
				->where('customers.is_deleted','0')
				->where('add_money.status','P');
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			return $query->row();
		}

		public function getTotalDepositToday(){
			$this->db->select('SUM(amount) as total_amount')
				->from('add_money')
				->join('customers','customers.cust_code = add_money.cust_code','left')
				->where('customers.is_active','1')
				->where('customers.is_deleted','0')
				->where('add_money.status','S')
				->where('add_money.approved_on',date('Y-m-d'));
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			return $query->row();
		}

		public function getTotalWalletBalance(){
			$this->db->select('SUM(amount) as total_amount')
				->from('wallet')
				->join('customers','customers.cust_code = wallet.cust_code','left')
				->where('customers.is_active','1')
				->where('customers.is_deleted','0');
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			return $query->row();
		}
}
