<?php


class Game_model extends CI_Model
{
	public function get_data(){
		$this->db->select('game.*,category.cat_name,slot.start_time,slot.end_time')
		->from('game')
		->join('category','category.id = game.cat_id')
		->join('slot','slot.id = game.slot_id');
			$query = $this->db->get();
		return $query->result();
	}
	public function getCategory(){
		$this->db->select('*')
			->from('category')
			->where(['status' => 'Y']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSlot(){
		$this->db->select('*')
			->from('slot')
			->where(['status' => 'Y']);
		$query = $this->db->get();
		return $query->result();
	}

}