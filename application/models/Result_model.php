<?php
class Result_model extends CI_Model {
	
	public function getCategory($where){
		$this->db->select('*')
			->from('category')			
			->where('id',$where);
		$query = $this->db->get();
		return $query->row();
	}

	public function getData($where){
		$this->db->select('game.*,slot.start_time,slot.end_time')
			->from('game')
			->JOIN('category', 'category.id = game.cat_id', 'LEFT')
			->JOIN('slot', 'slot.id = game.slot_id', 'LEFT')
			->where('category.id',$where)
			->order_by('slot.start_time', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getPrice($cat_id,$type){
		$this->db->select('*')
			->from('wining_price')
			->where('cat_id',$cat_id)
			->where('game_type',$type);
		$query = $this->db->get();
		return $query->row();
	}

	public function getbidding($g_code,$type,$digit, $date){
		$this->db->select('*')
			->from('bidding')
			->where('game_code',$g_code)
			->where('type',$type)
			->where('number',$digit)
			->where('DATE(bid_on)',$date);
		$query = $this->db->get();
		return $query->result();
	}

	public function add_balance($amount,$cust_code){
		$this->db->where('cust_code',$cust_code);
		$this->db->set('amount', '`amount`+'.$amount, FALSE);
		$this->db->update('wallet');
		return $this->db->affected_rows();
	}

	public function minus_balance($amount,$cust_code){
		$this->db->where('cust_code',$cust_code);
		$this->db->set('amount', '`amount`-'.$amount, FALSE);
		$this->db->update('wallet');
		return $this->db->affected_rows();
	}

	public function update_status($where){
		$this->db->where($where);
		$this->db->set('status', 'L');
		$this->db->update('bidding');
		return $this->db->affected_rows();
	}

	public function getGameData($where){
		$this->db->select('game.*,category.cat_name,slot.start_time,slot.end_time')
			->from('game')
			->join('category','category.id = game.cat_id')
			->join('slot','slot.id = game.slot_id')
			->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	public function getlog($where){
		$this->db->select('*')
			->from('result_log')
			->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAllGame($category_id){
		$sql = "select name from game where status = 'Y' and cat_id = '".$category_id."'";
        $query = $this->db->query($sql);
		return array_column($query->result_array(), 'name');
	}
}