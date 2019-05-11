<?php

Class MY_Controller extends CI_Controller
{
	
	var $workEngine = true;
	var $allowIp	= array('37.229.5.73');
	
	var $engine		= array(); // настройки
	
	var $isAuth 	= false; // авторизирован пользователь или нет
	var $selfId 	= 0;	 // собственный id пользователя
	var $userInfo	= array(); // своя информация
	
	var $isAdmin	= false;
	var $adminInfo 	= array();
	
	// партнерка
	var $isPartAuth = false;
	var $partId		= 0;
	var $partInfo	= array();
	
	var $language;
	var $allowLang = array('russian', 'english');
	
	var $mobSrc		= 'http://192.168.1.199/mob/';
	
	
	function __construct()
	{
		parent::__construct();
		
		// профилирование
		$this->output->enable_profiler(FALSE);
		
		if (!$this->workEngine && !(in_array($this->input->ip_address(), $this->allowIp)))
		{
			$this->load->view('errors/engine_offline_view');
			$this->output->_display();
			die;
		}
		
		/* Если пользователь заходит с мобильного устройства - перенаправим на моб. версию 
		 * Но, если он запретил автомат. перенаправление - оставим на главной версии
		 * */
		//if ($this->agent->is_mobile() === true && !$this->session->userdata('no_mobile') && $this->uri->segment(2) != 'mobile' && $this->uri->segment(2) != 'credits')
		//{
			//redirect($this->mobSrc);
			//return false;
		//}
		
		/* Главная модель */
		$this->load->model('main_model', 'mainModel');
		
		/* Рассылка мужчинам */
		//$this->load->library('notification');
		//$this->notification->make_ads();
		
		/* НАСТРОЙКИ */
		
		$this->engine = $this->mainModel->getEngineSettings();
		
		/**** ЯЗЫКИ ****/
		// если печенек с языком нет - подставляем дефолтный русский язык, если есть подключаем нужный
		if ($this->input->cookie('myLanguage') && in_array($this->input->cookie('myLanguage'), $this->allowLang))
		{
			$this->language = $this->input->cookie('myLanguage');
		}
		else
		{
			$this->language = 'english';
		}
		
		$this->lang->load($this->language . '/common');
		
		/******** А В Т О Л О Г И Н ***************/
		if ($this->input->cookie('autologin_user') && $this->input->cookie('autologin_password') && !$this->session->userdata('user_id'))
		{
			$autologinId = $this->input->cookie('autologin_user');
			$autologinPwd = $this->input->cookie('autologin_password');
			
			$checkUser = $this->mainModel->getUserProfile($autologinId);
			
			if ($checkUser)
			{
				if ($checkUser['password'] == $autologinPwd)
				{
					$this->session->set_userdata('user_id', $checkUser['id']);
					$this->session->set_userdata('user_pwd', $checkUser['password']);
					
					$this->isAuth 	= true;
					$this->selfId 	= $checkUser['id'];
					$this->userInfo	= $checkUser;
					$this->mainModel->updateOnline($this->selfId);
				}
			}
		}
		
		//
		if ($this->session->userdata('user_id') && $this->session->userdata('user_pwd'))
		{
			$getUser = $this->mainModel->getUserProfile($this->session->userdata('user_id'));
			
			if (!$this->session->userdata('user_main'))
			{
				$this->session->set_userdata('user_main', 1);
				redirect(base_url() . 'my/profile');
				return false;
			}
			
			if ($getUser['user_status'] == '1')
			{
				$this->session->unset_userdata('user_id');
				$this->session->unset_userdata('user_pwd');
				$this->session->unset_userdata('user_main');
				
				if ($this->input->cookie('autologin_user'))
				{
					setcookie('autologin_user', '', time() - 3600, '/');
					setcookie('autologin_password', '', time() - 3600, '/');
				}
				
				redirect(base_url());
			}
			
			$this->isAuth 	= true;
			$this->selfId 	= $getUser['id'];
			$this->userInfo	= $getUser;
		}
		
		//
		if ($this->session->userdata('partner_id') && $this->session->userdata('partner_pwd'))
		{
			$getPartner = $this->mainModel->getPartnerProfile($this->session->userdata('partner_id'));
			
			$this->isPartAuth 	= true;
			$this->partId 		= $getPartner['id'];
			$this->partInfo 	= $getPartner;
		}
		//
		if ($this->session->userdata('admin_id') && $this->session->userdata('admin_pwd'))
		{
			$getAdmin = $this->mainModel->getAdminProfile($this->session->userdata('admin_id'));
			
			$this->isAdmin 	 = true;
			$this->adminInfo = $getAdmin;
		}
		
		/*** Если юзер онлайн, но время онлайн-статуса уже истекло - обновим его */
		
		if ($this->isAuth !== false)
		{
			if ($this->mainModel->checkOnline($this->selfId) === false)
			{
				$this->mainModel->updateOnline($this->selfId);
			}
		}
		
		log_message('debug', 'Core Controller class initialized');
	}
	
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	function layout($layType, $content, $contentData = false, $title = false)
	{
		// передан ли заголовок? если нет - ставим дефолтный
		if ($layType != 'partner' && $layType != 'admin')
		{
			$title = ($title === false) ? $this->engine['engine_title'] : $title . ' | ' . $this->engine['engine_title'];
		}
		elseif ($layType == 'partner')
		{
			$title = ($title == false) ? 'Partner panel' : $title . ' | Partner panel';
		}
		elseif ($layType == 'admin')
		{
			$title = ($title == false) ? 'Admin panel' : $title . ' | Admin panel';
		}
		
		$layArray = array('content' => $content, 'data' => $contentData, 'title' => $title, 'keywords' => $this->engine['engine_keywords'], 'description' => $this->engine['engine_description']);
		
		$this->load->view('layout_' . $layType . '_view', array('layArray' => $layArray));		
	}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

}