<?php
class Master extends CI_Controller
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

	public function news()
	{
		$data['newses'] = $this->master->getNews();
		$data['status'] = $this->config->item('y_status');
		$this->form_validation->set_rules('news', 'News', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layout/header');
			$this->load->view('master/news/view', $data);
			$this->load->view('layout/footer');
		} else {
			$data = array(
				'id' => $this->input->post('id'),
				'news' => $this->input->post('news')
			);
			$where = array(
				'id' => $this->input->post('id')
			);
			$result = $this->com->add($data, 'news_update', $where);
			if ($result) {
				$this->session->set_flashdata('msg', 'News changed successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('master/news');
			} else {
				$this->session->set_flashdata('msg', 'Failed to change');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/news');
			}
		}
	}

	public function delNews()
	{
		$id = $this->uri->segment(3);

		$this->db->delete('news_update', ['id' => $id]);

		$affectedRows = $this->db->affected_rows();

		if ($affectedRows) {
			redirect('master/news');
		}
	}

	public function addNews()
	{
		$this->form_validation->set_rules('news', 'News', 'required');

		if ($this->form_validation->run() != FALSE) {
			$data = array(
				'news' => $this->input->post('news')
			);
			$result = $this->com->add($data, 'news_update');
			if ($result) {
				$this->session->set_flashdata('msg', 'News added successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('master/news');
			} else {
				$this->session->set_flashdata('msg', 'Failed to add');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/news');
			}
		} else {
			$this->session->set_flashdata('msg', 'News field is required');
			$this->session->set_flashdata('msg_class', 'warning');
			redirect('master/news');
		}
	}

	public function newsStatus($status, $id)
	{
		$data = array(
			'id' => $id,
			'status' => $status
		);
		$where = array(
			'id' => $id
		);
		$result = $this->com->add($data, 'news_update', $where);
		if ($result) {
			$this->session->set_flashdata('msg', 'Status changed successfully');
			$this->session->set_flashdata('msg_class', 'success');
		} else {
			$this->session->set_flashdata('msg', 'Failed to change status');
			$this->session->set_flashdata('msg_class', 'danger');
		}
		redirect('master/news');
	}

	public function slider()
	{
		$data['sliders'] = $this->master->getSlider();
		$data['status'] = $this->config->item('y_status');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($_FILES['attachment']['name'] != '') {

				$config['upload_path'] = 'uploads/carousel';
				$config['allowed_types'] = 'jpeg|PNG|jpg|png';
				$config['max_size'] = 0;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('attachment')) {
					$this->session->set_flashdata('msg', $this->upload->display_errors());
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('master/slider');
				} else {
					$upload_data  = $this->upload->data();
					$where = array(
						'id' => $this->input->post('id')
					);
					$data = array(
						'id' => $this->input->post('id'),
						'attachment' => $upload_data['file_name']
					);
				}
				$result = $this->com->add($data, 'slider', $where);
				if ($result) {
					$this->session->set_flashdata('msg', 'Image changed successfully');
					$this->session->set_flashdata('msg_class', 'success');
					redirect('master/slider');
				} else {
					$this->session->set_flashdata('msg', 'Failed to change image');
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('master/slider');
				}
			}
		}
		$this->load->view('layout/header');
		$this->load->view('master/slider/view', $data);
		$this->load->view('layout/footer');
	}

	public function deleteSlider()
	{
		$id = $this->uri->segment(3);

		$this->db->delete('slider', ['id' => $id]);

		$affectedRows = $this->db->affected_rows();

		if ($affectedRows) {
			redirect('master/slider');
		}
	}


	public function addSlider()
	{
		if ($_FILES['attachment']['name'] != '') {

			$config['upload_path'] = 'uploads/carousel';
			$config['allowed_types'] = 'jpeg|PNG|jpg|png';
			$config['max_size'] = 0;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('attachment')) {
				$this->session->set_flashdata('msg', $this->upload->display_errors());
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/slider');
			} else {
				$upload_data  = $this->upload->data();
				$data = array(
					'attachment' => $upload_data['file_name']
				);
				$result = $this->com->add($data, 'slider');
				if ($result) {
					$this->session->set_flashdata('msg', 'Image added successfully');
					$this->session->set_flashdata('msg_class', 'success');
					redirect('master/slider');
				} else {
					$this->session->set_flashdata('msg', 'Failed to add');
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('master/slider');
				}
			}
		} else {
			$this->session->set_flashdata('msg', 'Attachment can not be empty');
			$this->session->set_flashdata('msg_class', 'danger');
			redirect('master/slider');
		}
	}

	public function sliderStatus($status, $id)
	{
		$data = array(
			'id' => $id,
			'status' => $status
		);
		$where = array(
			'id' => $id
		);
		$result = $this->com->add($data, 'slider', $where);
		if ($result) {
			$this->session->set_flashdata('msg', 'Status changed successfully');
			$this->session->set_flashdata('msg_class', 'success');
		} else {
			$this->session->set_flashdata('msg', 'Failed to change status');
			$this->session->set_flashdata('msg_class', 'danger');
		}
		redirect('master/slider');
	}

	public function category()
	{
		$data['categories'] = $this->master->getCategory();
		$data['status'] = $this->config->item('y_status');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$data = array(
				'id' => $this->input->post('id'),
				'cat_name' => $this->input->post('cat_name'),
				'label' => $this->input->post('label'),
			);
			$where = array(
				'id' => $this->input->post('id')
			);
			if ($_FILES['attachment']['name'] != '') {

				$config['upload_path'] = 'uploads/category';
				$config['allowed_types'] = 'jpeg|PNG|jpg|png';
				$config['max_size'] = 0;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('attachment')) {
					$this->session->set_flashdata('msg', $this->upload->display_errors());
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('master/slider');
				} else {
					$upload_data  = $this->upload->data();

					$data['image'] = $upload_data['file_name'];
				}
			}
			$result = $this->com->add($data, 'category', $where);

			// $res = $this->com->add(['url' => 'result/' . $this->input->post('id'), 'is_parent' => 'N', 'parent_menu' => '7', 'Type' => 'category', 'ref_id' => $this->input->post('id')], 'menu');

			// $res = $this->com->add(['url' => 'result/' . $this->input->post('id'), 'is_parent' => 'N', 'parent_menu' => '7', 'Type' => 'category'], 'menu', ['ref_id' => $this->input->post('id')]);

			if ($result) {
				$this->session->set_flashdata('msg', 'Category updated successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('master/category');
			} else {
				$this->session->set_flashdata('msg', 'Failed to update');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/category');
			}
		}

		$this->load->view('layout/header');
		$this->load->view('master/category/view', $data);
		$this->load->view('layout/footer');
	}

	public function deleteCategory()
	{
		$id = $this->uri->segment(3);

		$this->db->delete('news_update', ['id' => $id]);

		$affectedRows = $this->db->affected_rows();

		if ($affectedRows) {
			redirect('master/category');
		}
	}

	public function addCat()
	{
		if ($_FILES['attachment']['name'] != '') {

			$config['upload_path'] = 'uploads/category';
			$config['allowed_types'] = 'jpeg|PNG|jpg|png';
			$config['max_size'] = 0;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('attachment')) {
				$this->session->set_flashdata('msg', $this->upload->display_errors());
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/category');
			} else {
				$upload_data  = $this->upload->data();
				$data = array(
					'cat_name' => $this->input->post('cat_name'),
					'label' => $this->input->post('label'),
					'image' => $upload_data['file_name']
				);
				$result = $this->com->add($data, 'category');
				if ($result) {

					$id = $this->db->get_where('category', ['cat_name' => $data['cat_name']])->row_array();

					$res = $this->db->insert('menu', ['url' => 'result/' . $id['id'], 'is_parent' => 'N', 'parent_menu' => '7', 'Type' => 'category', 'ref_id' => $id['id']]);

					if ($res) {
						$this->session->set_flashdata('msg', 'Category added successfully');
						$this->session->set_flashdata('msg_class', 'success');
						redirect('master/category');
					}
					// else {
					// 	die("failed to insert in menu tbl");
					// }
				} else {
					$this->session->set_flashdata('msg', 'Failed to add');
					$this->session->set_flashdata('msg_class', 'danger');
					redirect('master/category');
				}
			}
		} else {
			$this->session->set_flashdata('msg', 'Attachment can not be empty');
			$this->session->set_flashdata('msg_class', 'danger');
			redirect('master/category');
		}
	}

	public function catStatus($status, $id)
	{
		$data = array(
			'id' => $id,
			'status' => $status
		);
		$where = array(
			'id' => $id
		);
		$result = $this->com->add($data, 'category', $where);
		if ($result) {
			$this->session->set_flashdata('msg', 'Status changed successfully');
			$this->session->set_flashdata('msg_class', 'success');
		} else {
			$this->session->set_flashdata('msg', 'Failed to change status');
			$this->session->set_flashdata('msg_class', 'danger');
		}
		redirect('master/category');
	}

	public function slot()
	{
		$data['slots'] = $this->master->getSlots();
		$data['status'] = $this->config->item('y_status');
		$data['categories'] = $this->bid->getCategory();

		$sql = "SELECT slot.*,category.cat_name FROM `slot` left join category on category.id = slot.cat_id";
		$query = $this->db->query($sql);
		$data['slots_with_cat_name'] = $query->result_array();

		$this->form_validation->set_rules('start_time', 'Start Time', 'required');
		$this->form_validation->set_rules('end_time', 'End Time', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layout/header');
			$this->load->view('master/slot/view', $data);
			$this->load->view('layout/footer');
		} else {
			$data = array(
				'id' => $this->input->post('id'),
				'start_time' => $this->input->post('start_time'),
				'end_time' => $this->input->post('end_time'),
				'cat_id' => $this->input->post('cat_id')
			);
			$where = array(
				'id' => $this->input->post('id')
			);
			$result = $this->com->add($data, 'slot', $where);
			if ($result) {
				$this->session->set_flashdata('msg', 'Slot updated successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('master/slot');
			} else {
				$this->session->set_flashdata('msg', 'Failed to update');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/slot');
			}
		}
	}

	public function deleteSlot()
	{
		$id = $this->uri->segment(3);

		$this->db->delete('slider', ['id' => $id]);

		$affectedRows = $this->db->affected_rows();

		if ($affectedRows) {
			redirect('master/slider');
		}
	}

	public function addSlot()
	{
		$this->form_validation->set_rules('start_time', 'Start Time', 'required');
		$this->form_validation->set_rules('end_time', 'End Time', 'required');
		$this->form_validation->set_rules('cat_id', 'Category', 'required');

		if ($this->form_validation->run() != FALSE) {
			$data = array(
				'start_time' => $this->input->post('start_time'),
				'end_time' => $this->input->post('end_time'),
				'cat_id' => $this->input->post('cat_id')
			);
			$result = $this->com->add($data, 'slot');
			if ($result) {
				$this->session->set_flashdata('msg', 'Slot added successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('master/slot');
			} else {
				$this->session->set_flashdata('msg', 'Failed to add');
				$this->session->set_flashdata('msg_class', 'danger');
				redirect('master/slot');
			}
		} else {
			$this->session->set_flashdata('msg', 'All field is required');
			$this->session->set_flashdata('msg_class', 'warning');
			redirect('master/slot');
		}
	}

	public function slotStatus($status, $id)
	{
		$data = array(
			'id' => $id,
			'status' => $status
		);
		$where = array(
			'id' => $id
		);
		$result = $this->com->add($data, 'slot', $where);
		if ($result) {
			$this->session->set_flashdata('msg', 'Status changed successfully');
			$this->session->set_flashdata('msg_class', 'success');
		} else {
			$this->session->set_flashdata('msg', 'Failed to change status');
			$this->session->set_flashdata('msg_class', 'danger');
		}
		redirect('master/slot');
	}
	public function price()
	{
		$data['price'] = $this->master->getprice();
		//print_r($data);die();
		$this->load->view('layout/header');
		$this->load->view('master/winning_price/view', $data);
		$this->load->view('layout/footer');
	}
	public function delPrice()
	{
		$id = $this->uri->segment(3);

		// echo $id; die;

		$this->db->delete('wining_price', ['id' => $id]);

		$affectedRows = $this->db->affected_rows();

		if ($affectedRows) {
			redirect('master/price');
		}
	}
	public function addprice()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			//print_r($_POST);die();
			$this->form_validation->set_rules('cat_id', 'Category', 'required');
			$this->form_validation->set_rules('game_type', 'Game Type', 'required');
			$this->form_validation->set_rules('type', 'Calculation Type', 'required');
			$this->form_validation->set_rules('value', 'Value', 'required');
			if ($this->form_validation->run() == TRUE) {
				$data_check['cat_id'] = $this->input->post('cat_id');
				$data_check['game_type'] = $this->input->post('game_type');
				$check = $this->master->checkPrice($data_check);
				if (empty($check)) {
					$data_insert = array(
						'cat_id' => strip_tags($this->input->post('cat_id')),
						'game_type' => strip_tags($this->input->post('game_type')),
						'type' => strip_tags($this->input->post('type')),
						'value' => strip_tags($this->input->post('value'))
					);
					$result = $this->com->add($data_insert, 'wining_price');
					$this->session->set_flashdata('msg', 'Winning Price added successfully');
					$this->session->set_flashdata('msg_class', 'success');
					redirect('master/price');
				} else {
					$this->session->set_flashdata('msg', 'This Category and type is added');
					$this->session->set_flashdata('msg_class', 'danger');
				}
			}
		}
		$data['categories'] = $this->master->getactiveCategory();
		$data['type'] = $this->config->item('game_type');
		$this->load->view('layout/header');
		$this->load->view('master/winning_price/add', $data);
		$this->load->view('layout/footer');
	}
	public function editprice($id)
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			//print_r($_POST);die();
			$this->form_validation->set_rules('cat_id', 'Category', 'required');
			$this->form_validation->set_rules('game_type', 'Game Type', 'required');
			$this->form_validation->set_rules('type', 'Calculation Type', 'required');
			$this->form_validation->set_rules('value', 'Value', 'required');
			if ($this->form_validation->run() == TRUE) {
				$data_update = array(
					'id' => $id,
					'cat_id' => strip_tags($this->input->post('cat_id')),
					'game_type' => strip_tags($this->input->post('game_type')),
					'type' => strip_tags($this->input->post('type')),
					'value' => strip_tags($this->input->post('value'))
				);
				$where = "id=" . $id;
				$result = $this->com->add($data_update, 'wining_price', $where);
				$this->session->set_flashdata('msg', 'Winning Price Updated successfully');
				$this->session->set_flashdata('msg_class', 'success');
				redirect('master/price');
			} else {
				$this->session->set_flashdata('msg', 'This Category and type is added');
				$this->session->set_flashdata('msg_class', 'danger');
			}
		}
		$data['price'] = $this->com->get_data_by_id('wining_price', $id);
		$data['categories'] = $this->master->getactiveCategory();
		$data['type'] = $this->config->item('game_type');
		$this->load->view('layout/header');
		$this->load->view('master/winning_price/edit', $data);
		$this->load->view('layout/footer');
	}
}
