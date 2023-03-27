<?php

class Game extends CI_Controller

{

    function __construct()
    {

        parent::__construct();

        check_authentic_user();

        $this->load->model('Game_model', 'game');
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            // print_r($_POST);die();

            $count = $this->com->get_count('game');

            $game_code = $this->com->get_code('G', $count);

            $data['name'] = strip_tags($this->input->post('name'));

            $data['gcode'] = $game_code;

            $data['cat_id'] = strip_tags($this->input->post('cat_id'));

            $data['slot_id'] = strip_tags($this->input->post('slot_id'));
            $data['minum_coin'] = strip_tags($this->input->post('minum_coin'));

            $data['status'] = 'Y';



            $this->form_validation->set_rules('name', 'Game Name', 'required');

            $this->form_validation->set_rules('cat_id', 'Game Category', 'required');

            $this->form_validation->set_rules('slot_id', 'Game Slot', 'required');
            $this->form_validation->set_rules('minum_coin', 'Minimum bidding amount', 'required');

            if (isset($_POST['play_day']) && !empty($_POST['play_day'])) {

                $data['play_day'] = json_encode($this->input->post('play_day'), true);
            } else {

                $this->form_validation->set_rules('play_day', 'Game Play', 'required');
            }

            if (empty($_FILES['image']['name'])) {

                $this->form_validation->set_rules('image', 'Game Image', 'required');
            }

            if ($this->form_validation->run() == TRUE) {

                $config['upload_path'] = 'uploads/game';

                $config['allowed_types'] = 'jpeg|PNG|jpg|png';

                $config['max_size'] = 0;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {

                    $this->session->set_flashdata('msg', $this->upload->display_errors());

                    $this->session->set_flashdata('msg_class', 'danger');

                    // redirect('master/category');

                } else {

                    $upload_data  = $this->upload->data();

                    $data['image'] = $upload_data['file_name'];

                    $result = $this->com->add($data, 'game');

                    if ($result) {

                        $this->session->set_flashdata('msg', 'Game added successfully');

                        $this->session->set_flashdata('msg_class', 'success');

                        redirect('game/admin');
                    } else {

                        $this->session->set_flashdata('msg', 'Failed to add');

                        $this->session->set_flashdata('msg_class', 'danger');

                        redirect('game/add');
                    }
                }
            }
        }

        $data['categories'] = $this->game->getCategory();

        $data['slot'] = $this->game->getSlot();

        $this->load->view('layout/header');

        $this->load->view('game/add', $data);

        $this->load->view('layout/footer');
    }

    public function admin()

    {
        $data['game'] = $this->game->get_data();

        //print_r($data);die();

        $this->load->view('layout/header');

        $this->load->view('game/admin', $data);

        $this->load->view('layout/footer');
    }

    public function status($status, $id)
    {

        $data = array(

            'id' => $id,

            'status' => $status

        );

        $where = array(

            'id' => $id

        );

        $result = $this->com->add($data, 'game', $where);

        if ($result) {

            $this->session->set_flashdata('msg', 'Status changed successfully');

            $this->session->set_flashdata('msg_class', 'success');
        } else {

            $this->session->set_flashdata('msg', 'Failed to change status');

            $this->session->set_flashdata('msg_class', 'danger');
        }

        redirect('game/admin');
    }

    public function edit($id)
    {



        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            //print_r($_POST);die();

            $data['id'] = $id;

            $data['name'] = strip_tags($this->input->post('name'));

            $data['cat_id'] = strip_tags($this->input->post('cat_id'));

            $data['slot_id'] = strip_tags($this->input->post('slot_id'));
            $data['minum_coin'] = strip_tags($this->input->post('minum_coin'));

            if (isset($_POST['play_day']) && !empty($_POST['play_day'])) {

                $data['play_day'] = json_encode($this->input->post('play_day'), true);
            } else {

                $this->form_validation->set_rules('play_day', 'Game Play', 'required');
            }

            $this->form_validation->set_rules('name', 'Game Name', 'required');

            $this->form_validation->set_rules('cat_id', 'Game Category', 'required');

            $this->form_validation->set_rules('slot_id', 'Game Slot', 'required');
            $this->form_validation->set_rules('minum_coin', 'Minimum bidding amount', 'required');



            if ($this->form_validation->run() == TRUE) {

                $where = array(

                    'id' => $id

                );

                if (!empty($_FILES['image']['name'])) {

                    $config['upload_path'] = 'uploads/game';

                    $config['allowed_types'] = 'jpeg|PNG|jpg|png';

                    $config['max_size'] = 0;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {

                        $this->session->set_flashdata('msg', $this->upload->display_errors());

                        $this->session->set_flashdata('msg_class', 'danger');

                        // redirect('master/category');

                    } else {

                        $upload_data  = $this->upload->data();

                        $data['image'] = $upload_data['file_name'];
                    }
                }

                $result = $this->com->add($data, 'game', $where);

                if ($result) {

                    $this->session->set_flashdata('msg', 'Game edited successfully');

                    $this->session->set_flashdata('msg_class', 'success');

                    redirect('game/admin');
                }
            }
        }

        // $data['game'] = $this->com->get_data_by_id('game', $id);

        // $data['categories'] = $this->game->getCategory();

        // $data['slot'] = $this->game->getSlot();

        $data['game'] = $this->db->get_where('game', ['id' => $id])->row_array();
        $data['categories'] = $this->db->get('category')->result_array();
        $data['slots'] = $this->db->get_where('slot', ['cat_id' => $data['game']['cat_id']])->result_array();

        $this->load->view('layout/header');

        $this->load->view('game/edit', $data);

        $this->load->view('layout/footer');
    }

    public function getSlot()
    {
        if(isset($_GET))
        {
            $slots = $this->db->get_where('slot', ['cat_id' => $_GET['cat']])->result_array();

            foreach($slots as $slot){
                echo "<option value='{$slot['id']}'>{$slot['start_time']} - {$slot['end_time']}</option>";
            }
        }
    }

    public function delete()
	{
		$id = $this->uri->segment(3);
        
		$this->db->delete('game', ['id' => $id]);

		$affectedRows = $this->db->affected_rows();

		if ($affectedRows) {
			redirect('game/admin');
		}
	}
}
