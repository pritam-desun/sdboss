<?php
class Distributor extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // check_authentic_user();
    $this->load->model('Master_model', 'master');
    $this->load->model('Bid_model', 'bid');
    //	$this->load->model('Money_model','money');
    // $this->load->helper('CommonFunction');
  }

  public function view()
  {
    $data = [];

    if ($this->session->user['user_type'] == 1) {
      //SELECT * FROM `tbl_admin_login` WHERE user_type = 3;
      $data['distributor'] = $this->db->query("SELECT users.*,  CONCAT((SELECT COUNT(u_total.user_id) FROM users as u_total WHERE u_total.assigned_by_id=users.user_id AND user_type=4)) as total FROM `users` WHERE user_type = 3 ORDER BY total DESC")->result_array();
      // $this->db->get_where("tbl_admin_login", ['user_type !=' => 1])->result_array();
    } else if ($this->session->user['user_type'] == 2) {
      $data['distributor'] = $this->db->query("SELECT * FROM `users` ORDER BY created_at DESC")->result_array();
      // $data['distributor'] = $this->db->get_where("tbl_admin_login", ['user_type' => 3])->result_array();
    }

    // echo "<pre>";
    // print_r($data);
    // die;
    $this->load->view('layout/header');
    $this->load->view('distributor/view', $data);
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
          'user_type' => 3,
          'user_name' => "distributor",
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
          redirect('distributor/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to add');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('distributor/add');
        }
      } elseif ($this->session->user['user_type'] == 2) {
        $assigned_id = $this->session->user['user_id'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s');

        $userdata = [
          'user_type' => 3,
          'user_name' => "distributor",
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
          redirect('distributor/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to add');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('distributor/add');
        }
      }
    }

    $this->load->view('layout/header');
    $this->load->view('distributor/add');
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
          $this->session->set_flashdata('msg', 'Distributor updated successfully');
          $this->session->set_flashdata('msg_class', 'success');
          redirect('distributor/view');
        } else {
          $this->session->set_flashdata('msg', 'Failed to update');
          $this->session->set_flashdata('msg_class', 'danger');
          redirect('distributor/edit');
        }
      }
    }

    $this->load->view('layout/header');
    $this->load->view('distributor/edit', $data);
    $this->load->view('layout/footer');
  }

  public function empStatus($status, $id)
  {
    //   $data = array(
    //     'id' => $id,
    //     'is_active' => $status
    //   );
    //   $where = array(
    //     'id' => $id
    //   );
    //   $result = $this->com->add($data, 'tbl_admin_login', $where);
    //   if ($result) {
    //     $this->session->set_flashdata('msg', 'Status changed successfully');
    //     $this->session->set_flashdata('msg_class', 'success');
    //   } else {
    //     $this->session->set_flashdata('msg', 'Failed to change status');
    //     $this->session->set_flashdata('msg_class', 'danger');
    //   }
    //   redirect('distributor/view');
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
    redirect('distributor/view');
  }
}
