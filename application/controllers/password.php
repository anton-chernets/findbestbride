<?php

Class Password extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth == true)
		{
			redirect(base_url());
			return false;
		}
		
		$this->load->model('profile_model', 'pModel');
		$this->lang->load($this->language . '/profile');
	}
	
	function index()
	{
		$resInfo = '';
		
		if ($this->input->post('sendPassword'))
		{
			$rules = array(
                array (
                    'field'	=> 'msg_email',
                    'label'	=> 'Email',
                    'rules'	=> 'required|valid_email'
                )
			);
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run() != false)
			{
				$email = $this->input->post('msg_email');
				
				if ($this->mainModel->checkEmail($email) == false)
				{
					$info = $this->pModel->getInfoByEmail($email);
					$newPwd = $this->_gen();

                    $this->load->library('email', array('mailtype' => 'html'));
				
					$this->email->from('pwd@findbestbride.com');
					$this->email->to($email);
					$this->email->subject('Password recovery');

                    $data = array(
                        'userName'=> $info['name'],
                        'userLogin' => $info['email'],
                        'userPassword' => $newPwd,
                        'restoreLink' => base_url('password/'),
                        'supportLink' => base_url('support/')
                    );

                    $mailBody = $this->load->view('emails/restore_password_mail.php',$data,TRUE);

					$this->email->message($mailBody);
					
					$this->email->send();
					
					$this->pModel->setNewPassword($newPwd, $info['id']);
					
					$this->mainModel->insertLog($info['id'], '1', $this->lang->line('log_pwd_recover_ok'));
					
					$resInfo = array('type' => 'success', 'message' => $this->lang->line('pwd_recover_ok'));
				}
				else
				{					
					$resInfo = array('type' => 'error', 'message' => $this->lang->line('pwd_recover_error'));
				}
			}
			else
			{
				$resInfo = array('type' => 'error', 'message' => $this->lang->line('pwd_recover_no_email'));
			}
		}
		
		$this->layout('content', 'content/forgot_password_view', array('resInfo' => $resInfo), $this->lang->line('pwd_title'));
	}
	
	
	private function _gen($length = 8){
    	$x = '';

    	$str = "qwertyuiopasdfghjklzxcvbnm123456789";

   		 for($i = 0; $i < $length; $i++)
   		 {
    	    $x .= substr($str, mt_rand(0, strlen($str)-1), 1);
    	}

    	return $x;
	}
}