<?php
class Menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_authentic_user();
        $this->load->model('Master_model', 'master');
        $this->load->model('Bid_model', 'bid');
        //	$this->load->model('Money_model','money');
        // $this->load->helper('CommonFunction');
    }

    public function menu()
    {
        $input = [];

        $data = [];

        $data['parent_menus'] = $this->db->get_where('menu', ['is_parent' => 'Y'])->result_array();

        if ($this->input->post() != NULL) {
            $input = [
                'menu_name' => $this->input->post('menu_name'),
                'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $this->input->post('menu_name')))),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('menu_icon'),
                'is_parent' => ($this->input->post('parent_menu') != NULL) ? 'N' : 'Y',
                'parent_menu' => $this->input->post('parent_menu')
            ];

            // echo "<pre>"; print_r($input); die('Add menu');

            if (!empty($input)) {
                $insert = $this->db->insert('menu', $input);

                $this->session->set_flashdata('msg_menu', 'Menu added successfully');
                $this->session->set_flashdata('msg_class', 'success');

                redirect('menu/menu');
            } else {
                $this->session->set_flashdata('msg_menu', 'Error menu not added');
                $this->session->set_flashdata('msg_class', 'danger');
            }
        }

        $this->load->view('layout/header');
        $this->load->view('menu/menu', $data);
        $this->load->view('layout/footer');
    }

    public function action()
    {
        $data = [];
        $input = [];

        $data['menus'] = $this->db->get_where('menu', ['is_parent !=' => 'Y'])->result_array();

        if ($this->input->post() != NULL) {
            $input = [
                'menu_id' => $this->input->post('menu_id'),
                'action_name' => $this->input->post('action_name'),
                'action_url' => $this->input->post('action_url'),
                'alert_required' => $this->input->post('alert_required'),
                'icon' => $this->input->post('icon')
            ];

            // echo "<pre>"; print_r($input); die('Add menu');

            if (!empty($input)) {
                $insert = $this->db->insert('menu_action', $input);

                $this->session->set_flashdata('msg_action', 'Action added successfully');
                $this->session->set_flashdata('msg_class', 'success');

                redirect('menu/action');
            } else {
                $this->session->set_flashdata('msg_action', 'Error action not added');
                $this->session->set_flashdata('msg_class', 'danger');
            }
        }

        $this->load->view('layout/header');
        $this->load->view('menu/action', $data);
        $this->load->view('layout/footer');
    }

    public function menu_permission()
    {
        $data = [];
        $input = [];

        $data['users'] = $this->db->query("SELECT * FROM tbl_admin_login WHERE user_type NOT IN(1,2)")->result_array();

        $data['parent_menu'] = $this->db->get_where('menu', ['is_parent' => 'Y'])->result_array();
        // echo "<pre>";
        // print_r($data['users']);
        // print_r($data['parent_menu']);
        // die;
        if ($this->input->post() != NULL) {
            $input = [
                'user_ref' => $this->input->post('user_ref'),
                'parent_menus' => json_encode($this->input->post('parent_menu')),
                'child_menus' => json_encode($this->input->post('child_menu')),
                'actions' => json_encode($this->input->post('action'))
            ];

            // echo "<pre>"; print_r($input); die('admin input');

            $userExist = $this->db->get_where('menu_permission', ['user_ref' => $input['user_ref']])->row_array();

            if (!empty($userExist)) {
                $del = $this->db->delete('menu_permission', ['user_ref' => $input['user_ref']]);
            }
            if (!empty($input)) {
                $insert = $this->db->insert('menu_permission', $input);

                $affectedRows = $this->db->affected_rows();

                if ($affectedRows) {
                    redirect('employee/view');
                }
            }
        }

        if ($this->uri->segment(3) != NULL) {

            $id = $this->uri->segment(3);

            $data['admin'] = $this->db->get_where('tbl_admin_login', ['id' => $id])->row_array();
            $permission = $this->db->get_where('menu_permission', ['user_ref' => $data['admin']['user_type']])->row_array();

            $data['apm'] = json_decode($permission['parent_menus'], true);
            $data['acm'] = json_decode($permission['child_menus'], true);
            $data['aac'] = json_decode($permission['actions'], true);

            // echo "<pre>"; print_r($data['parent_menu']); die;

            // echo "<pre>"; print_r($permission); die;
        }


        $this->load->view('layout/header');
        $this->load->view('menu/menu_permission', $data);
        $this->load->view('layout/footer');
    }
}
