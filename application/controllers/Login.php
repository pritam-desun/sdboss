<?php
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->form_validation->set_message('rquired', 'This field is required');
        $this->load->model('Login_model');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/index');
        } else {
            $data = array(
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password'))
            );
            $result = $this->Login_model->validate_login($data);
            if (!empty($result)) {
                $session_data = array(
                    'id' => $result->id,
                    'user_code' => $result->user_code,
                    'username' => $result->username,
                    'full_name' => $result->full_name,
                    'email' => $result->email,
                    'mobile' => $result->mobile,
                    'image'  => $result->image,
                    'user_type' => $result->user_type,
                    'is_active' => $result->is_active,
                    'is_deleted' => $result->is_deleted,
                );

                $this->session->set_userdata('user', $session_data);

                // echo "<pre>";
                // print_r($this->session->user);
                // die('user');

                $mp = $this->db->get_where('menu_permission', ['user_ref' => $this->session->user['id']])->row_array();

                // echo "<pre>"; print_r($mp); die('user');

                if (!empty($mp)) {

                    $pms = json_decode($mp['parent_menus'], true);

                    $pm = implode(',', $pms);

                    $cm = json_decode($mp['child_menus'], true);

                    if ($mp['actions'] != NULL) {
                        $ac = json_decode($mp['actions'], true);
                    } else {
                        $ac = NULL;
                    }

                    $session_data = array_merge($session_data, [
                        'pm' => $pm,
                        'cm' => $cm,
                        'ac' => $ac
                    ]);
                }

                $this->session->set_userdata('user', $session_data);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('msg', 'Email/Password is incorrect');
                $this->session->set_flashdata('msg_class', 'danger');
                redirect("login");
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
