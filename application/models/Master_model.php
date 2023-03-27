<?php


class Master_model extends CI_Model
{
	public function getNews(){
		$this->db->select('*')
			->from('news_update');
		$query = $this->db->get();
		return $query->result();
	}
	public function getSlider(){
		$this->db->select('*')
			->from('slider');
		$query = $this->db->get();
		return $query->result();
	}
	public function getCategory(){
		$this->db->select('*')
			->from('category');
		$query = $this->db->get();
		return $query->result();
	}
	public function getSlots(){
		$this->db->select('*')
			->from('slot');
		$query = $this->db->get();
		return $query->result();
	}
	public function getactiveCategory(){
		$this->db->select('*')
			->from('category')
			->where(['status' => 'Y']);
		$query = $this->db->get();
		return $query->result();
	}
	public function getprice(){
		$this->db->select('wining_price.*,category.cat_name')
		->from('wining_price')
		->join('category','category.id=wining_price.cat_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function checkPrice($data){
		//print_r($data);die();
		$this->db->select('*')
		->from('wining_price')
		->where('cat_id', $data['cat_id'])
		->where('game_type', $data['game_type']);
		$query = $this->db->get();
		return $query->row();
	}

}