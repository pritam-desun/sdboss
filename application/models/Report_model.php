<?php


class Report_model extends CI_Model
{
	public function getCategory($cat_id = ''){
		$this->db->select('id,label')
			->from('category')
			->where(['status' => 'Y']);
		if($cat_id != ''){
			$this->db->where('id',$cat_id);
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function getGame($cat_id){
		$this->db->select('id,name,gcode')
			->from('game')
			->where(['status' => 'Y', 'cat_id' => $cat_id]);
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotalBidingAmount($game_code, $from_date = '', $to_date = ''){
		$this->db->select('SUM(amount) as total_bid, type');
		$this->db->from('bidding');
		$this->db->where('game_code',$game_code);

		if($from_date != '' && $to_date != ''){
			$this->db->where('DATE(bid_on) >=',$from_date);
			$this->db->where('DATE(bid_on) <=',$to_date);
		}

		$this->db->group_by('type');
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	
	public function getTotalAmount($game_code, $from_date = '', $to_date = '',$cust_code){
		$this->db->select('SUM(amount) as total_bid');
		$this->db->from('bidding');
		$this->db->where_in('game_code',$game_code);
		$this->db->where('cust_code',$cust_code);

		if($from_date != '' && $to_date != ''){
			$this->db->where('DATE(bid_on) >=',$from_date);
			$this->db->where('DATE(bid_on) <=',$to_date);
		}
		$query = $this->db->get();
		return $query->row();
	}

	public function getSumOfWinAmount($game_code, $from_date = '', $to_date = ''){
		$this->db->select('SUM(amount) as total_win, type');
		$this->db->from('bidding');
		$this->db->where('game_code',$game_code);
		$this->db->where('status','W');

		if($from_date != '' && $to_date != ''){
			$this->db->where('DATE(bid_on) >=',$from_date);
			$this->db->where('DATE(bid_on) <=',$to_date);
		}

		$this->db->group_by('type');
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}


	public function getWiningPrice($cat_id){
		$this->db->select('game_type,type,value')
				 ->from('wining_price')
				 ->where(['cat_id' => $cat_id]);
		$query = $this->db->get();
		return $query->result();
	}

	public function getWalletTransactions($mobile, $from_date, $to_date){
		$this->db->select('wallet_trans.amount,wallet_trans.purpose,wallet_trans.type,wallet_trans.created_on');
		$this->db->from("wallet_trans");
		$this->db->join('customers','customers.cust_code = wallet_trans.cust_code','left');
		$this->db->where('customers.mobile',$mobile);
		$this->db->where('DATE(wallet_trans.created_on) >=',$from_date);
		$this->db->where('DATE(wallet_trans.created_on) <=',$to_date);
		$query = $this->db->get();
		return $query->result();
	}	
	
	public function getCustomers(){
		$this->db->select('cust_code,full_name,mobile')
				 ->from('customers')
				 ->where(['is_active' => '1', 'is_deleted' => '0']);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCommision(){
		$this->db->select('commision')
				 ->from('settings');
		$query = $this->db->get();
		return $query->row_array();
	}

}