<?php

Class First extends MY_Controller
{
	var $resInfo;
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			return false;
		}
		
		$this->load->model('admin/admin_model', 'aModel');
		$this->load->model('admin/statistics_model', 'statModel');
		$this->lang->load('english/admin');
	}
	
	function index()
	{
		$uCount = $this->statModel->getAllUsersCount();
		$fCount = $this->statModel->getAllFinance();
		$lCount = $this->statModel->getAllLogs();
		$lastLogs = $this->statModel->getLastLogs();
		$lastUsers = $this->statModel->getLastUsers();
		$lastFinance = $this->statModel->getLastFinance();
		
		$this->layout('admin', 'admin/first_view', 
				array(
						'fCount' 	=> $fCount, 
						'lastFin' 	=> $lastFinance, 
						'uCount' 	=> $uCount, 
						'lastUser' 	=> $lastUsers,
						'lCount'	=> $lCount,
						'lastLogs'	=> $lastLogs,
						'pCount'	=> $this->statModel->getAllPays(),
						'lastPays'	=> $this->statModel->getLastPays()
		), $this->lang->line('admin_first_title'));
	}
	
	/********** СОЗДАНИЕ РЕЗЕРВНОЙ КОПИИ БД ********************/
	function backup()
	{
		$this->load->helper(array('file', 'download'));
		
		if ($this->input->post('back_up'))
		{
			$type = $this->input->post('copy');	
			
			if (file_exists(APPPATH . '/backup/mysql_backup.zip'))
			{
				unlink(APPPATH . '/backup/mysql_backup.zip');
			}
			
			$db_settings = array(
				'format'	=> 'zip',
				'filename'	=> 'a-mans-mind.sql'	
			);
			$this->load->dbutil();
			$backup =& $this->dbutil->backup($db_settings);
			
			// если только сохраняем на сервере
			if ($type == 1)
			{
				write_file(APPPATH . '/backup/mysql_backup.zip', $backup);
				
				$this->resInfo = array('type' => 'success', 'text' => $this->lang->line('bp_serv_ok'));
			}
			// отдаем файл на закачку
			elseif ($type == 2)
			{
				force_download('mysql_backup.zip', $backup);
				$this->resInfo = array('type' => 'success', 'text' => $this->lang->line('bp_load_ok'));
			}
			// отправляем файл на мыло
			elseif ($type == 3 && $this->input->post('email'))
			{
				$this->load->library('email');
				write_file(APPPATH . '/backup/mysql_backup.zip', $backup);
				
				$this->email->from('backup@testc4l.site');
				$this->email->subject('Backup of your website');
				$this->email->attach(APPPATH . '/backup/mysql_backup.zip');
				$this->email->message('This is your backup, date: '. date(d-m-Y));
				$this->email->send();
				
				$this->resInfo = array('type' => 'success', 'text' => $this->lang->line('bp_email_ok'));
			}
			
		}
		
		
		$this->layout('admin', 'admin/backup_view', array('resInfo' => $this->resInfo), $this->lang->line('bp_title'));
	}
	
	function admins()
	{
		
		# новая учетка
		if ($this->input->post('add'))
		{
			$validRules = array (
				array (
					'field'	=> 'n_a_login',
					'label'	=> 'New admin login',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field' => 'n_a_pwd',
					'label'	=> 'New admin password',
					'rules'	=> 'required'
				)
			);	
			$this->load->library('form_validation');
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$insertAdmin = array(
					'a_login'	=> $this->input->post('n_a_login'),
					'a_password'=> sha1(md5($this->input->post('n_a_pwd')))
				);
				
				$this->aModel->addNewAdmin($insertAdmin);
				
				$this->resInfo = array('type' => 'success', 'text' => $this->lang->line('new_admin_ok'));
			}
			else
			{
				$this->resInfo = array('type' => 'error', 'text' => $this->lang->line('new_admin_false'));
			}
		}
		
		# список
		$list = $this->aModel->getAdminList();
		
		$this->layout('admin', 'admin/admins_list_view', array('resInfo' => $this->resInfo, 'list' => $list), $this->lang->line('admin_ad_title'));
	}
	
	public function password()
	{
		$data = array();
		
		if ($this->input->post())
		{
			if (sha1(md5($this->input->post('now_pwd'))) == $this->adminInfo['a_password'])
			{
				$this->db->update('user_admin', array('a_password' => sha1(md5($this->input->post('new_pwd')))), array('a_login' => $this->adminInfo['a_login']));
				$this->adminInfo['a_password'] = sha1(md5($this->input->post('new_pwd')));
				$data['resInfo'] = array('type' => 'success', 'text' => 'Пароль успешно изменен. Перезайдите для вступления изменений в силу.');
			}
			else
			{
				$data['resInfo'] = array('type' => 'danger', 'text' => 'Вы не верно указали старый пароль');
			}
		}
		
		$this->layout('admin', 'admin/admins_pwd_view', $data);
	}
	
	function finance()
	{
		
		if ($this->input->post('date_01') && $this->input->post('date_02'))
		{
			$startDate = explode('/', $this->input->post('date_01'));
			$start = strtotime($startDate[1] . '-' . $startDate[0] . '-' . $startDate[2]);
			
			$endDate = explode('/', $this->input->post('date_02'));
			$end = strtotime($endDate[1] . '-' . $endDate[0] . '-' . $startDate[2]);
			
			if ($end < $start)
			{
				$end = '';
			}
		}
		else
		{
			$startDate = date('m-Y');
			$start = strtotime('01-' . $startDate);
		
			$year = (date('Y') + 5);
			$end   = strtotime('01-01-' . $year);
			
		}
		
		$list = $this->aModel->getFinanceList($start, $end);
		
		$this->layout('admin', 'admin/finance_view', array('list' => $list));
	}
	
	function logout()
	{
		if ($this->isAdmin != false)
		{
			$this->session->unset_userdata('admin_id');
			$this->session->unset_userdata('admin_pwd');
			
			redirect(base_url());
		}
	}
	
	function ajax($action)
	{
		if ($action == 'delete_admin')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$id = $this->input->post('id');
				
				if ($this->aModel->deleteAdmin($id) == true)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
	}
}