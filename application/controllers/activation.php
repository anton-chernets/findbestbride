<?php

Class Activation extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->lang->load($this->language . '/register');
	}
	
	function index($code)
	{
		if ($code)
		{
			$check_code = $this->mainModel->isExistActivationCode($code);
			if ($check_code != false)
			{
				$this->mainModel->activateAccount($check_code);
				
				$this->layout('content', 'content/activate_ok_view', array(), $this->lang->line('activate_title'));
			}
			else
			{
				show_error('This activation code does not exist');
			}
		}
		else
		{
			show_404();
		}
	}
}