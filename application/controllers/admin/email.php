<?php

Class Email extends MY_Controller
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
		$this->load->library('email', array('mailtype' => 'html'));
	}
	
	/**
	 * �������� ��������� ����������� ������������ �� ����
	 */
	function user()
	{
		if ($this->input->post('new'))
		{
			//get user profile from id
			$profile = $this->mainModel->getUserProfile($this->input->post('u_id'));
			// email subject
			$subject = $this->input->post('e_subject');
			// email message body
			$message = '<html><body>' . $this->input->post('e_message') . '</body></html>';
			
			// email settings
			$this->email->from('no-reply@testc4l.site');
			$this->email->to($profile['email']);
			$this->email->subject($subject);
			$this->email->message($message);
			// GO...
			$this->email->send();
			
			$this->resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('email_user_ok'), $profile['id'], $profile['email']));
		}
		
		$this->layout('admin', 'admin/email/user_view', array('resInfo' => $this->resInfo), $this->lang->line('email_user_title'));
	}
	
	/**
	 * �������� ��������� �������� �� ����
	 */
	function partner()
	{
		if ($this->input->post('new'))
		{
			//get partner email
			$profile = $this->aModel->getPartnerEmail($this->input->post('p_id'));
			// email subject
			$subject = $this->input->post('e_subject');
			// email message body
			$message = '<html><body>' . $this->input->post('e_message') . '</body></html>';
				
			// email settings
			$this->email->from('no-reply@testc4l.site');
			$this->email->to($profile);
			$this->email->subject($subject);
			$this->email->message($message);
			// GO...
			$this->email->send();
				
			$this->resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('email_part_ok'), $profile));
		}
		
		
		$this->layout('admin', 'admin/email/partner_view', array('resInfo' => $this->resInfo), $this->lang->line('email_part_title'));
	}
	
	/**
	 * �������� �������� �������� + ����� ������ ��������
	 */
	function mailing($action = '')
	{
		if (!$action)
		{
			// ��������
			if ($this->input->post('new'))
			{
				//���� ����������; 1 - ����, 2 - ��������, 3 - ��������
				$to = $this->input->post('email_to');
				$subject = $this->input->post('e_subject');
				$message = '<html><body>' . $this->input->post('e_message') . '</body></html>';
				// ������� ������ ��� ��� ��������
				$list = $this->aModel->getEmailList($to);
				
				// ��������� ������ �� ���� ����� � �������� ���������
				foreach ($list as $row)
				{
					// �������� ���������� email
					$this->email->clear();
					
					// new message
					$this->email->from('no-reply@testc4l.site');
					$this->email->to($row['email']);
					$this->email->subject($subject);
					$this->email->message($message);
					
					$this->email->send();
				}
				
				$archive = array(
					'hash'		=> md5(time() . rand(1,1000)),
					'date'		=> date('Y-m-d H:i:s'),
					'subject'	=> $subject,
					'message'	=> $this->input->post('e_message'),
					'type'		=> $to
				);
				$this->aModel->insertMailing($archive);
				
				$this->resInfo = array('type' => 'success', 'text' => $this->lang->line('email_all_ok'));
			}
			
			//view
			$this->layout('admin', 'admin/email/mailing_view', array('resInfo' => $this->resInfo), $this->lang->line('email_all_title'));
		}
		elseif ($action == 'old')
		{
			$list = $this->aModel->getMailingList();	
			$this->layout('admin', 'admin/email/mailing_old_view', array('list' => $list), $this->lang->line('email_old_title'));
		}
	}
}