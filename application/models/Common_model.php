<?php
class Common_model extends CI_Model{

	public function add($data,$table_name,$where = ''){
		if(isset($data['id'])){
			unset($data['id']);
			$this->db->where($where);
			$this->db->update($table_name, $data);
			return $this->db->affected_rows();
		}else{
			$this->db->insert($table_name,$data);
			return $this->db->insert_id();
		}
	}
	public function get_count($table_name){
		$this->db->select('count(id) as total_count')
			->from($table_name);
		$query = $this->db->get();
			return $query->row();
	}
	public function get_data_by_id($table_name,$id){
		$this->db->select('*')
			->from($table_name)
			->where('id='.$id);
		$query = $this->db->get();
			return $query->row();
	}

	public function get_code($string,$count){
		$str = $string.date('is');
		$code = str_pad($count->total_count,6,"0",STR_PAD_LEFT);
		return $str.$code;
	}
	public function delete_row($table,$where){
		$this->db->where($where);
		$this->db->delete($table);
	}
	public function add_batch($table_name,$data){
		$this->db->insert_batch($table_name, $data);
		return $this->db->insert_id();
		
	}
	public function getSettings(){
		$this->db->select('*')
			->from('settings');
		$query = $this->db->get();
			return $query->row();
	}

	public function updateAll($table_name,$data){
		$this->db->update($table_name, $data);
		return $this->db->affected_rows();
	}
}