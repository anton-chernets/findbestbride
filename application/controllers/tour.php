<?php

Class Tour extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth != true)
		{
			show_404();
			return false;
		}
		
		$this->load->model('user_model', 'user');
		$this->lang->load($this->language . '/profile');
		$this->load->library('pagination');
	}
	
	function index($id)
	{
		$info = $this->mainModel->getUserProfile($id);
		$is_tours = $this->user->isAgencyHaveRt($info['is_agency']);

		if ($id && $info != false && $is_tours != false)
		{
			/***** PAGINATION *****/
			$pag['base_url'] 	= base_url() . 'tour/index/' . $id . '/';
			$pag['uri_segment']	= 4;
			$pag['total_rows'] 	= $this->user->allToursOfAgency($info['is_agency']);
			$pag['per_page']	= '1';
			$pag['num_links']	= '1';
			$pag['full_tag_open'] = '<div id="page">';
			$pag['full_tag_close']= '</div>';
			$pag['next_link']	= 'Next tour';
			$pag['prev_link']	= 'Prev tour';
			$pag['cur_tag_open'] = '<a href="#." class="numb"><p><b>';
			$pag['cur_tag_close']= '</b></p></a>';

			$this->pagination->initialize($pag);
		
			$links = $this->pagination->create_links();
		
			$pageNow = ($this->uri->segment(4)) ? (int)$this->uri->segment(4) : '0';
		
			$list = $this->user->getTourList($info['is_agency'], $pageNow, $pag['per_page']);
			
			
			$this->layout('profile', 'user/romance_tour_invite', array('info' => $info, 'list' => $list, 'links' => $links), $this->lang->line('rt_title'));
		}
		else
		{
			show_404();
		}
	}
	
	function ajax($action)
	{
		if ($action == 'choose')
		{
			if (IS_AJAX && $this->input->post('tour') && $this->input->post('id'))
			{
				$this->user->sendRt($this->selfId, $this->input->post('id'), $this->input->post('tour'));
				$this->mainModel->insertLog($this->selfId, '1', sprintf($this->lang->line('log_choose_tour'), $this->input->post('id')));
				
				echo json_encode(array('result' => 'success'));
			}
		}
	}
}