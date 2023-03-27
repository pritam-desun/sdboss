<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_authentic_user'))
{
	function check_authentic_user()
	{
		$ci=& get_instance();
		$user_session = $ci->session->userdata('user');
		//print_r($user_session);exit;
		if(empty($user_session)){
			redirect('login');
		}
	}
}

if ( ! function_exists('get_user'))
{
	function get_user()
	{
		$ci=& get_instance();
		$user_session = $ci->session->userdata('user');
		//print_r($user_session);exit;
		return $user_session['id'];
	}
}

if ( ! function_exists('send_notification'))
{
	function send_notification($to,$title = '',$body ='')
	{
		$ci=& get_instance();
		$vars = new stdClass();
		$vars->to = $to;
		$vars->title = $title;
		$vars->body = $body;

		$headers = [
			"Content-Type: application/json"
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://exp.host/--/api/v2/push/send");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($vars));  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		//print_r($server_output) ;exit;
		return true;
	}
}

if ( ! function_exists('send_notification_multi_device')) {
	function send_notification_multi_device($device_tokens = array(), $title = '', $body ='') {
		if (count($device_tokens) > 0) {
			$chunk_device_tokens = array_chunk($device_tokens, 99);

			foreach ($chunk_device_tokens as $tokens) {
				$push_data = array();
				foreach ($tokens as $to) {
					$push_data[] = array(
						'to' => $to,
						'title' => $title,
						'body' => $body
					);
				}

				$headers = array("Content-Type: application/json");
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://exp.host/--/api/v2/push/send");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($push_data));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$server_output = curl_exec ($ch);
             // print_r($server_output);exit;
				curl_close ($ch);
			}
		}
	}
}


if ( ! function_exists('get_file_extension'))
{
	function get_file_extension($file = '')
	{
		if($file != ''){
			$fileExt = pathinfo($file, PATHINFO_EXTENSION);
		}else{
			$fileExt = false;
		}
		return $fileExt;
	}
}

if ( ! function_exists('get_bradecrumb'))
{
	function get_bradecrumb()
	{
		$ci=& get_instance();

		$controllers = $ci->router->class;
		$methods = $ci->router->method;
		//print_r($user_session);exit;
		$breadcrumb = '<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0);">'.ucfirst($controllers).'</a></li>
						<li class="breadcrumb-item active" aria-current="page"><span>'.ucfirst($methods).'</span></li>
						</ol>';


		return $breadcrumb;
	}
}

if ( ! function_exists('change_date_format'))
{
	function change_date_format($date,$format)
	{
		$ci=& get_instance();
		$newDate = date($format, strtotime($date));
		return $newDate;
	}
}

if ( ! function_exists('get_transaction_code')) {
	function get_transaction_code() {
		date_default_timezone_set('Asia/Kolkata');
		return 'TRANS' . abs(crc32(uniqid()));
	}
}
