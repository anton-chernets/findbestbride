<?php

Class Partners extends MY_Controller
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
		$this->load->library(array('form_validation', 'editor'));
	}
	
	/*********************** СПИСОК ПАРТНЕРОВ ****************************/
	function index($sort = 0)
	{
		// деактивация 
		if (IS_AJAX && $this->input->post('is_deactive'))
		{
			$this->aModel->cancelPartner($this->input->post('id'));
			echo json_encode(array('result' => 'success'));
			return false;
		}
		// активация
		if (IS_AJAX && $this->input->post('is_active'))
		{
			$this->aModel->approvePartner($this->input->post('id'));
			echo json_encode(array('result' => 'success'));
			return false;
		}
		
		$pList = $this->aModel->getAllPartners($sort);
		
		$this->layout('admin', 'admin/partners/list_view', array('list' => $pList), $this->lang->line('p_title'));
	}
	
	/*********************** НОВЫЙ ПАРТНЕР *******************************/
	function add()
	{
		$resInfo = '';
		
		if ($this->input->post('new'))
		{
			$validRules = array(
				array (
					'field'	=> 'n_p_login',
					'label'	=> 'New partner login',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'n_p_pwd',
					'label'	=> 'New partner password',
					'rules'	=> 'required'
				)
			);
			$this->load->library('form_validation');
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$insert = array(
					'p_login'	=> $this->input->post('n_p_login'),
					'p_password'=> md5($this->input->post('n_p_pwd'))
				);
				
				$this->aModel->insertNewPartner($insert);
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('new_partner_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('new_partner_false'));
			}
		}
		
		$this->layout('admin', 'admin/partners/add_view', array('resInfo' => $resInfo), $this->lang->line('add_partner_title'));
	}
	
	/*************************** ШТРАФЫ **************************/
	function penalty()
	{
		$resInfo = '';
		
		if ($this->input->post('new'))
		{
			$validRules = array (
				array (
					'field'	=> 'p_id',
					'label'	=> 'partner id',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'p_price',
					'label'	=> 'summa shtrafa',
					'rules'	=> 'required|numeric'
				)
			);
			
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				// прикреплять ли сообщение с пояснением?
				if ($this->input->post('p_is_msg') == '1')
				{
					$message = array (
						'to_id'		=> $this->input->post('p_id'),
						'message'	=> $this->editor->parse_message($this->input->post('p_message')),
						'msg_date'	=> time(),
						'subject'	=> $this->lang->line('p_penalty_msg'),
						'hash'		=> md5(time() . $this->input->post('p_id'))
					);
					
					$this->aModel->sendPartnerMessage($message);
				}
				
				$comment = ($this->input->post('p_is_msg') == 1) ? 'See private messages' : 'no comment';
				
				$penalty = array (
					'p_id'		=> $this->input->post('p_id'),
					'count'		=> $this->input->post('p_price'),
					'comment'	=> $comment,
					'add_date'	=> time()
				);
				
				$this->aModel->addPartnerPenalty($penalty);
				
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('p_penalty_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('p_msg_false'));
			}
		}
		
		$this->layout('admin', 'admin/partners/penalty_view', array('resInfo' => $resInfo), $this->lang->line('p_penalty_title'));
	}
	
	/********************* РАССЫЛКА ***********************/
	
	function news()
	{
		$resInfo = '';
		///////// удаление новостей
		if (IS_AJAX && $this->input->post('is_del'))
		{
			$this->aModel->deleteNews($this->input->post('id'));
			
			echo json_encode(array('result' => 'success'));
			return false;
		}
		
		///////// новая новость
		if ($this->input->post('new'))
		{
			$validRules = array(
				array (
					'field'	=> 'p_subject',
					'label'	=> 'news subject',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'p_message',
					'label'	=> 'news message',
					'rules'	=> 'required'
				)
			);
			
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$news = array (
					'subject'	=> $this->input->post('p_subject'),
					'message'	=> $this->editor->parse_message($this->input->post('p_message')),
					'news_date'	=> time()
				);
				
				$this->aModel->insertNews($news);
				
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('p_news_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('p_msg_false'));
			}
		}
		
		$list = $this->aModel->getAllNews();
		$this->layout('admin', 'admin/partners/news_view', array('resInfo' => $resInfo, 'list' => $list), $this->lang->line('p_news_title'));
	}
	
	/********************* ЛИЧНЫЕ СООБЩЕНИЯ *********************/
	function message()
	{
		
		$resInfo = '';
		
		if ($this->input->post('new'))
		{
			$validRules = array(
				array (
					'field'	=> 'p_id',
					'label'	=> 'p_id',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'p_subject',
					'label'	=> 'subject',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'p_message',
					'label'	=> 'message',
					'rules'	=> 'required'
				)
			);
			
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$newMessage = array (
					'to_id'		=> $this->input->post('p_id'),
					'message'	=> $this->editor->parse_message($this->input->post('p_message')),
					'msg_date'	=> time(),
					'subject'	=> $this->input->post('p_subject'),
					'hash'		=> md5(time() . $this->input->post('p_id'))
				);
				
				$this->aModel->sendPartnerMessage($newMessage);
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('p_msg_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('p_msg_false'));
			}
		}
		
		$this->layout('admin', 'admin/partners/message_view', array('resInfo' => $resInfo), $this->lang->line('p_message_title'));
	}
	
	/************************** РЕДАКТОР ТЕКСТОВЫХ СТРАНИЦ *******************/
	
	function text($page)
	{
		$resInfo = '';
		
		if ($page == 'agreement')
		{
			// сохранение
			if ($this->input->post('save'))
			{
				$text = $this->input->post('page_text');
				
				$file = fopen(APPPATH . 'text/partner_agreement.txt', 'w');
				fwrite($file, $text);
				fclose($file);
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('text_red_ok'));
			}
			
			$page = file_get_contents(APPPATH . 'text/partner_agreement.txt');
			$this->layout('admin', 'admin/partners/edit_text_page', array('page' => $page, 'resInfo' => $resInfo), $this->lang->line('text_agr_title'));
		}
		
		elseif ($page == 'rules')
		{
			// сохранение
			if ($this->input->post('save'))
			{
				$text = $this->input->post('page_text');
			
				$file = fopen(APPPATH . 'text/partner_rules.txt', 'w');
				fwrite($file, $text);
				fclose($file);
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('text_red_ok'));
			}
			
			$page = file_get_contents(APPPATH . 'text/partner_rules.txt');
			$this->layout('admin', 'admin/partners/edit_text_page', array('page' => $page, 'resInfo' => $resInfo), $this->lang->line('text_rules_title'));
		}
	}
}