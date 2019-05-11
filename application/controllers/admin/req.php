<?php
Class Req extends MY_Controller
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
	
	function contacts()
	{
		$list = $this->aModel->getContactsReq();
		
		$this->layout('admin', 'admin/req/contacts_view', array('list' => $list), $this->lang->line('req_contact_title'));
	}
	
	function rt()
	{
		$list = $this->aModel->getRtReq();
		
		$this->layout('admin', 'admin/req/rt_view', array('list' => $list), $this->lang->line('rq_rt_title'));
	}
	
	function ajax($action)
	{
		if ($action == 'c_check')
		{
			if (IS_AJAX && $this->input->post('hash'))
			{
				$this->aModel->checkContactReq($this->input->post('hash'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'c_approve')
		{
			if (IS_AJAX && $this->input->post('hash'))
			{
				$hash = $this->input->post('hash');
				
				$info = $this->aModel->getContactReqInfo($hash);
				$women = $this->mainModel->getUserProfile($info['req_id']);
				
				$telephone = ($women['w_phone'] != '') ? $women['w_phone'] : 'not specified';
				
				$message = array (
					'from_user_id'	=> '0',
					'to_user_id'	=> $info['id'],
					'subject'		=> $this->lang->line('c_req_title'),
					'message'		=> sprintf($this->lang->line('c_req_text'), $women['name'], $women['lastname'], $women['email'], $telephone),
					'msg_date'		=> time(),
					'msg_type'		=> '1'
				);
				
				$this->aModel->sendUserMessage($message);
				$this->aModel->checkContactReq($hash);
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'c_cancel')
		{
			if (IS_AJAX && $this->input->post('hash'))
			{
				$hash = $this->input->post('hash');
				$info = $this->aModel->getContactReqInfo($hash);
				$man = $this->mainModel->getUserProfile($info['id']);
				
				$manNewCredits = $man['credits'] + 55;
				
				$this->aModel->cancelContactReq($hash);
				$this->mainModel->updateCredits($man['id'], $manNewCredits);
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'c_delete')
		{
			if (IS_AJAX && $this->input->post('hash'))
			{
				$this->aModel->cancelContactReq($this->input->post('hash'));
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'c_rt')
		{
			if (IS_AJAX && $this->input->post('hash'))
			{
				$this->aModel->approveRtReq($this->input->post('hash'));
				echo json_encode(array('result' => 'success'));
			}
		}
	}
}