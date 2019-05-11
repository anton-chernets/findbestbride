<?php

Class Men_profiles extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('assistant', 'pagination'));
		
		$this->load->model('search_model', 'sModel');
		$this->lang->load($this->language . '/search');
		
	}
	
	function index()
	{
		/***** PAGINATION *****/
		$pag['base_url'] 	= base_url() . 'men_profiles/index/';
		$pag['total_rows'] 	= $this->sModel->allMenProfilesCount();
		$pag['per_page']	= 15;
		$pag['num_links']	= '1';
		$pag['full_tag_open'] = '<div id="page">';
		$pag['full_tag_close']= '</div>';
		$pag['next_link']	= 'Next';
		$pag['prev_link']	= 'Prev';
		$pag['cur_tag_open'] = '<a href="#." class="numb"><p><b>';
		$pag['cur_tag_close']= '</b></p></a>';

		$this->pagination->initialize($pag);
		
		$links = $this->pagination->create_links();
		
		$pageNow = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : '0';
		
		$list = $this->sModel->getAllMenProfiles($pageNow, $pag['per_page']);
		
		$this->layout('content', 'content/men_profiles_view', array('links' => $links, 'list' => $list), 'Men profiles');
	}
}