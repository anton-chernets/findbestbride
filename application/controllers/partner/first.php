<?php

Class First extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner/');
			return false;
		}
		
		$this->load->model('partner/partner_model', 'pModel');
		$this->lang->load('english/partner');
	}
	
	function index()
	{
		// новости на главной партнерки
		$news = $this->pModel->getNewsForPartners();
		
		$this->layout('partner', 'partner/main_view', array('news' => $news), $this->lang->line('partner_first_title'));
	}
	
	
	// выход из аккаунта
	
	function logout()
	{
		if ($this->session->userdata('partner_id') && $this->session->userdata('partner_pwd'))
		{
			$this->session->unset_userdata('partner_id');
			$this->session->unset_userdata('partner_pwd');
			
			redirect(base_url());
		}
		else
		{
			show_404();
		}
	}
}