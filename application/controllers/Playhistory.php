<?php





class Playhistory extends CI_Controller

{

	function __construct() {

		parent::__construct();

		check_authentic_user();

		$this->load->model('Bid_model','bid');

	}

    public function showbid(){

        $data['categories'] = $this->bid->getCategory();

        $data['type'] = $this->config->item('game_type');

        $data['slot'] = $this->bid->getSlot();

        if ($this->input->server('REQUEST_METHOD') == 'POST')

		{

            extract($_POST);

            $data['bid'] = $this->bid->get_bid_count($cat_id,$slot_id,$type,$date); 

            $data['calculation_type'] = $this->bid->get_calculation_type($cat_id,$type); 

            $data['total_amount'] = 0;
            foreach($data['bid'] as $key => $value){
                $data['total_amount'] = $data['total_amount'] + $value->bidding_amount;
            }

            //echo $this->db->last_query();die();

            $data['cat_id']=$cat_id;

            $data['slot_id']=$slot_id;

            $data['game_type']=$type;
            $data['date']=$date;

            

        }

       

        $this->load->view('layout/header');

		$this->load->view('playhistory/bid',$data);

		$this->load->view('layout/footer');



    }

    public function getTimeSlot(){
        extract($_POST);
        $slots = $this->bid->getSlot($cat_id);
        
        if(!empty($slots)){
            foreach($slots as $slot){
                echo '<option value="'.$slot->id.'">'.$slot->start_time." - ".$slot->end_time.'</option>'; 
            }
        }else{
            echo '<option value="">No Time Slot available</option>'; 
        }
        
    }

    public function history(){

        $data['categories'] = $this->bid->getCategory();

        $data['type'] = $this->config->item('game_type');

        $data['slot'] = $this->bid->getSlot();

        if ($this->input->server('REQUEST_METHOD') == 'POST')

		{

            extract($_POST);

            $data['bid'] = $this->bid->get_bid_history($cat_id,$slot_id,$type,$date); 

           // echo $this->db->last_query();die();

            $data['cat_id']=$cat_id;

            $data['slot_id']=$slot_id;

            $data['game_type']=$type;            

            $data['date']=$date;            

        }

      



        $this->load->view('layout/header');

		$this->load->view('playhistory/history',$data);

		$this->load->view('layout/footer');

        

    } 
    public function indivisual(){

        $data['categories'] = $this->bid->getCategory();

        $data['type'] = $this->config->item('game_type');

        $data['slot'] = $this->bid->getSlot();

        if ($this->input->server('REQUEST_METHOD') == 'POST')

		{

            extract($_POST);

            $data['bid'] = $this->bid->get_individual_history($cat_id,$number,$date); 

            // echo $this->db->last_query();die();

            $data['cat_id']=$cat_id;

            $data['number']=$number;            

            $data['date']=$date;            

        }

      



        $this->load->view('layout/header');

		$this->load->view('playhistory/indivisual',$data);

		$this->load->view('layout/footer');

        

    } 
    
    
    public function game(){

        $data['categories'] = $this->bid->getCategory();

        if ($this->input->server('REQUEST_METHOD') == 'POST')

		{

            extract($_POST);
            $sql = "SELECT b.* 
            from bidding AS b 
            inner join game as g on g.gcode = b.game_code 
            WHERE g.cat_id = ? and DATE(b.bid_on) = ?";
            
            $query = $this->db->query($sql, [$cat_id, $date]);
            
            $data = $query->result_array();
            echo '<pre>';
             print_r($data);
		     die();


            $data['bid'] = $this->bid->get_bid_count($cat_id,$slot_id,$type,$date); 

            $data['calculation_type'] = $this->bid->get_calculation_type($cat_id,$type); 

            $data['total_amount'] = 0;
            foreach($data['bid'] as $key => $value){
                $data['total_amount'] = $data['total_amount'] + $value->bidding_amount;
            }

            //echo $this->db->last_query();die();

            $data['cat_id']=$cat_id;

            $data['date']=$date;

            

        }

       

        $this->load->view('layout/header');

		$this->load->view('playhistory/game',$data);

		$this->load->view('layout/footer');



    }

   

} 

?>