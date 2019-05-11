<?php


// Редактирование профиля

Class Edit extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth != true)
		{
			redirect(base_url());
			die;
		}
		
		if ($this->userInfo['is_agency'] != '0')
		{
			redirect(base_url() . 'my/profile/');
			die;
		}
		
		$this->load->model('profile_model', 'pModel');
		$this->lang->load($this->language . '/profile');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	
	function index()
	{
		$resInfo = '';
		
		/************************ CNAHGE PASSWORD *********************/
		if ($this->input->post('changePassword') && $this->input->post('password_new'))
		{
			$newPwd = md5($this->input->post('password_new'));
			
			if ($this->session->userdata('user_pwd') != $newPwd)
			{
				$this->pModel->saveNewPassword($this->selfId, $newPwd);
				
				$resInfo = array('type' => 'success', 'message' => $this->lang->line('profile_edit_pwd_saved'));
			}
			else 
			{
				$resInfo = array('type' => 'error', 'message' => $this->lang->line('profile_edit_pwd_match'));
			}
		}
		/**************************************************************/
		
		/************************ EDIT PROFILE ***************************/
		if ($this->input->post('changeProfile'))
		{
			$validRules = array (
				array (
					'field' => 'name',
					'label'	=> 'Name',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field' => 'lastname',
					'label'	=> 'Lastname',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field' => 'user_country',
					'label'	=> 'Country',
					'rules' => 'required|integer'
				),
				array (
					'field' => 'user_education',
					'label' => 'Education',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_marital_status',
					'label' => 'Marital status',
					'rules' => 'integer',
				),
				array (
					'field' => 'user_height',
					'label' => 'Height',
					'rules' => 'integer',
				),
				array (
					'field' => 'user_weight',
					'label' => 'Weight',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_eyes_color',
					'label' => 'Eyes color',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_smoking',
					'label' => 'Smoking',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_day',
					'label' => 'Birth day',
					'rules' => 'required|integer'
				),
				array (
					'field' => 'user_month',
					'label' => 'Birth month',
					'rules' => 'required|integer'
				),
				array (
					'field' => 'user_year',
					'label' => 'Birth year',
					'rules' => 'required|integer'
				),
				array (
					'field' => 'user_city',
					'label' => 'City',
					'rules' => 'xss_clean'
				),
				array (
					'field' => 'user_religion',
					'label' => 'Religion',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_occupation',
					'label' => 'Occupation',
					'rules' => 'xss_clean'
				),
				array (
					'field' => 'user_children',
					'label' => 'Children',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_hair',
					'label' => 'Hair color',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_drinking',
					'label' => 'Drinking',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_hobby',
					'label' => 'Hobbies',
					'rules' => 'xss_clean'
				),
				array (
					'field' => 'user_age_from',
					'label' => 'age from',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_age_to',
					'label' => 'age_to',
					'rules' => 'integer'
				),
				array (
					'field' => 'user_aim',
					'label' => 'Aoa',
					'rules' => 'xss_clean'
				),
				array (
					'field' => 'description',
					'label' => 'Aboutme',
					'rules' => 'xss_clean'
				),
				array (
					'field' => 'partner',
					'label' => 'aboutpartner',
					'rules' => 'xss_clean'
				),
				array (
					'field' => 'user_phone',
					'label'	=> 'user mobile phone',
					'rules'	=> 'xss_clean'
				)
			);
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$userAge = getAgeFromDate($this->input->post('user_year').'-'.$this->input->post('user_month').'-'.$this->input->post('user_day'));
				$updateProfile = array (
					'name'	 	=> $this->input->post('name'),
					'lastname'	=> $this->input->post('lastname'),
					'country'	=> $this->input->post('user_country'),
					'b_day'		=> $this->input->post('user_day'),
					'b_month'	=> $this->input->post('user_month'),
					'b_year'	=> $this->input->post('user_year'),
					'age'		=> $userAge,
					'w_phone'	=> $this->input->post('user_phone'),
					'email_notification' => $this->input->post('email_notification'),
					'email_ads'	=> $this->input->post('email_ads')
				);
				//////
				$updateDetails = array (
					'city'		=> $this->input->post('user_city'),
					'marriage'	=> $this->input->post('user_marital_status'),
					'children'	=> $this->input->post('user_children'),
					'height'	=> $this->input->post('user_height'),
					'weight'	=> $this->input->post('user_weight'),
					'eyes'		=> $this->input->post('user_eyes_color'),
					'hair'		=> $this->input->post('user_hair'),
					'occupation'=> $this->input->post('user_occupation'),
					'religion'	=> $this->input->post('user_religion'),
					'education'	=> $this->input->post('user_education'),
					'smoke'		=> $this->input->post('user_smoking'),
					'drink'		=> $this->input->post('user_drinking'),
					'hobbies'	=> $this->input->post('user_hobby'),
					'age_from'	=> $this->input->post('user_age_from'),
					'age_to'	=> $this->input->post('user_age_to'),
					'aoa'		=> $this->input->post('user_aim'),
					'about_me'	=> $this->input->post('description'),
					'about_partner' => $this->input->post('partner')
				);
				if ($this->userInfo['sex'] == 2)
				{
					$updateDetails['english'] = $this->input->post('user_english');
				}
				///////
				$this->pModel->updateProfile($updateProfile, $updateDetails, $this->selfId, $this->userInfo['sex']);
				$this->userInfo['name'] 	= $updateProfile['name'];
				$this->userInfo['lastname']	= $updateProfile['lastname'];
				$this->userInfo['country']	= $updateProfile['country'];
				$this->userInfo['b_day']	= $updateProfile['b_day'];
				$this->userInfo['b_month']	= $updateProfile['b_month'];
				$this->userInfo['b_year']	= $updateProfile['b_year'];
				$this->userInfo['age']		= $updateProfile['age'];
				$this->userInfo['w_phone']	= $updateProfile['w_phone'];
				$this->userInfo['email_ads']= $updateProfile['email_ads'];
				$this->userInfo['email_notification'] = $updateProfile['email_notification'];
				
				$resInfo = array('type' => 'success', 'message' => $this->lang->line('profile_edit_success'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'message' => $this->lang->line('profile_edit_error'));
			}
		}
		/*****************************************************************/
		/********************** УДАЛЕНИЕ ПРОФИЛЯ *************************/
		if ($this->input->post('deleteProfile'))
		{
			$this->pModel->deleteProfile($this->selfId);
			$this->userInfo['user_status'] = '2';
			$resInfo = array('type' => 'success', 'message' => $this->lang->line('profile_edit_deleted'));
		}
		/********************** ВОССТАНОВЛЕНИЕ ПРОФИЛЯ ********************/
		if ($this->input->post('restoreProfile'))
		{
			$this->pModel->restoreProfile($this->selfId);
			$this->userInfo['user_status'] = '0';
			$resInfo = array('type' => 'success', 'message' => $this->lang->line('profile_edit_restored'));
		}
		/******************************************************************/
		
		$userDetails = $this->pModel->getUserDetails($this->selfId, $this->userInfo['sex']);
		
		$ageFrom = $this->_createSearchAge(1, $userDetails['age_from']);
		$ageTo	 = $this->_createSearchAge(2, $userDetails['age_to']);
		
		$ages = array(
			'0' => $ageFrom, // возраст поиска ОТ
			'1' => $ageTo, // возраст поиска ДО 
			'2' => $this->_createMarriage($userDetails['marriage']), // семейное положение
			'3' => $this->_createEducationLevel($userDetails['education']), // образование
			'4' => $this->_createEyesColor($userDetails['eyes']), // цвет глаз 
			'5' => $this->_createSmokingDrinking(1, $userDetails['smoke']), // курение
			'6' => $this->_createSmokingDrinking(2, $userDetails['drink']), // алкоголизм
			'7' => $this->_createReligion($userDetails['religion']), // религия
			'8' => $this->_createChildren($userDetails['children']), // дети
			'9' => $this->_createHairColor($userDetails['hair']), // цвет волос
			'10'=> $this->_createYear($this->userInfo['b_year']), // год рождения
			'11'=> $this->_createDay($this->userInfo['b_day']), // чило рождения
			'12'=> $this->_createMonth($this->userInfo['b_month']), // месяц рождения 
			'13'=> $this->_createHeight($userDetails['height']), // рост
			'14'=> $this->_createWeight($userDetails['weight']), // вес
			'15'=> $this->_createEnglish($userDetails['english']), // уровень англа
			'16'=> $this->_createCountry($this->userInfo['country']) // страна
		);
		
		$this->layout('profile', 'profile/profile_edit_view', array('ages' => $ages, 'resInfo' => $resInfo, 'uDetails' => $userDetails), $this->lang->line('profile_edit_title'));
	}
	
	function _createCountry($selected)
	{
		$list = userCountry();
		$class = 'class="select3"';
		
		return form_dropdown('user_country', $list, $selected, $class);
	}
	
	function _createEnglish($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => $this->lang->line('profile_edit_eng_ns'),
			'2' => $this->lang->line('profile_edit_eng_wd'),
			'3' => $this->lang->line('profile_edit_eng_bg'),
			'4' => $this->lang->line('profile_edit_eng_f')
		);
		$class = 'class="select3"';
		
		return form_dropdown('user_english', $list, $selected, $class);
	}
	
	function _createHeight($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => "4'7'' - 4'9'' (140-145 cm)",
			'2' => "4'10'' - 4'11'' (146-150 cm)",
			'3' => "5'0'' - 5'1'' (151-155 cm)",
			'4' => "5'2'' - 5'3'' (156-160 cm)",
			'5' => "5'4'' - 5'5'' (161-165 cm)",
			'6' => "5'6'' - 5'7'' (166-170 cm)",
			'7' => "5'8'' - 5'9'' (171-175 cm)",
			'8' => "5'10'' - 5'11'' (176-180 cm)",
			'9' => "6'0'' - 6'1'' (181-185 cm)",
			'10'=> "6'2'' - 6'3'' (186-190 cm)",
			'11'=> "6'4'' (191 cm) or above"
		);
		$class = 'class="select3"';
		
		return form_dropdown('user_height', $list, $selected, $class);
	}
	
	function _createWeight($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => '45 kg 99 lbs - 50 kg 110 lbs',
			'2' => '50 kg 110 lbs - 55 kg 121 lbs',
			'3' => '55 kg 121 lbs - 60 kg 132 lbs',
			'4' => '60 kg 132 lbs - 65 kg 143 lbs',
			'5' => '65 kg 143 lbs - 70 kg 154 lbs',
			'6' => '70 kg 154 lbs - 75 kg 165 lbs',
			'7' => '75 kg 165 lbs - 80 kg 176 lbs',
			'8' => '80 kg 176 lbs - 85 kg 187 lbs',
			'9' => '85 kg 187 lbs - 90 kg 198 lbs',
			'10'=> '90 kg 198 lbs - 95 kg 209lbs',
			'11'=> '95 kg 209 lbs - 100 kg 220 lbs',
			'12'=> '100 kg 220 lbs - 105 kg 231 lbs',
			'13'=> '105 kg 231 lbs - 110 kg 240 lbs',
			'14'=> '110 kg 240 lbs - 115 kg 254 lbs',
			'15'=> '115 kg 254 lbs - 120 kg 256 lbs',
			'16'=> '120 kg 256 lbs - 125 kg 276 lbs',
			'17'=> '125 kg 276 lbs - 130 kg 287 lbs',
			'18'=> '130 kg 287 lbs - 135 kg 298 lbs',
			'19'=> '135 kg 298 lbs - 140 kg 309 lbs',
			'20'=> '140 kg 309 lbs - 145 kg 320 lbs',
			'21'=> '145 kg 320 lbs - 150 kg 331 lbs'
		);
		$class = 'class="select3"';
		
		return form_dropdown('user_weight', $list, $selected, $class);
	}
	
	function _createMonth($selected = 1)
	{
		$list = array (
			'1' => 'January',
			'2' => 'February',
			'3' => 'March',
			'4' => 'April',
			'5' => 'May',
			'6' => 'June',
			'7' => 'July',
			'8' => 'August',
			'9'	=> 'September',
			'10'=> 'October',
			'11'=> 'November',
			'12'=> 'December'
		);
		$class = 'class="select6"';
		
		return form_dropdown('user_month', $list, $selected, $class);
	}
	
	function _createHairColor($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => $this->lang->line('profile_edit_hair_aub'),
			'2'	=> $this->lang->line('profile_edit_hair_bl'),
			'3'	=> $this->lang->line('profile_edit_hair_blon'),
			'4'	=> $this->lang->line('profile_edit_hair_lb'),
			'5'	=> $this->lang->line('profile_edit_hair_db'),
			'6' => $this->lang->line('profile_edit_hair_red'),
			'7' => $this->lang->line('profile_edit_hair_wg')
		);
		$class = 'class="select2"';
		
		return form_dropdown('user_hair', $list, $selected, $class);
	}
	
	function _createChildren($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => $this->lang->line('none'),
			'2'	=> '1',
			'3' => '2',
			'4' => '3',
			'5' => '4',
			'6' => '5'
		);
		$class = 'class="select2"';
		
		return form_dropdown('user_children', $list, $selected, $class);
	}
	
	function _createSearchAge($type, $selected = 18)
	{
		$list = createMinMaxAge();
		$class = 'class="select5"';
		// минимальный возраст в поиске
		if ($type == 1)
		{
			return form_dropdown('user_age_from', $list, $selected, $class);
		}
		elseif ($type == 2)
		{
			return form_dropdown('user_age_to', $list, $selected, $class);
		}
	}
	
	function _createYear($selected = 1995)
	{
		$list = getSelectYear();
		$class = 'class="select5"';
		
		return form_dropdown('user_year', $list, $selected, $class);
	}
	
	function _createDay($selected = 1)
	{
		$list = getSelectDays();
		$class = 'class="select5"';
		
		return form_dropdown('user_day', $list, $selected, $class);
	}
	
	function _createReligion($selected = 0)
	{
		$list = array
		(
			'0' => '',
			'1' => $this->lang->line('profile_edit_rel_ch'),
			'2' => $this->lang->line('profile_edit_rel_bud'),
			'3' => $this->lang->line('profile_edit_rel_cat'),
			'4'	=> $this->lang->line('profile_edit_rel_jew'),
			'5' => $this->lang->line('profile_edit_rel_mus'),
			'6' => $this->lang->line('profile_edit_rel_hin'),
			'7' => $this->lang->line('profile_edit_rel_none'),
			'8' => $this->lang->line('profile_edit_rel_other')
		);
		$class = 'class="select3"';
		
		return form_dropdown('user_religion', $list, $selected, $class);
	}
	
	function _createSmokingDrinking($type, $selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => $this->lang->line('yes'),
			'2' => $this->lang->line('no')
		);
		$class = 'class="select2"';
		
		if ($type == 1) // smoking
		{
			return form_dropdown('user_smoking', $list, $selected, $class);
		}
		elseif ($type == 2) // drinking
		{
			return form_dropdown('user_drinking', $list, $selected, $class);
		}
	}
	
	function _createMarriage($selected = '0')
	{
		$types = array (
			'0' => '',
			'1' => $this->lang->line('profile_edit_marr_single'),
			'2' => $this->lang->line('profile_edit_marr_widowed'),
			'3' => $this->lang->line('profile_edit_marr_div'),
			'4' => $this->lang->line('profile_edit_marr_never')
		);
		$class = 'class="select3"';
		
		return form_dropdown('user_marital_status', $types, $selected, $class);
	}
	
	function _createEducationLevel($selected = '0')
	{
		$types = array (
			'0'	=> '',
			'1' => $this->lang->line('profile_edit_edu_ss'),
			'2'	=> $this->lang->line('profile_edit_edu_hs'),
			'3'	=> $this->lang->line('profile_edit_edu_col'),
			'4' => $this->lang->line('profile_edit_edu_uni'),
			'5' => $this->lang->line('profile_edit_edu_doc'),
			'6' => $this->lang->line('profile_edit_edu_still')
		);
		$class = 'class="select3"';
		
		return form_dropdown('user_education', $types, $selected, $class);
	}
	
	function _createEyesColor($selected = '0')
	{
		$types = array (
			'0'	=> '',
			'1' => $this->lang->line('profile_edit_eyes_g'),
			'2'	=> $this->lang->line('profile_edit_eyes_gr'),
			'3' => $this->lang->line('profile_edit_eyes_h'),
			'4' => $this->lang->line('profile_edit_eyes_br'),
			'5' => $this->lang->line('profile_edit_eyes_bl'),
			'6' => $this->lang->line('profile_edit_eyes_b')
		);
		$class = 'class="select2"';
		
		return form_dropdown('user_eyes_color', $types, $selected, $class);
	}
}