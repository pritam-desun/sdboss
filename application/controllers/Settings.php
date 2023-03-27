<?php
class Settings extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_authentic_user();
	}

    public function index(){
       $data_send['settings']= $this->com->getSettings();
       $logo_thumb= $data_send['settings']->logo;
       $game_off_image = $data_send['settings']->game_off_image;

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data['id'] = $data_send['settings']->id;
            $data['app_name'] = strip_tags($this->input->post('app_name'));
            $data['commision'] = strip_tags($this->input->post('commision'));
            $data['email'] = strip_tags($this->input->post('email'));
            $data['mobile_number'] = strip_tags($this->input->post('mobile_number'));
            $data['whatsapp_number'] = strip_tags($this->input->post('whatsapp_number'));
            $data['min_deposit_amount'] = strip_tags($this->input->post('min_deposit_amount'));
            $data['min_withdraw_amount'] = strip_tags($this->input->post('min_withdraw_amount'));
            $data['rules_page_url'] = strip_tags($this->input->post('rules_page_url'));
            $data['share_msg'] = strip_tags($this->input->post('share_msg'));
            $data['game_off'] = $this->input->post('game_off') ? $this->input->post('game_off') : '0';
            $data['game_off_reason'] = strip_tags($this->input->post('game_off_reason'));
        }

        $this->form_validation->set_rules('app_name', 'App Name', 'required');
        $this->form_validation->set_rules('commision', 'Commision', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
        $this->form_validation->set_rules('whatsapp_number', 'Whats App Number', 'required');
        $this->form_validation->set_rules('min_deposit_amount', 'Minimum Deposit Amount', 'required');
        $this->form_validation->set_rules('min_withdraw_amount', 'Minimum Withdraw Amount', 'required');
        $this->form_validation->set_rules('rules_page_url', 'Game Rules & Regulations URL', 'required');
        $this->form_validation->set_rules('share_msg', 'App Sharing Message', 'required');

        // $this->form_validation->set_rules('rules', 'Game Rules', 'required');       

        //Handling logo upload
        if ($this->form_validation->run() == TRUE) {
            if(!empty($_FILES['image']['name'])){            
                @unlink(base_url().'uploads/logo'.$logo_thumb);

                $config['upload_path'] = 'uploads/logo';
                $config['allowed_types'] = 'jpeg|PNG|jpg|png';
                $config['max_size'] = 0;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_flashdata('msg', $this->upload->display_errors());
                    $this->session->set_flashdata('msg_class', 'danger');
                }
                else {
                    $upload_data  = $this->upload->data();
                    $data['logo'] = $upload_data['file_name'];               
                }
            }

                //Handling game off image upload
                if(!empty($_FILES['game_off_image']['name'])){            
                    @unlink(base_url().'uploads/logo'.$game_off_image);
    
                    $config['upload_path'] = 'uploads/logo';
                    $config['allowed_types'] = 'jpeg|PNG|jpg|png';
                    $config['max_size'] = 0;
    
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('game_off_image')) {
                        $this->session->set_flashdata('msg', $this->upload->display_errors());
                        $this->session->set_flashdata('msg_class', 'danger');
                    }
                    else {
                        $upload_data  = $this->upload->data();
                        $data['game_off_image'] = $upload_data['file_name'];               
                    }
                }    

            $where = array('id'=>$data['id']);
            $result = $this->com->add($data, 'settings', $where);

            if($result){
                
                if($data['game_off'] == '1'){
                    $game_status = array('status'=> 'N');
                }else{
                    $game_status = array('status'=> 'Y');
                }

                $this->com->updateAll("category",$game_status);
                $this->session->set_flashdata('msg', 'Settings edited successfully');
                $this->session->set_flashdata('msg_class', 'success');
                redirect('settings');
            }
            else{
                $this->session->set_flashdata('msg', 'Failed to add');
                $this->session->set_flashdata('msg_class', 'danger');
                redirect('settings');
            }
        }
  
        $this->load->view('layout/header');
		$this->load->view('settings/index',$data_send);
		$this->load->view('layout/footer');
    }
}