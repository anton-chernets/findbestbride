<?php

/**
 * 
 * testc4l.site
 * 
 * @author 		Dmitriy Taftay
 * @link		https://testc4l.site
 * @copyright 	2017 (c) Dmitriy Taftay
 * 
 * �������� ��������� � ����������� ������������� �� e-mail
 */

Class Notification
{
	var $time;
	var $next = '36'; // ���-�� ����� �� ��������� ��������
	
	function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->library('email', array('mailtype' => 'html'));
		
		// �������� ������� ����� 
		$this->CI->lang->load('english/notifications');
		
		//$this->CI->load->model('main_model', 'mainModel');
		$this->CI->load->helper('email');
		
		log_message('debug', 'Notifications class initialized');
	}
	
	/**
	 * �������� ����������� ����� �� e-mail
	 * @param string $type - ��� �����������
	 * @param string $send_email - e-mail ������������
	 * @param array $message_data - ���. ����� � ��������� (�� ������������ ��������)
	 * @return bool
	 */
	function send($type, $send_email, $message_data = array())
	{
		if (valid_email($send_email))
		{
			$this->CI->email->clear();
			
			$this->CI->email->to($send_email);
			$this->CI->email->from('no-reply@testc4l.site');
			
			$this->CI->email->subject($this->CI->lang->line($type) . '_subject');
			
			$message = 	$this->CI->lang->line('start_tag') . 
						sprintf($this->CI->lang->line('letter_body'), $message_data['name'], '', $message_data['subject']) . 
						$this->CI->lang->line('end_tag');
			$this->CI->email->message($message);
			
			//����������...
			$this->CI->email->send();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * �������� �������� ��������� ���������
	 */
	function make_ads()
	{
		$this->time = time();
		$this->CI->load->model('ads_model', 'ads');
		
		if ($this->CI->ads->checkTime($this->time) == true)
		{
			// �������� ������ ������, � ������� �������� ��������
			$men_list = $this->CI->ads->getMenList();
			// ������ ������ ���� �� ������...
			if ($men_list != false)
			{
				// ��������� ������ �� ������ ������ � �������� �������
				foreach ($men_list as $row)
				{
					// ������� ������� ����������� 3 ��������� �������
					$random_girls = $this->CI->ads->getAdsGirls();
					$html_girls = '';
					
					foreach ($random_girls as $girl)
					{
						$photo = ($girl['photo_link'] != '') ? base_url() . 'profiles/photo/user_'.$girl['id'].'/'.$girl['photo_link'].'_220.jpg' : base_url() . 'content/img/no-foto.png';
						$age = ($girl['age'] != '') ? ', age: ' . $girl['age'] : '';
						$name = $girl['name'] . ' ' . $girl['lastname'] . $age;
						$html_girls .= sprintf($this->CI->lang->line('women_template'), $photo, $name, $girl['id']);
					}
					// ���� ���������
					$message =	$this->CI->lang->line('start_tag')
								. $this->CI->lang->line('women_header')
								. $html_girls
								. $this->CI->lang->line('women_footer')
								. $this->CI->lang->line('end_tag');
					// ��������� � ���������� ���������
					$this->CI->email->clear();
					
					$this->CI->email->from('no-reply@testc4l.site');
					$this->CI->email->to($row['email']);
					$this->CI->email->subject($this->CI->lang->line('women_subject'));
					$this->CI->email->message($message);
					$this->CI->email->send();
				}
				
				// ������� ����� �� ��������� ��������
				$newTime = $this->time + (3600 * $this->next);
				$this->CI->ads->updateTime($newTime, $this->time);
			}
		}
	}
}