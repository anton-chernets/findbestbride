<?php

Class Fin extends MY_Controller
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
		$this->load->model('admin/finance_model');
		$this->lang->load('english/admin');
	}
	
	
	function index()
	{
		if ($this->input->post('date_01') && $this->input->post('date_02'))
		{
			$startDate = explode('/', $this->input->post('date_01'));
			$start = strtotime($startDate[1] . '-' . $startDate[0] . '-' . $startDate[2]);
			
			$endDate = explode('/', $this->input->post('date_02'));
			$end = strtotime($endDate[1] . '-' . $endDate[0] . '-' . $endDate[2]);
			
			if ($this->input->post('p_id') && $this->input->post('p_id') > '0')
			{
				$partner = $this->input->post('p_id');
			}
			else
			{
				$partner = false;
			}
			
			if ($end < $start)
			{
				$end = '';
			}	
		}
		else
		{
			$startDate = date('m-Y');
			$start = strtotime('01-' . $startDate);
		
			$year = (date('Y') + 5);
			$end   = strtotime('01-01-' . $year);
			
			$partner = false;
		}
		
		$list = $this->aModel->getPartnerMoney($start, $end, $partner);
		
		$this->layout('admin', 'admin/finance/add_money_view', array('list' => $list), $this->lang->line('fin_add_title'));
	}
	
	
	function penalty()
	{
		if ($this->input->post('date_01') && $this->input->post('date_02'))
		{
			$startDate = explode('/', $this->input->post('date_01'));
			$start = strtotime($startDate[1] . '-' . $startDate[0] . '-' . $startDate[2]);
			
			$endDate = explode('/', $this->input->post('date_02'));
			$end = strtotime($endDate[1] . '-' . $endDate[0] . '-' . $endDate[2]);
			
			if ($this->input->post('p_id') && $this->input->post('p_id') > '0')
			{
				$partner = $this->input->post('p_id');
			}
			else
			{
				$partner = false;
			}
			
			if ($end < $start)
			{
				$end = '';
			}	
		}
		else
		{
			$startDate = date('m-Y');
			$start = strtotime('01-' . $startDate);
		
			$year = (date('Y') + 5);
			$end   = strtotime('01-01-' . $year);
			
			$partner = false;
		}
		
		$list = $this->aModel->getPartnerPenalty($start, $end, $partner);
		
		$this->layout('admin', 'admin/finance/penalty_view', array('list' => $list), $this->lang->line('fin_penalty_title'));
		
	}
	
	function report()
	{
		if ($this->input->post('new'))
		{
			$startDate = explode('/', $this->input->post('date_01'));
			$start = strtotime($startDate[1] . '-' . $startDate[0] . '-' . $startDate[2]);
			
			$endDate = explode('/', $this->input->post('date_02'));
			$end = strtotime($endDate[1] . '-' . $endDate[0] . '-' . $endDate[2]);
			
			$partner = $this->input->post('p_id');
			
			$list = $this->aModel->getPartnerMoney($start, $end, $partner);
			$pen = $this->aModel->getPartnerPenalty($start, $end, $partner);
			
			$this->layout('admin', 'admin/finance/report_view', array('list' => $list, 'pen' => $pen), $this->lang->line('fin_report_title'));
			
			return false;
		}
		
		$this->layout('admin', 'admin/finance/report_first_view', array(), $this->lang->line('fin_report_title'));
	}
	
	function man()
	{
		if ($this->input->post())
		{
			$man_id = (int)$this->input->post('u_id');
			
			$buy_list = $this->finance_model->getManBuyList($man_id);
			$sell_list = $this->finance_model->getManSellList($man_id);
			
			$this->layout('admin', 'admin/finance/man_list_view', array('buy_list' => $buy_list, 'sell_list' => $sell_list), $this->lang->line('fin_man_title'));
			
			return false;
		}
		
		$this->layout('admin', 'admin/finance/man_search_view', array(), $this->lang->line('fin_man_title'));
	}
	
	function ajax($action)
	{
		if ($action == 'delete_fin')
		{
			if (IS_AJAX && $this->input->post('id') && $this->input->post('m_date'))
			{
				$this->aModel->deletePartnerFinance($this->input->post('id'), $this->input->post('m_date'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'delete_penalty')
		{
			if (IS_AJAX && $this->input->post('id') && $this->input->post('m_date'))
			{
				$this->aModel->deletePartnerPenalty($this->input->post('id'), $this->input->post('m_date'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
	}
}