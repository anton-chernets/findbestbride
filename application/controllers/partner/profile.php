<?php

Class Profile extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner/');
			return false;
		}
		
		$this->load->model('partner/partner_model', 'pModel');
		$this->lang->load('english/partner');
		
		$this->load->library('form_validation');
	}
	
	function index()
	{
		$resInfo = '';
		///////////////////////
		// ����������
		if ($this->input->post('save'))
		{
			$validRules = array(
				array (
					'field'	=> 'p_name',
					'label'	=> 'Agency name',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'director',
					'label'	=> 'Director name',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'address',
					'label'	=> 'Agency address',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'phone',
					'label'	=> 'Agency phone',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'mobile',
					'label'	=> 'Mobile phone',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'email',
					'label'	=> 'Agency email',
					'rules'	=> 'required|valid_email'
				)
			);
			
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$edit_data = array(
					'p_name'		=> $this->input->post('p_name'),
					'p_director'	=> $this->input->post('director'),
					'p_address'		=> $this->input->post('address'),
					'p_telephone'	=> $this->input->post('phone'),
					'p_mobile'		=> $this->input->post('mobile'),
					'p_email'		=> $this->input->post('email'),
					'p_country'		=> $this->input->post('country')
				);
				
				$this->partInfo['p_name'] = $this->input->post('p_name');
				$this->partInfo['p_director'] = $this->input->post('director');
				$this->partInfo['p_telephone'] = $this->input->post('phone');
				$this->partInfo['p_mobile'] = $this->input->post('mobile');
				$this->partInfo['p_email'] = $this->input->post('email');
				$this->partInfo['p_country'] = $this->input->post('country');
				
				
				if ($this->input->post('country') == 1)
				{
					$edit_data['p_bank'] 		= $this->input->post('bank');
					$edit_data['p_bank_type']	= $this->input->post('bank_type');
					$edit_data['p_bank_name']	= $this->input->post('bank_name');
					$edit_data['p_bank_number'] = $this->input->post('bank_number_ukr');
					
					$this->partInfo['p_bank'] 		= $this->input->post('bank');
					$this->partInfo['p_bank_type'] 	= $this->input->post('bank_type');
					$this->partInfo['p_bank_name']	= $this->input->post('bank_name');
					$this->partInfo['p_bank_number']= $this->input->post('bank_number_ukr');
				}
				else
				{
					$edit_data['p_bank_number'] = $this->input->post('bank_number_rus');
					$this->partInfo['p_bank_number'] = $this->input->post('bank_number_rus');
				}
				
				if ($this->partInfo['p_status'] == 0)
				{
					$edit_data['p_status'] = '1';
				}
				
				$this->pModel->updateInformation($edit_data, $this->partId);
				
				$this->mainModel->insertLog($this->partId, '2', $this->lang->line('log_part_change_acc'));
				
				$resInfo = array('result' => 'success', 'text' => 'Информация успешно сохранена');
			}
			else 
			{
				$resInfo = array('result' => 'error', 'text' => 'Вы неверно заполнили поля для ввода');
			}			
		}
		
		
		$this->layout('partner', 'partner/profile_edit_view', array('resInfo' => $resInfo), $this->lang->line('partner_profile_title'));
	}
}