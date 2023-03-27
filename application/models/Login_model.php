<?php
class Login_model extends CI_Model
{

    public function validate_login($condition)
    {
        $this->db->select('*')
            ->from('tbl_admin_login')
            ->where($condition);

        $query = $this->db->get();
        return $query->row();
    }
    public function validate_users($data)
    {
        $this->db->select('*')
            ->from('users')
            ->where($data);

        $query = $this->db->get();
        return $query->row();
    }
}
