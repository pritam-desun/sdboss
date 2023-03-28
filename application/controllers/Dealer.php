<?php
class Dealer extends CI_Controller
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

    if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
      $distributor_id = $this->uri->segment(3);
      $where = '';
      if (!is_null($distributor_id)) {
        $where = 'AND users.assigned_by_id= ' . $distributor_id . '';
      }
      $data['dealer'] = $this->db->query("SELECT users.*, CONCAT((SELECT COUNT(customers.id) FROM customers WHERE customers.assigned_by_id=user_id)) as total FROM `users` WHERE user_type = 4  $where  ORDER BY total DESC")->result_array();

      /* echo $this->db->last_query();
      die; */
      // $data['dealer'] = $this->db->get_where("tbl_admin_login", ['user_type !=' => 1])->result_array();
    } else if ($this->session->user['user_type'] == 3) {
      $distrubutor_id = $this->session->user['user_id'];
      $data['dealer'] = $this->db->query("SELECT users.*, CONCAT((SELECT COUNT(customers.id) FROM customers WHERE customers.assigned_by_id=user_id)) as total FROM `users` LEFT JOIN customers ON users.user_id=customers.assigned_by_id WHERE user_name = 'dealer' AND users.assigned_by_id = $distrubutor_id GROUP BY users.user_id")->result_array();
      /* echo $this->db->last_query();
      exit; */
    }
    $this->load->view('layout/header');
    $this->load->view('dealer/view', $data);
    $this->load->view('layout/footer');
  }

  public function add()
  {
    $input = [];

    if ($this->input->post() != NULL) {

      if ($this->session->user['user_type'] == 1) {
        $assigned_id = $this->session->user['user_id'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s');

        $userdata = [
          'user_type' => 4,
          'user_name' => "dealer",
          'full_name' => $this->input->post('full_name'),
          'email_id' => $this->input->post('email'),
          'phone_no' => $this->input->post('mobile'),
          'password' => ($this->input->post('password')),
          'assigned_by_id' => $assigned_id,
          'created_at' => $date
        ];
        $insert = $this->db->insert('users', $userdata);
        $affectedRows = $this->db->affected_rows();
        if ($affectedRows) {
          $this->session->set_flashdata('msg', 'Dealer added successfully');
          $this->session->set_flashdata('msg_class', 'success');
          redirect('dealer/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to add');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('dealer/add');
        }
      } elseif ($this->session->user['user_type'] == 2) {
        $assigned_id = $this->session->user['user_id'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s');

        $userdata = [
          'user_type' => 4,
          'user_name' => "dealer",
          'full_name' => $this->input->post('full_name'),
          'email_id' => $this->input->post('email'),
          'phone_no' => $this->input->post('mobile'),
          'password' => ($this->input->post('password')),
          'assigned_by_id' => $assigned_id,
          'created_at' => $date
        ];
        $insert = $this->db->insert('users', $userdata);

        $affectedRows = $this->db->affected_rows();
        if ($affectedRows) {
          $this->session->set_flashdata('msg', 'Distributor added successfully');
          $this->session->set_flashdata('msg_class', 'success');
          redirect('dealer/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to add');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('dealer/add');
        }
      } elseif ($this->session->user['user_type'] == 3) {
        $assigned_id = $this->session->user['user_id'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s');

        $userdata = [
          'user_type' => 4,
          'user_name' => "dealer",
          'full_name' => $this->input->post('full_name'),
          'email_id' => $this->input->post('email'),
          'phone_no' => $this->input->post('mobile'),
          'password' => ($this->input->post('password')),
          'assigned_by_id' => $assigned_id,
          'created_at' => $date
        ];
        $insert = $this->db->insert('users', $userdata);

        $affectedRows = $this->db->affected_rows();
        if ($affectedRows) {
          $this->session->set_flashdata('msg', 'Dealer added successfully');
          $this->session->set_flashdata('msg_class', 'success');
          redirect('dealer/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to add');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('dealer/add');
        }
      }
    }

    $this->load->view('layout/header');
    $this->load->view('dealer/add');
    $this->load->view('layout/footer');
  }

  public function edit()
  {
    $id = $this->uri->segment(3);

    $data = [];

    $input = [];

    $data['emp'] = $this->db->get_where('users', ['user_id' => $id])->row_array();

    if ($this->input->post() != NULL) {
      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d H:i:s');

      $input = [

        'phone_no' => $this->input->post('phone_no'),
        'password' => ($this->input->post('password'))
      ];

      if (!empty($input)) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $input);

        $affectedRows = $this->db->affected_rows();

        if ($affectedRows) {
          $this->session->set_flashdata('msg', 'Dealer updated successfully');
          $this->session->set_flashdata('msg_class', 'success');
          redirect('dealer/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to update');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('dealer/edit');
        }
      }
    }

    $this->load->view('layout/header');
    $this->load->view('dealer/edit', $data);
    $this->load->view('layout/footer');
  }

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

  public function delete()
  {
    $id = $this->uri->segment(3);

    $this->db->delete('users', ['user_id' => $id]);


    $affectedRows = $this->db->affected_rows();

    // if ($affectedRows) {

    //   $this->db->delete('menu_permission', ['user_ref' => $id]);
    //   $this->session->set_flashdata('msg', 'Employee deleted successfully');
    //   $this->session->set_flashdata('msg_class', 'success');
    //   redirect('distributor/view');
    // } else {
    //   $this->session->set_flashdata('msg', 'Failed to delete');
    //   $this->session->set_flashdata('msg_class', 'danger');
    //   
    // }
    redirect('dealer/view');
    //}
  }
}
