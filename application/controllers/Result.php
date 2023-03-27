<?php


class Result extends CI_Controller
{
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		check_authentic_user();
		$this->load->model('Result_model','result');
		$this->load->model('Notification_model','notification');
	}
	public function index($id){		
		$data['result']=$this->result->getData($id);		
		$data['category']=$this->result->getCategory($id);	
		
		$this->load->view('layout/header');
		$this->load->view('result/result',$data);
		$this->load->view('layout/footer');
		// $where = array(
		// 	'DATE(b.bid_on)' => '2021-05-27',
		// 	'b.type' => $this->input->post('type'),
		// 	'g.slot_id' => $this->input->post('slot'),
		// );

		// print_r($this->result->getDetails($where));
	}

	/**
	 * @Desc: Published Result
	 */
	public function add(){
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			## Result Published Date
			$result_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('result_date', TRUE))));
			$category_id = $this->input->post('cat_id', TRUE);
			$game_code = $this->input->post('g_code', TRUE);
			$prev_code = $this->input->post('prev_code', TRUE) ? $this->input->post('prev_code', TRUE) : 0;
			
			/**
			 * @Desc: Loop for Single & Patti
			 * @Desc: $key -> Game Type
			 * @Desc: $value -> Win Number
			 */
			
			foreach($_POST['type'] as $key => $value){
				if($value != ''){
					## Save result
					$game_result = array(
						'game_code' => $game_code,
						'type' => $key,
						'win_number' => $value,
						'published_on' => $result_date . ' 00:00:00'
					);

					// print_r($game_result);exit;
					$this->com->add($game_result,'game_result');
					// echo $this->db->last_query();exit;	
					## Get Winning Price
					$winning_price = $this->result->getPrice($category_id, $key);
					
					## Get Win Bid records
					$bidding = $this->result->getbidding($game_code, $key, $value, $result_date);
					// echo $this->db->last_query();exit;
					
					## update status to Loss which bidding is not win
					$where= " type='".$key."' and number!=".$value." and game_code='".$game_code."' and DATE(bid_on)='".$result_date."'";
					$this->result->update_status($where);
					
					$win_bid_ids = array();
					$txn_data = array();
					$winning_log = array();

					foreach ($bidding as $b) { 
						## Collect win bid ids
						$win_bid_ids[] = $b->id;

						## Calculate Wining Amount
						$amount = 0;
						if($winning_price->type === 'Multiply'){
							$amount = $b->amount * $winning_price->value;
						}
						else{
							$amount = $b->amount + round(($b->amount * $winning_price->value) / 100);
						}

						## Update wallet balance
						$this->result->add_balance($amount, $b->cust_code);

						## Prepare Transaction data
						$txn_data[] = array(
							'cust_code' => $b->cust_code,
							'trans_code' => get_transaction_code(),
							'amount' => $amount,
							'purpose' => 'Winning Price',
							'type' => 'CR',
							'txn_reference' => $game_code,
							'created_on' => date('Y-m-d H:i:s'),
						);
							
						## Create Win Log
						$winning_log[$b->cust_code.date('s').rand('0','99')] = $amount;
					}

					## Update Bid status as win
					if (count($win_bid_ids) > 0) {
						$this->db->where_in('id', $win_bid_ids)->update('bidding', array('status' => 'W'));
					}

					## Add Transaction data
					if (count($txn_data) > 0) {
						$this->db->insert_batch('wallet_trans', $txn_data);
					}

					## Game result log
					$game_result_log = array(
						'game_code' => $game_code,
						'type' => $key,
						'winning_data' => json_encode($winning_log),
						'date' => $result_date
					);
					$this->com->add($game_result_log,'result_log');
				}

				
			}

			// echo "<pre>";
			// 	print_r($game_result);
			// 	print_r($_POST['type']);
			// 	echo "</pre>";
			// 	echo $prev_code;exit;

			## Send Notification
			$where = array('game.gcode' => $game_code);
			$game_data = $this->result->getGameData($where);
			$message_body = 'Single - ' . $_POST['type']['Single'];
			$message_body .= ', Patti - ' . $_POST['type']['Patti'];
			if(isset($_POST['type']) && $_POST['type']['Jodi'] != ''){
				$all_game = $this->result->getAllGame($category_id);
				$current_game_index = array_search($game_data->name, $all_game);
				// echo $current_game_index;exit;
				$prev_name = $all_game[$current_game_index-1];
				$message_body .= ', Jodi('. $prev_name .' & '. $game_data->name. ') - ' . $_POST['type']['Jodi'];
			}
			$message_body .= ', CP - ' . $_POST['type']['CP'];
			
			$title = $game_data->cat_name . " - " . $game_data->name . ' Winning Result';
			$this->sendNotification($title, $message_body);

			$this->session->set_flashdata('msg', 'Result added successfully');
			$this->session->set_flashdata('msg_class', 'success');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function edit(){
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			## Result Published Date
			$result_date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['edit_result_date'])));
			$category_id = $this->input->post('cat_id', TRUE);
			$game_code = $this->input->post('g_code', TRUE);
			$prev_code = $this->input->post('prev_code', TRUE) ? $this->input->post('prev_code', TRUE) : 0;

			
			foreach($_POST['type'] as $key => $value){
				if($value != ''){
					## Get Wining data
					$where_log = array(
						'game_code' => $game_code,
						'type' => $key,
						'date' => $result_date
					);
					$result_log = $this->result->getlog($where_log);
					$winning_data = json_decode($result_log->winning_data, true);

					## Deduct amount from wallet
					$edit_txn_data = array();
					foreach($winning_data as $customer_code => $amount){

						##Extracting actual customer code
						$cust_code = substr($customer_code, 0, -4);	
						## Deduct balance
						$this->result->minus_balance($amount, $cust_code);

						## Prepare Transaction data
						$edit_txn_data[] = array(
							'cust_code' => $cust_code,
							'trans_code' => get_transaction_code(),
							'amount' => $amount,
							'purpose' => 'Edit Result',
							'type' => 'DR',
							'txn_reference' => $game_code,
							'created_on' => date('Y-m-d H:i:s')
						);
					}

					## Add Edit Transaction
					if (count($edit_txn_data) > 0) {
						$this->db->insert_batch('wallet_trans', $edit_txn_data);
					}

					## Edit Game Result
					$data_add['id'] = 1;
					$data_add['type'] = $key;
					$data_add['win_number'] = $value;
					$where_result = array(
						'game_code' => $game_code,
						'type' => $key,
						'DATE(published_on)' => $result_date
					);
					$this->com->add($data_add, 'game_result', $where_result);

					## Get wining price details
					$winning_price = $this->result->getPrice($category_id, $key);
					
					## get bidding details of win number
					$bidding = $this->result->getbidding($game_code, $key, $value, $result_date);

					//update status to Loss//
					$where= " type='".$key."' and number!=".$value." and game_code='".$game_code."' and DATE(bid_on)='".$result_date."'";
					$this->result->update_status($where);
					
					$win_bid_ids = array();
					$txn_data = array();
					$winning_log = array();

					foreach($bidding as $b){
						## Collect Bid Ids, which status will be set as win
						$win_bid_ids[] = $b->id;

						## Calculate win amount
						$amount = 0;
						if($winning_price->type === 'Multiply'){
							$amount = $b->amount * $winning_price->value;
						}
						else{
							$amount = $b->amount + round(($b->amount * $winning_price->value) / 100);
						}

						## Update wallet balance
						$this->result->add_balance($amount, $b->cust_code);

						## Prepare Transaction data
						$txn_data[] = array(
							'cust_code' => $b->cust_code,
							'trans_code' => get_transaction_code(),
							'amount' => $amount,
							'purpose' => 'Winning Price',
							'type' => 'CR',
							'txn_reference' => $game_code,
							'created_on' => date('Y-m-d H:i:s')
						);

						## Prepare win log
						$winning_log[$b->cust_code.date('s').rand('0','99')] = $amount;
					}

					## Update Bidding status as win
					if (count($win_bid_ids) > 0) {
						$this->db->where_in('id', $win_bid_ids)->update('bidding', array('status' => 'W'));
					}

					## Add Transaction
					if (count($txn_data) > 0) {
						$this->db->insert_batch('wallet_trans', $txn_data);
					}

					## Edit Result Log
					$where_log= array(
						'game_code' => $game_code,
						'type' => $key,
						'date' => $result_date
					);

					$data_log['id'] = 1;
					$data_log['winning_data'] = json_encode($winning_log);
					$this->com->add($data_log, 'result_log', $where_log);
				}
			}
			
			$where = array(
				'game.gcode' => $game_code
			);
			$game_data = $this->result->getGameData($where);
			$message_body='Single - '.$_POST['type']['Single'];
			$message_body .=', Patti - '.$_POST['type']['Patti'];
			$game_data=$this->result->getGameData($where);
			if(isset($_POST['type']) && $_POST['type']['Jodi'] != ''){
				$all_game = $this->result->getAllGame($category_id);
				$current_game_index = array_search($game_data->name, $all_game);
				// echo $current_game_index;exit;
				$prev_name = $all_game[$current_game_index-1];
				$message_body .= ', Jodi('. $prev_name .' & '. $game_data->name. ') - ' . $_POST['type']['Jodi'];
			}
			$message_body .= ', CP - ' . $_POST['type']['CP'];
			$title= $game_data->cat_name." - ".$game_data->name .' Winning Result';
			$this->sendNotification($title, $message_body);

			$this->session->set_flashdata('msg', 'Result edited successfully');
			$this->session->set_flashdata('msg_class', 'success');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	function sendNotification($title, $body){
		/*$to = array();
		$allToken = $this->notification->getAllDeviceToken();
		foreach($allToken as $key => $token){
			//array_push($to, $token->token);
			$result = send_notification($token->token,$title,$body);
			if(count($allToken) == $key+1 ){
				$success = true;
			}else{
				$success = false;
			}
		}
		//$result = send_notification($to,$title,$body);
		if($success){
			return true;
		}*/

		$allToken = $this->notification->getAllDeviceToken();
		$tokens = array();
		foreach($allToken as $key => $token) {
			$tokens[] = $token->token;
		}
		send_notification_multi_device($tokens, $title, $body);
	}

}