<?php
class Counter extends CI_Controller
{

  public $commonHelper;
  function __construct()
  {
    parent::__construct();
    // check_authentic_user();
    $this->load->model('Master_model', 'master');
    $this->load->model('Bid_model', 'bid');
    //	$this->load->model('Money_model','money');
    $this->load->helper('commonfunction');
    $this->commonHelper = new CommonFunction;
  }

  public function view()
  {
    $data = [];
    // if ($this->session->user['user_type'] == 1) {
    //   $data['dealer'] = $this->db->query("SELECT * FROM `users` WHERE user_type = 4 ORDER BY created_at DESC")->result_array();
    //   // $data['dealer'] = $this->db->get_where("tbl_admin_login", ['user_type !=' => 1])->result_array();
    // } else if ($this->session->user['user_type'] == 2) {
    //   $data['dealer'] = $this->db->query("SELECT * FROM `users` ORDER BY created_at DESC")->result_array();
    // } else if ($this->session->user['user_type'] == 3) {
    //   $data['dealer'] = $this->db->query("SELECT * FROM `users` WHERE user_name = 'dealer' AND assigned_by_id = 3 ORDER BY created_at DESC")->result_array();
    // }

    /* echo "<pre>";
    print_r($_SESSION);
    die; */
    $user_id = $this->uri->segment(3);
    if ($this->session->user['user_type'] == 4) {
      $user_id = $this->session->user['user_id'];
      // assigned_by_id = $user_id
      $data['counter'] = $this->db->get_where('customers', array('assigned_by_id' => $user_id))->result_array();
    } else if ($this->session->user['user_type'] == 1) {
      /*  $this->db->select('customers.*, dealer.full_name as dealer_name, distributor.full_name as distributor_name');
      $this->db->join('users as dealer', 'dealer.user_id=customers.assigned_by_id', 'left');
      $this->db->join('users as distributor', 'distributor.user_id=dealer.assigned_by_id', 'left');
      $data['counter'] = $this->db->get_where('customers', array('customers.assigned_by_id' => $user_id))->result_array(); */
    } else if ($this->session->user['user_type'] == 3) {

      $this->db->select('customers.*, wallet.amount as wallet_balance');
      $this->db->join('wallet', 'customers.cust_code=wallet.cust_code', 'left');
      $this->db->order_by('wallet_balance', 'desc');
      $this->db->order_by('customers.is_deleted', 'asc');
      $data['counter'] = $this->db->get_where('customers', array('assigned_by_id' => $user_id))->result_array();
      /*  echo "<pre>";
      print_r($data['counter']);
      die; */
      $this->load->view('layout/header');
      $this->load->view('counter/dealerwisecountetrview', $data);
      $this->load->view('layout/footer');
      return true;
    }



    $this->load->view('layout/header');
    $this->load->view('counter/view', $data);
    $this->load->view('layout/footer');
  }

  public function add()
  {
    $input = [];

    if ($this->input->post() != NULL) {

      // CUST001002
      $autoIOncrementId = $this->db->query("SELECT (MAX(id) + 1) as Auto_increment FROM customers")->row()->Auto_increment;
      $cust_code = 'CUST' . str_pad($autoIOncrementId, 6, '0', STR_PAD_LEFT);

      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d H:i:s');

      if ($this->session->user['user_type'] == 4) {
        $assigned_id = $this->session->user['user_id'];
      } else if ($this->session->user['user_type'] == 1) {
        $assigned_id = $this->input->post('dealer_id');
      }

      $userdata = [
        'full_name' => $this->input->post('full_name'),
        'cust_code' => $cust_code,
        'mobile' => $this->input->post('mobile'),
        'password' => md5($this->input->post('password')),
        'assigned_by_id' => $assigned_id,
        'created_on' => $date
      ];
      if ($this->db->insert('customers', $userdata)) {
        $this->session->set_flashdata('msg', 'Counter added successfully');
        $this->session->set_flashdata('msg_class', 'success');
        redirect('counter/view');
      } else {
        $this->session->set_flashdata('msg', 'Failed to add');
        $this->session->set_flashdata('msg_class', 'danger');
        redirect('counter/add');
      }
    }

    $data['distributors'] = $this->db->get_where('users', array('user_type' => 3))->result();
    $data['dealers'] = $this->db->get_where('users', array('user_type' => 4))->result();

    $this->load->view('layout/header');
    $this->load->view('counter/add', $data);
    $this->load->view('layout/footer');
  }

  // public function edit()
  // {
  //   $id = $this->uri->segment(3);

  //   $data = [];

  //   $input = [];

  //   $data['emp'] = $this->db->get_where('users', ['user_id' => $id])->row_array();

  //   if ($this->input->post() != NULL) {
  //     date_default_timezone_set('Asia/Kolkata');
  //     $date = date('Y-m-d H:i:s');

  //     $input = [

  //       'phone_no' => $this->input->post('phone_no'),
  //       'password' => ($this->input->post('password'))
  //     ];

  //     if (!empty($input)) {
  //       $this->db->where('user_id', $id);
  //       $this->db->update('users', $input);

  //       $affectedRows = $this->db->affected_rows();

  //       if ($affectedRows) {
  //         $this->session->set_flashdata('msg', 'Dealer updated successfully');
  //         $this->session->set_flashdata('msg_class', 'success');
  //         redirect('dealer/view');
  //       } else {
  //         $this->session->set_flashdata('msg', 'Failed to update');
  //         $this->session->set_flashdata('msg_class', 'danger');
  //         redirect('dealer/edit');
  //       }
  //     }
  //   }

  //   $this->load->view('layout/header');
  //   $this->load->view('dealer/edit', $data);
  //   $this->load->view('layout/footer');
  // }

  public function empStatus($status, $id)
  {
    // $data = array(
    //   'id' => $id,
    //   'is_active' => $status
    // );
    // $where = array(
    //   'id' => $id
    // );
    // $result = $this->com->add($data, 'tbl_admin_login', $where);
    // if ($result) {
    //   $this->session->set_flashdata('msg', 'Status changed successfully');
    //   $this->session->set_flashdata('msg_class', 'success');
    // } else {
    //   $this->session->set_flashdata('msg', 'Failed to change status');
    //   $this->session->set_flashdata('msg_class', 'danger');
    // }
    // redirect('dealer/view');
  }

  // public function delete()
  // {
  //   $id = $this->uri->segment(3);

  //   $this->db->delete('users', ['user_id' => $id]);


  //   $affectedRows = $this->db->affected_rows();

  //   // if ($affectedRows) {

  //   //   $this->db->delete('menu_permission', ['user_ref' => $id]);
  //   //   $this->session->set_flashdata('msg', 'Employee deleted successfully');
  //   //   $this->session->set_flashdata('msg_class', 'success');
  //   //   redirect('distributor/view');
  //   // } else {
  //   //   $this->session->set_flashdata('msg', 'Failed to delete');
  //   //   $this->session->set_flashdata('msg_class', 'danger');
  //   //   
  //   // }
  //   redirect('dealer/view');
  //   //}
  // }


  public function get_dealer()
  {
    $distributor_id =  $this->input->post('distributor_id');
    $dealers = $this->db->get_where('users', array('assigned_by_id' => $distributor_id, 'user_name' => 'dealer'))->result();
    $html = '';
    foreach ($dealers as $key => $dealer) {
      $html .= '<option value="' . $dealer->user_id . '">' . $dealer->full_name . ' (' . $dealer->phone_no . ')</option>';
    }

    echo $html;
  }
}
