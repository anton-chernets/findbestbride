<?php

Class Support extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('support_model', 'supModel');
		$this->lang->load($this->language . '/support');
	}
	
	function index()
	{
		$resInfo = '';
		
		/*** Новые сообщения ***/
		if ($this->input->post('submitSupportForm'))
		{
			$rules = array (
				array (
					'field'	=> 'msg_name',
					'label'	=> 'Name',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field' => 'msg_email',
					'label' => 'Email',
					'rules' => 'required|valid_email'
				),
				array (
					'field' => 'msg_subject',
					'label'	=> 'Subject',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'msg_content',
					'label'	=> 'Message',
					'rules'	=> 'trim|required|xss_clean|encode_php_tags'
				)
			);
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run() != false)
			{
				$newInfo = array(
					'date'		=> time(),
					'message'	=> $this->input->post('msg_content'),
					'userMail'	=> $this->input->post('msg_email'),
					'name'		=> $this->input->post('msg_name'),
					'subject'	=> $this->input->post('msg_subject'),
					'user_ip'	=> $this->input->ip_address(),
					'hash'		=> md5(time() . $this->input->ip_address())
				);
				
				if ($this->supModel->createTicket($newInfo) !== false)
				{
					$resInfo = array('type' => 'success', 'message' => $this->lang->line('success_message'));
				}
				else 
				{
					$resInfo = array('type' => 'error', 'message' => $this->lang->line('failed_message'));
				}
			}
			else
			{
				$resInfo = array('type' => 'error', 'message' => $this->lang->line('valid_message'));
			}
		}
		
		
		$this->layout('content', 'content/support_view', array('resInfo' => $resInfo), 'Support');
	}
}