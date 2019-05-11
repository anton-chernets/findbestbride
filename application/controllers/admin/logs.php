<?php

Class Logs extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			return false;
		}
		
		$this->load->model('admin/admin_model', 'aModel');
		$this->lang->load('english/admin');
	}
	
	// удаление всех логов
	function delete()
	{
		//echo 'Deleting logs...';
		
		$this->aModel->deleteAllLogs();
		
		redirect(base_url() . 'admin/logs/ankets/');
	}
	
	function ankets()
	{
		$list = $this->aModel->getAnketsLogs();
		
		$this->layout('admin', 'admin/logs/ankets_view', array('list' => $list), $this->lang->line('logs_title'));
	}
	
	function partners()
	{
		$list = $this->aModel->getAnketsLogs(2);
		
		$this->layout('admin', 'admin/logs/partners_view', array('list' => $list), $this->lang->line('logs_p_title'));
	}
}