<?php


Class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
	/**************************************** À Â Ò Î Ð È Ç À Ö È ß *************************************/
		if ($this->input->post('loginMe'))
		{
			$loginRules = array (
				array (
					'field' => 'u_email',
					'label'	=> 'Email',
					'rules'	=> 'required|valid_email'
				),
				array (
					'field'	=> 'u_password',
					'label'	=> 'Password',
					'rules'	=> 'required'	
				)
			);
			$this->form_validation->set_rules($loginRules);
			
			if ($this->form_validation->run() != false)
			{
				$isRemember = ($this->input->post('rem')) ? true : false;
				
				$checkData = $this->mainModel->checkAuthData($this->input->post('u_email', true), $this->input->post('u_password'));
				
				if ($checkData !== false)
				{
					$getProfile = $this->mainModel->getUserProfile($checkData);
					
					if ($getProfile['user_status'] != '0')
					{
						show_error('Your profile is blocked or not activated');
						return false;
					}
					
					
					$this->session->set_userdata('user_id', $checkData);
					$this->session->set_userdata('user_pwd', md5($this->input->post('u_password')));
					$this->session->set_userdata('user_main', 1);
					$this->mainModel->updateOnline($checkData);
					
					if ($isRemember == true)
					{
						setcookie('autologin_user', $checkData, time() + (3600 * 24 * 365), '/');
						setcookie('autologin_password', md5($this->input->post('u_password')), time() + (3600 * 24 * 365), '/');
					}
					
					redirect(base_url() . 'my/profile');
				}
				else 
				{
					$this->mainModel->insertLog($checkData, '1', $this->lang->line('log_login_false'));
					redirect(base_url() . 'main/index/login/false');
				}
			}
			else
			{
				redirect(base_url() . 'main/index/login/false');
			}
		}
	}
	
	
	/****************** ÀÂÒÎÐÈÇÀÖÈß ÏÀÐÒÍÅÐÎÂ ****************************/
	
	function partner()
	{
		// åñëè óæå àâòîðèçèðîâàí - îòïðàâèì íà ãëàâíóþ ïàðòíåðêè
		if ($this->isPartAuth == true)
		{
			redirect(base_url() . 'partner/first');
			return false;
		}
		
		$this->lang->load($this->language . '/partner');
		
		// 
		if (IS_AJAX && $this->input->post('login') && $this->input->post('password'))
		{
			$login = $this->input->post('login');
			$password = md5($this->input->post('password'));
			
			if ($login && $password)
			{
				$authData = $this->mainModel->authPartner(array('login' => $login, 'pwd' => $password));
				if ($authData != false)
				{
					$this->session->set_userdata('partner_id', $login);
					$this->session->set_userdata('partner_pwd', $password);
					
					echo json_encode(array('result' => 'success'));
				}
				else
				{
					$this->mainModel->insertLog($login, '2', $this->lang->line('log_part_login_false'));
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('partner_login_invalid_data')));
				}
			}		
			return false;
		}
		
		// 
		$this->load->view('partner/partner_login_view');
	}
	
	/********************** ÀÂÒÎÐÈÇÀÖÈß ÀÄÌÈÍÈÑÒÐÀÒÎÐÎÂ ************************/
	
	function ad()
	{
		if ($this->isAdmin == true)
		{
			redirect(base_url() . 'admin/first/');
			return false;
		}
		$this->lang->load('english/admin');
		
		if (IS_AJAX && $this->input->post('login') && $this->input->post('password'))
		{
			$login = $this->input->post('login');
			$password = sha1(md5($this->input->post('password')));
			
			if ($login && $password)
			{
				$auth = $this->mainModel->adminAuth(array('login' => $login, 'pwd' => $password));
				
				if ($auth != false)
				{
					$this->session->set_userdata('admin_id', $login);
					$this->session->set_userdata('admin_pwd', $password);
					
					echo json_encode(array('result' => 'success'));
				}
				else 
				{
					log_message('error', $this->lang->line('log_login_adm_false'));
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('admin_login_false')));
				}
			}
			return false;
		}
		
		$this->load->view('admin/admin_login_view');
	}
}