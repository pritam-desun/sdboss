<?php
class Employee extends CI_Controller
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
            // $sql = "SELECT * FROM tbl_admin_login WHERE user_type != 1 GROUP BY user_code";
            $data['employee'] = $this->db->query("SELECT * FROM tbl_admin_login WHERE user_type != 1")->result_array();
            //$data['employee'] = $this->db->get_where("tbl_admin_login", ['user_type !=' => 1])->result_array();
        } else if ($this->session->user['user_type'] == 2) {
            $data['employee'] = $this->db->get_where("tbl_admin_login", ['user_type' => 3])->result_array();
        }
        $this->load->view('layout/header');
        $this->load->view('employee/view', $data);
        $this->load->view('layout/footer');
    }

    public function add()
    {
        $input = [];

        if ($this->input->post() != NULL) {

            $emp = $this->db->query("SELECT * FROM tbl_admin_login WHERE user_type = 2 ORDER BY id DESC LIMIT 1")->result_array();

            $userCode = "";

            if (!empty($emp[0]['user_code'])) {
                $emp_user_code = explode('_', $emp[0]['user_code']);

                $Code = (int)$emp_user_code[1] + 1;

                $userCode = "Emp_" . str_pad($Code, 3, "0", STR_PAD_LEFT);
            } else {
                $userCode = "Emp_001";
            }

            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d H:i:s');

            $input = [
                'user_code' => $userCode,
                'full_name' => $this->input->post('full_name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'password' => md5($this->input->post('password')),
                'user_type' => 3,
                'created_by' => 1,
                'created_on' => $date
            ];

            $insert = $this->db->insert('tbl_admin_login', $input);

            $affectedRows = $this->db->affected_rows();

            if ($affectedRows) {
                $this->session->set_flashdata('msg', 'Employee added successfully');
                $this->session->set_flashdata('msg_class', 'success');
                redirect('employee/view');
            } else {
                $this->session->set_flashdata('msg', 'Failed to add');
                $this->session->set_flashdata('msg_class', 'danger');
                redirect('employee/add');
            }
        }

        $this->load->view('layout/header');
        $this->load->view('employee/add');
        $this->load->view('layout/footer');
    }

    public function edit()
    {
        $id = $this->uri->segment(3);

        $data = [];

        $input = [];

        $data['emp'] = $this->db->get_where('tbl_admin_login', ['id' => $id])->row_array();

        if ($this->input->post() != NULL) {
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d H:i:s');

            $input = [
                'full_name' => $this->input->post('full_name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'password' => ($this->input->post('password') == $data['emp']['password']) ? $data['emp']['password'] : md5($this->input->post('password')),
                'updated_by' => 1,
                'updated_on' => $date
            ];

            // echo "<pre>"; print_r($data['emp']);

            // echo "<pre>"; print_r($input); die('input');

            if (!empty($input)) {
                $this->db->where('id', $id);
                $this->db->update('tbl_admin_login', $input);

                $affectedRows = $this->db->affected_rows();

                if ($affectedRows) {
                    $this->session->set_flashdata('msg', 'Employee updated successfully');
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('employee/view');
                } else {
                    $this->session->set_flashdata('msg', 'Failed to update');
                    $this->session->set_flashdata('msg_class', 'danger');
                    redirect('employee/edit');
                }
            }
        }

        $this->load->view('layout/header');
        $this->load->view('employee/edit', $data);
        $this->load->view('layout/footer');
    }

    public function empStatus($status, $id)
    {
        $data = array(
            'id' => $id,
            'is_active' => $status
        );
        $where = array(
            'id' => $id
        );
        $result = $this->com->add($data, 'tbl_admin_login', $where);
        if ($result) {
            $this->session->set_flashdata('msg', 'Status changed successfully');
            $this->session->set_flashdata('msg_class', 'success');
        } else {
            $this->session->set_flashdata('msg', 'Failed to change status');
            $this->session->set_flashdata('msg_class', 'danger');
        }
        redirect('employee/view');
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        $this->db->delete('tbl_admin_login', ['id' => $id]);

        $affectedRows = $this->db->affected_rows();

        if ($affectedRows) {

            $this->db->delete('menu_permission', ['user_ref' => $id]);
            $this->session->set_flashdata('msg', 'Employee deleted successfully');
            $this->session->set_flashdata('msg_class', 'success');
            redirect('employee/view');
        } else {
            $this->session->set_flashdata('msg', 'Failed to delete');
            $this->session->set_flashdata('msg_class', 'danger');
            redirect('employee/view');
        }
    }
}
