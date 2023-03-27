<?php


class Money_model extends CI_Model
{
	public function getTransDetails($trans_type,$start_date,$end_date){
		$this->db->select('customers.full_name,customers.mobile,wallet_trans.*')
			->from('wallet_trans')
			->join('customers','customers.cust_code = wallet_trans.cust_code')
			->where('wallet_trans.type',$trans_type)
			->where("wallet_trans.created_on >= '".$end_date."'")
			->where("wallet_trans.created_on <= '".$start_date."'")
			->order_by('wallet_trans.id', 'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	public function getCurrentWalletAmount($cust_code){
		$query = $this->db
			->select('amount')
			->where(['cust_code' => $cust_code])
			->get('wallet');

		$result = $query->row();
		return !empty($result) ? $result->amount : 0;
	}
}