<?php


class Home_model extends CI_Model
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

	public function getLuckyNumber()
	{
		$this->db->select('g.*, c.cat_name');
		$this->db->join('category as c', 'g.category_id=c.id', 'left');
		$this->db->order_by('g.guessing_date', 'desc');
		$this->db->limit(6);
		$results = $this->db->get('guessing g')->result();
		return $results;
	}

	public function getGame()
	{
		// GROUP_CONCAT(gm.slot_id)
		$this->db->select('gm.*');
		$this->db->join('game as gm', 'c.id=gm.cat_id', 'left');
		$this->db->where_in('gm.name', ['OPEN', 'CLOSE']);
		// $this->db->join('slot as sl', 'gm.slot_id=sl.id', 'left');
		$results = $this->db->get('category c')->result();

		echo "<pre>";
		print_r($results);
		die;
		return $results;
	}
}
