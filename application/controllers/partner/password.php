<?php

Class Password extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner/');
			return false;
		}
		
		if ($this->partInfo['p_status'] == 1 || $this->partInfo['p_status'] == 0)
		{
			redirect(base_url() . 'partner/first/');
			return false;
		}
		
		$this->load->model('partner/partner_model', 'pModel');
		$this->lang->load('english/partner');
	}
	
	function index()
	{
		$resInfo = '';
		
		if ($this->input->post('save'))
		{
			$old = md5($this->input->post('old_pwd'));
			$new = md5($this->input->post('new_pwd'));
			
			if ($old == $this->session->userdata('partner_pwd'))
			{
				$newInfo['p_password'] = $new;
				
				$this->pModel->updateInformation($newInfo, $this->partId);
				
				$this->mainModel->insertLog($this->partId, '2', $this->lang->line('log_part_new_password'));
				
				$resInfo = array('result' => 'success', 'text' => 'Ваш пароль успешно изменен');
			}
			else
			{
				$resInfo = array('result' => 'error', 'text' => 'Неверно указан старый пароль');
			}
		}
		
		
		$this->layout('partner', 'partner/change_password_view', array('resInfo' => $resInfo), $this->lang->line('partner_password_title'));
	}
}