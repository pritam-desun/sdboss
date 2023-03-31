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
        $data['luckynumbers'] = $this->home->getLuckyNumber();
        $data['games'] = $this->home->getGame();

        /* echo "<pre>";
        print_r($data['luckynumbers']);
        die; */
        $this->load->view('websitelayout/header');
        $this->load->view('website/home', $data);
        $this->load->view('websitelayout/footer');
    }
}
