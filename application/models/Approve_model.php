<?php
class Approve_model extends CI_Model {

	public function __construct () {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
    }

	public function getTransferRequest($table_name, $id = ''){
		$start_date = date('Y-m-d', strtotime(date('Y-m-d') .' +1 day'));
		$end_date = date('Y-m-d', strtotime(date('Y-m-d') .' -5 day'));
		if($id != ''){
			$this->db->where("$table_name.id",$id);
		}
			$this->db->select("customers.full_name,customers.mobile,$table_name.*")
				->from("$table_name")
				->join('customers',"$table_name.cust_code = customers.cust_code")
				->order_by("$table_name.id", "desc")
				->where("$table_name.status !=", 'F')
				->where("$table_name.requested_on >= '".$end_date."'")
				->where("$table_name.requested_on <= '".$start_date."'");
			$query = $this->db->get();
		if($id != ''){
			return $query->row();
		}else{
			return $query->result();
		}
	}

	/**
	 * @Desc: Approve Deposit Request
	 */
	public function approve_deposit_request ($id) {
		$conditions = array('id' => $id);
		$data = array(
			'approved_by' => get_user(),
			'approved_on' => date('Y-m-d H:i:s'),
			'status' => 'S'
		);

		$this->db->where($conditions)->update('add_money', $data);
		return $this->db->affected_rows();
	}

	/**
	 * @Desc: Approve Withdraw Request
	 */
	public function approve_withdraw_request ($id, $txn_ref_id = NULL) {
		$conditions = array('id' => $id);
		$data = array(
			'txn_ref_id' => !empty($txn_ref_id) ? $txn_ref_id : get_transaction_code(),
			'approved_by' => get_user(),
			'approved_on' => date('Y-m-d H:i:s'),
			'status' => 'S'
		);

		$this->db->where($conditions)->update('withdraw_money', $data);
		return $this->db->affected_rows();
	}
}