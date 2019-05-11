<?php

Class Finance extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner/');
			return false;
		}
		
		if ($this->partInfo['p_status'] != 2)
		{
			redirect(base_url() . 'partner/first/');
			return false;
		}
		
		$this->load->model('partner/partner_model', 'pModel');
		$this->lang->load('english/partner');
	}
	
	//// начисления
	function index()
	{		
		$time = time();
		$nowDay = date('d');
		$startTime = $time - (3600 * 24 * $nowDay);
		
		$all_money = $this->pModel->agencyMoney($this->partId, $startTime);
		$old_money = $this->pModel->agencyMoneyArchive($this->partId, $startTime);
		
		$this->layout('partner', 'partner/finance/money_view', array('money' => $all_money, 'old' => $old_money), $this->lang->line('partner_money_title'));
	}
	
	//// штрафы
	
	function penalty()
	{
		$allPenalty = $this->pModel->agencyPenalty($this->partId);
		$oldPenalty = $this->pModel->agencyPenaltyArchive($this->partId);
		
		$this->layout('partner', 'partner/finance/penalty_view', array('penalty' => $allPenalty, 'old' => $oldPenalty), $this->lang->line('partner_penalty_title'));
	}
}