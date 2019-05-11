<?php

Class Page extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner/');
			return false;
		}
		
		$this->lang->load('english/partner');
	}
	
	function agreement()
	{
		//$this->output->cache('500');
		
		$this->layout('partner', 'partner/agreement_view', array(), $this->lang->line('partner_agreement_title'));
	}
	
	function rules()
	{
		//$this->output->cache('500');
		
		$this->layout('partner', 'partner/rules_view', array(), $this->lang->line('partner_rules_title'));
	}
}