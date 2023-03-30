<?php
class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->form_validation->set_message('rquired', 'This field is required');
        $this->load->model('Home_model', 'home'); // home model load
    }

    public function index()
    {
        $this->load->view('websitelayout/header');
        $this->load->view('website/home');
        $this->load->view('websitelayout/footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
