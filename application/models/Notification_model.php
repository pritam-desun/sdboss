<?php


class Notification_model extends CI_Model
{
		public function getAllDeviceToken(){
			$this->db->select('token')
				->from('device_token');
			$query = $this->db->get();
			return $query->result();
		}
}
