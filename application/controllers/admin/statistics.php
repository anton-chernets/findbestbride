<?php

Class Statistics extends MY_Controller
{
	var $default = 1;
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			die;
		}
		
		$this->lang->load('english/admin');
		$this->load->model('admin/statistics_model', 'statModel');
	}
	
	function index()
	{
		if ($this->input->post('type'))
		{
			$this->default = $this->input->post('type');
		}
		
		$this->layout('admin', 'admin/statistics_view', array(
				'type_now'	=> $this->default,
				'register'	=> $this->statModel->getRegister($this->default),
				'messages'	=> $this->statModel->getMessages($this->default),
				'chat'		=> $this->statModel->getChat($this->default),
				'photo'		=> $this->statModel->getPhotoVideo($this->default),
				'gifts'		=> $this->statModel->getGifts($this->default),
				'credits'	=> $this->statModel->getCredits($this->default),
				'logs'		=> $this->statModel->getLogs($this->default),
				'partner'	=> $this->statModel->getPartner($this->default)
		), $this->lang->line('stat_title'));
	}
}