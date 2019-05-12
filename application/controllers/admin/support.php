<?php
Class Support extends MY_Controller
{
	var $resInfo = '';
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			die;
		}
		
		$this->load->model('admin/admin_model', 'aModel');
		$this->lang->load('english/admin');
	}
	
	function index()
	{
		// ����������� ������ �� answer()
		if ($this->input->post('response'))
		{
			$emailTo = $this->input->post('response_mail');
			$msg_hash = $this->input->post('hash');
			$subject = $this->input->post('e_subject');
			$message = '<html><body>' . $this->input->post('e_message') . '</body></html>';
			//load email library...
			$this->load->library('email', array('mailtype' => 'html'));
			
			//��������� ���������
			$this->email->from('no-reply@findbestbride.com');
			$this->email->to($emailTo);
			$this->email->subject($subject);
			$this->email->message($message);
			// sending...
			$this->email->send();
			$this->aModel->approveSupportAnswer($msg_hash);
			
			$this->resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('support_ans_ok'), $emailTo));
		}
		
		$list = $this->aModel->getSupportList();
		
		$this->layout('admin', 'admin/support/support_view', array('list' => $list, 'resInfo' => $this->resInfo), $this->lang->line('support_title'));
	}
	
	/**
	 * ��������� ������ ������������ �� email
	 */
	function answer($hash)
	{
		if ($hash)
		{
			// ������� ��������� ���������� ������
			$info = $this->aModel->getSupportInformation($hash);
			
			// ���� ����� ����� ������, � �� ���� ������ ��� �� ���� - ���������� �����
			// ������. ���� ��� - 404 ������
			if ($info && $info['is_answer'] != 1)
			{
				$this->layout('admin', 'admin/support/answer_view', array('info' => $info), $this->lang->line('support_ans_title'));
			}
			else
			{
				show_404();
			}
		}
	}
	
	function ajax()
	{
		if (IS_AJAX && $this->input->post('hash'))
		{
			$this->aModel->approveSupport($this->input->post('hash'));
			
			echo json_encode(array('result' => 'success'));
		}
	}
}