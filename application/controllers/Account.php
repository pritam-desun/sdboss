<?php


class Account extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_authentic_user();
		$this->load->model('Account_model', 'account');
	}

	public function list()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$user_id = strip_tags($this->input->post('user_id'));
			$password = strip_tags($this->input->post('password'));

			$where = array('id' => $user_id);
			$data = array('id' => $user_id, 'password' => md5($password));
			$result = $this->com->add($data, 'customers', $where);
			if ($result) {
				$this->session->set_flashdata('msg', 'Password changed successfully');
				$this->session->set_flashdata('msg_class', 'success');
			} else {
				$this->session->set_flashdata('msg', 'Failed to change password');
				$this->session->set_flashdata('msg_class', 'danger');
			}
		}

		$data['total_amount'] = $this->account->getTotalAmount();
		$data['total_user'] = $this->account->getTotalUser();
		$this->load->view('layout/header');
		$this->load->view('account/list', $data);
		$this->load->view('layout/footer');
	}

	public function inactivelist()
	{
		$data['total_amount'] = $this->account->getTotalAmount('1');
		$data['total_user'] = $this->account->getTotalUser('1');
		$this->load->view('layout/header');
		$this->load->view('account/list', $data);
		$this->load->view('layout/footer');
	}

	public function delete()
	{
		$id = $_GET['id'];

		$sql = "SELECT cust_code FROM customers WHERE id = ?";
		$customerData = $this->db->query($sql, [$id])->row();

		$cust_code = $customerData->cust_code;

		$sql = "DELETE FROM wallet WHERE cust_code = ?";
		$this->db->query($sql, [$cust_code]);

		$sql = "DELETE FROM withdraw_money WHERE cust_code = ?";
		$this->db->query($sql, [$cust_code]);

		$sql = "DELETE FROM wallet_trans WHERE cust_code = ?";
		$this->db->query($sql, [$cust_code]);

		$sql = "DELETE FROM bidding WHERE cust_code = ?";
		$this->db->query($sql, [$cust_code]);

		$sql = "DELETE FROM add_money WHERE cust_code = ?";
		$this->db->query($sql, [$cust_code]);

		$sql = "DELETE FROM customers WHERE id = ?";
		$this->db->query($sql, [$id]);

		redirect('account/inactivelist');
	}

	public function get()
	{

		// $url_string = $this->uri->uri_string();

		// $action = [];

		// $ac = $this->session->user['ac'];

		// if ($this->session->user['ac'] != NULL) {

		// 	$menu_actions = $this->db->query("SELECT m.id, m.url, ma.* FROM menu AS m JOIN menu_action as ma ON m.id = ma.menu_id WHERE m.url = '$url_string'")->result_array();

		// 	foreach ($menu_actions as $ma) {
		// 		if (in_array($ma['id'], $ac)) {
		// 			array_push($action, $ma['action_name']);
		// 		}
		// 	}
		// } else {
		// 	$action[] = NULL;
		// }

		$data = [];
		$data['data'] = [];
		$lists = $this->account->getActiveAccountList();
		//$url = base_url('account/remove');
		$confirm = "onclick = 'return confirm(" . '"Are you sure?"' . ")'";

		/* echo "<pre>";
		print_r($lists);
		die; */


		foreach ($lists as $list) {

			$url = base_url('account/remove/') . $list->id;

			$list->action = "<a href=" . base_url('account/edit/' . $list->id) . " class='btn btn-info mb-2'>Edit</a> <a href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal' onclick='changePass($list->id)' class='btn btn-primary mb-2 change_password'><i class='fas fa-key' aria-hidden='true'></i> </a>
			<a href=" . $url . " " . $confirm . " class='btn btn-danger mb-2'>Inactive</a>";
			array_push($data['data'], $list);
		}
		echo json_encode($data);
	}



	public function get_inactive()
	{
		$data = [];
		$data['data'] = [];
		$lists = $this->account->getInactiveAccountList();
		//$url = base_url('account/remove');
		$confirm = "onclick = 'return confirm(" . '"Are you sure?"' . ")'";


		foreach ($lists as $list) {
			$delete_url = base_url('account/delete') . '?id=' . $list->id;
			$url = base_url('account/restore/') . $list->id;
			$action = "<a href=" . $url . " " . $confirm . " class='btn btn-primary mb-2'>Restore</a>";
			$action .= "<a href=" . $delete_url . " class='btn btn-danger mb-2'>Delete</a>";
			$list->action = $action;
			array_push($data['data'], $list);
		}
		echo json_encode($data);
	}

	public function edit()
	{
		$id  = $this->uri->segment(3);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$dealer_id = $this->input->post('dealer_id');
			if ($this->db->update('customers', ['assigned_by_id' => $dealer_id], ['id' => $id])) {
				redirect('account/list');
			}
		}
		$data['customer'] = $this->db->get_where('customers', ['id' => $id])->row();
		$data['distributors'] = $this->db->get_where('users', ['user_type' => 3])->result();
		$data['selected_dealer'] = $this->db->get_where('users', ['user_id' => $data['customer']->assigned_by_id])->row();
		$data['dealers'] = $this->db->get_where('users', ['user_type' => 4])->result();
		$this->load->view('layout/header');
		$this->load->view('account/counteredit', $data);
		$this->load->view('layout/footer');
	}

	function getAccount()
	{
		$data = array();
		extract($_POST);
		$result = $this->account->getDetail($mobile);
		if (!empty($result)) {
			$data['data'] = $result;
			$data['status'] = '1';
		} else {
			$data['data'] = NULL;
			$data['status'] = '0';
		}
		echo json_encode($data);
	}

	function remove($customer_id)
	{
		$data = array(
			'id' => $customer_id,
			'is_deleted' => '1'
		);
		$where = array(
			'id' => $customer_id
		);
		$result = $this->com->add($data, 'customers', $where);
		redirect('account/list');
	}

	function restore($customer_id)
	{
		$data = array(
			'id' => $customer_id,
			'is_deleted' => '0'
		);
		$where = array(
			'id' => $customer_id
		);
		$result = $this->com->add($data, 'customers', $where);
		redirect('account/inactivelist');
	}
}
