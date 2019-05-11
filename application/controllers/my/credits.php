<?php

Class Credits extends MY_Controller
{
	var $allowAmount = array('20', '60', '120', '250', '350', '500', '750');
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth != true)
		{
			redirect(base_url());
			exit;
		}
		
		if ($this->userInfo['sex'] != 1)
		{
			redirect(base_url() . 'my/profile/');
			exit;
		}
		
		$this->lang->load($this->language . '/payments');
		$this->load->model('payment_model', 'payModel');
	}
	
	function index()
	{
		$this->layout('profile', 'profile/credits_view', array(), $this->lang->line('title'));
	}
	
	function buy($amount)
	{
		if ($amount && in_array($amount, $this->allowAmount))
		{
			$form = '';
			
			$this->layout('profile', 'profile/credits_buy_view', array('form' => $form), $this->lang->line('buy_title'));
		}
		else
		{
			show_404();
		}
	}
	
	function success()
	{
		$this->mainModel->insertLog($this->selfId, '1', $this->lang->line('log_buy_creds'));
		$this->layout('profile', 'profile/credits_success_view', array(), $this->lang->line('title'));
	}
}