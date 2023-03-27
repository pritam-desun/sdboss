<?php





class Bid_model extends CI_Model

{

    public function getCategory(){

		$this->db->select('*')

			->from('category')

			->where(['status' => 'Y']);

		$query = $this->db->get();

		return $query->result();

	}

	

	public function getSlot($id = 0){

		$this->db->select('*')

			->from('slot')

			->where(['status' => 'Y']);
		
			if($id != 0){
				$this->db->where(['cat_id' => $id]);
			}

		$query = $this->db->get();

		return $query->result();

	}

    

    public function get_bid_count($cat_id,$slot_id,$type,$date){

        $this->db->select('COUNT(bidding.id) as total, SUM(bidding.amount) as bidding_amount,bidding.number')

		->from('bidding')

		->join('game','game.gcode = bidding.game_code')

		->where('game.cat_id',$cat_id)

		->where('game.slot_id',$slot_id)

		->where('bidding.type',$type)

        ->group_by('bidding.number')
		->where('DATE(bidding.bid_on)',$date)

        ->order_by('bidding.amount', "asc");

			$query = $this->db->get();

		return $query->result();

    }


	public function get_calculation_type($cat_id,$type){

        $this->db->select('type, value')
		->from('wining_price')
		->where('cat_id',$cat_id)
		->where('game_type',$type);
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		return $query->row();

    }




    public function get_bid_history($cat_id,$slot_id,$type,$date){

        $this->db->select('bidding.*, game.name, customers.full_name, customers.mobile')

		->from('bidding')

		->join('game','game.gcode = bidding.game_code')

		->join('customers','customers.cust_code = bidding.cust_code')

		->where('game.cat_id',$cat_id)

		->where('game.slot_id',$slot_id)

		->where('bidding.type',$type)

		->where('DATE(bidding.bid_on)',$date)

        ->order_by('bidding.amount', "asc");

			$query = $this->db->get();

		return $query->result();

    }
    public function get_individual_history($cat_id,$number,$date){

        $this->db->select('bidding.*, game.name, customers.full_name, customers.mobile')

		->from('bidding')

		->join('game','game.gcode = bidding.game_code')

		->join('customers','customers.cust_code = bidding.cust_code')

		->where('game.cat_id',$cat_id)
		->where('customers.mobile',$number)

		->where('DATE(bidding.bid_on)',$date)

        ->order_by('bidding.id', "asc");

			$query = $this->db->get();

		return $query->result();

    }

}