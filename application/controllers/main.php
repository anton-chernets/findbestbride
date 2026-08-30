<?php

Class Main extends MY_Controller
{
	var $str = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm123456789";
	
	function __construct()
	{
		parent::__construct();
		
		$this->lang->load($this->language . '/register');
	}
	
	function index($login = null, $isLogin = null)
	{
		$this->load->library('assistant');
		$resInfo = '';
		$x = '';
		$showProfiles = true;
		
		/***************************** Р Е Г И С Т Р А Ц И Я *****************************/
		if ($this->input->post('registerMe'))
		{
			$validationRules = array (
				array (
					'field' => 'user_email',
					'label'	=> 'Email',	
					'rules'	=> 'required|valid_email|xss_clean'
				),
				array (
					'field' => 'user_password',
					'label'	=> 'Password',
					'rules'	=> 'required'
				),
				array (
					'field' => 'user_real_name',
					'label'	=> 'Name',
					'rules'	=> 'trim|required|xss_clean'
				),
				//array (
				//	'field'	=> 'user_lastname',
				//	'label'	=> 'Lastname',
				//	'rules'	=> 'trim|required|xss_clean'
				//),
				array (
					'field'	=> 'user_country',
					'label'	=> 'Country',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'user_sex',
					'label'	=> 'Sex',
					'rules'	=> 'required'
				)
			);
			$this->form_validation->set_rules($validationRules);
			
			if ($this->form_validation->run() !== false)
			{
				if ($this->mainModel->checkEmail($this->input->post('user_email')) != false)
				{
					// код активации
					for($i = 0; $i < 16; $i++)
					{
						$x .= substr($this->str, mt_rand(0, strlen($this->str)-1), 1);
					}
					
					$insertUser = array (
						'name'			=> $this->input->post('user_real_name'),
						'lastname'		=> $this->input->post('user_lastname'),
						'sex'			=> $this->input->post('user_sex'),
						'country'		=> $this->input->post('user_country'),
						'email'			=> $this->input->post('user_email'),
						'password'		=> md5($this->input->post('user_password')),
						'last_online'	=> time() + (30 * 60),
						'register_date'	=> time(),
						'user_status'	=> '9',
						'activate_code'	=> $x
					);
					
					// отправка логина, пароля и кода активации на мыло
					$this->load->library('email', array('mailtype' => 'html'));
					
					$this->email->from('register@findbestbride.com');
					$this->email->to($insertUser['email']);
					$this->email->subject('Welcome on findbestbride.com! Your register parameters');

					$data = array(
                        'userName'=> $this->input->post('user_real_name'),
                        'userLogin' => $insertUser['email'],
                        'userPassword' => $this->input->post('user_password'),
                        'activationLink' => base_url('activation/' . $x),
                        'supportLink' => base_url('support/')
                    );

					$mailBody = $this->load->view('emails/confirm_registration_mail.php',$data,TRUE);
					$this->email->message($mailBody);
					$this->email->send();
					
					
					$this->mainModel->createNewUser($insertUser);
				
					$resInfo = array('type' => 'success', 'message' => $this->lang->line('success_message'), 'openForm' => '', 'openLoginForm' => '');
				}
				else
				{
					$resInfo = array('type' => 'error', 'message' => $this->lang->line('email_message'), 'openForm'	=> 'true', 'openLoginForm' => '');
				}
			}
			else
			{
				$resInfo = array('type' => 'error', 'message' => $this->lang->line('valid_message'), 'openForm'	=> 'true', 'openLoginForm' => '');
			}
		}
		/**********************************************************************************/
		if ($login != false)
		{
			if ($isLogin == 'false')
			{
				$resInfo = array('type' => 'error', 'message' => $this->lang->line('login_failed'), 'openForm' => '', 'openLoginForm' => 'true');
			}
			elseif ($isLogin == 'true')
			{
				$resInfo = array('type' => 'success', 'message' => $this->lang->line('login_success'), 'openForm' => '', 'openLoginForm' => '');
			}
		}
		
		/************************** ВЫБОРКА ПРОФИЛЕЙ НА ГЛАВНУЮ **************************/
		// опять бешеные костыли пришлось пилить
		$profiles = $this->mainModel->getMainPageProfiles();
		$this->lang->load($this->language . '/search');
		$count = count($profiles);
		// первый столбец
		$firstRow = ceil($count / 3);
		$fRow = array_slice($profiles, 0, $firstRow);
		// второй столбец
		$sc = $count - $firstRow;
		$secondRow = ceil($sc / 2);
		$sRow = array_slice($profiles, $firstRow, $secondRow);
		// третий столбец
		$th = $sc - $secondRow;
		$thirdRow = ceil ($th / 1);
		$tRow = array_slice($profiles, ($firstRow + $secondRow), $thirdRow);
		//
		
		
		if ($count < 12)
		{
			$showProfiles = false;
		}
		/**********************************************************************************/
		
		$this->layout('general', 'general/general_content_view', array('show' => $showProfiles, 'one' => $fRow, 'two' => $sRow, 'three' => $tRow, 'resInfo' => $resInfo));
	}
	
	
	
	/************************ ВЫХОД ИЗ АККАУНТА ****************************/
	
	function logout()
	{
		if ($this->input->cookie('autologin_user'))
		{
			setcookie('autologin_user', '', time() - 3600, '/');
			setcookie('autologin_password', '', time() - 3600, '/');
		}
		
		$this->session->unset_userdata(array('user_id' => '', 'user_pwd' => ''));
		
		redirect(base_url());
		
		echo 'Please, wait...';
	}
	
	/********************** ВЫХОД ИЗ МОБ. ВЕРСИИ *********************************/
	
	function mobile($action)
	{
		if ($action == 'out')
		{
			$this->session->set_userdata('no_mobile', '1');
			
			redirect(base_url());
		}
	}
}