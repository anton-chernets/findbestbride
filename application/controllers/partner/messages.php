<?php

Class Messages extends MY_Controller
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
		//$this->load->library('pagination');
	}
	
	// список сообщений
	function index()
	{
		$allMessages = $this->pModel->allPartnerMessages($this->partId);
		
		$this->layout('partner', 'partner/messages/index_view', array('msg' => $allMessages), $this->lang->line('partner_msg_title'));
	}
	
	// чтение сообщения
	function read($hash)
	{
		if ($hash)
		{
			if ($this->pModel->checkMessage($this->partId, $hash) != false)
			{
				$message = $this->pModel->readMessage($hash, $this->partId);
				
				$this->layout('partner', 'partner/messages/read_view', array('msg' => $message), $this->lang->line('partner_msg_title'));
			}
			else 
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}
	
	// AJAX функции
	function ajax($action)
	{
		if ($action == 'delete')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$msg_hash = $this->input->post('id');
				
				if ($this->pModel->deleteMessage($msg_hash, $this->partId) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'mark_as_read')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$msg_hash = $this->input->post('id');
				
				if ($this->pModel->markMessage($msg_hash, $this->partId) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
	}
}