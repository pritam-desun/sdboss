<?php
class Users extends CI_Controller
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
            $this->load->view('users/index');
        } else {
            $data = array(
                'email_id' => $this->input->post('email'),
                'password' => ($this->input->post('password'))
            );
            $result = $this->Login_model->validate_users($data);
            if (!empty($result)) {
                $session_data = array(
                    'user_id' => $result->user_id,
                    'user_type' => $result->user_type,
                    'user_name' => $result->user_name,
                    'full_name' => $result->full_name,
                    'email_id' => $result->email_id,
                    'phone_no' => $result->phone_no,
                    'assigned_by_id'  => $result->assigned_by_id,
                    'is_active' => $result->is_active,
                    'is_deleted' => $result->is_deleted,
                    'wallet' => $result->wallet
                );

                $this->session->set_userdata('user', $session_data);

                // echo "<pre>";
                // print_r($this->session->user);
                // die();
                // $user_type_id = $this->session->user['user_type'];
                // echo "usertype_id : " . $user_type_id . "<br>";
                // $user_is = $this->session->user['user_name'];
                // echo " user_name is :" . $user_is;
                // die;
                if ($this->session->user['user_type'] == 3) {

                    $ref_id = 3;
                    // die;
                    $mp = $this->db->get_where('menu_permission', ['user_ref' => $ref_id])->row_array();
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
                    // }
                } elseif ($this->session->user['user_type'] == 4) {

                    // echo "Dealer login success";
                    // die;
                    $ref_id = 4;
                    $mp = $this->db->get_where('menu_permission', ['user_ref' => $ref_id])->row_array();
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
                }
            } else {
                $this->session->set_flashdata('msg', 'Email/Password is incorrect');
                $this->session->set_flashdata('msg_class', 'danger');
                redirect("users/index");
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
