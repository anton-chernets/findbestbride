<?php

Class Ank extends MY_Controller
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
		$this->load->model('admin/edit_model', 'eModel');
		$this->load->model('admin/ankets_model', 'ankets_model');
		$this->lang->load('english/admin');
		$this->lang->load('english/profile');
		$this->load->library(array('editor', 'form_validation'));
	}
	
	function avatar()
	{		
		/////////////////////////////////////////////////////////////////////////
		// загрузка нового аватара
		if ($this->input->post())
		{
			if ($_FILES['userfile'])
			{
				$user_id = $this->input->post('u_id');
				
				$upload['upload_path'] 	= './profiles/photo/user_' . $user_id . '/';
				$upload['max_size']		= 1024 * $this->engine['engine_max_image'];
				$upload['allowed_types']= 'jpg|jpeg';
				$upload['encrypt_name']	= true;
				
				$this->load->library('upload', $upload);
				$this->load->helper('create_avatars');
				
				//
				$isDir = (file_exists($upload['upload_path'])) ? true : false;
				$isIndex = (file_exists($upload['upload_path'] . 'index.html')) ? true : false;
				
				if ($isDir == false)
				{
					@mkdir($upload['upload_path'], 0777, true);
				}
				
				if ($isIndex == false)
				{
					$file = @fopen($upload['upload_path'] . 'index.html', 'w');
					@fwrite($file, 'Access forbidden');
					@fclose($file);
				}
				
				//
				if ($this->upload->do_upload())
				{
					$uploadData = $this->upload->data();
					
					if (!empty($this->engine['engine_watermark']))
					{
						$this->load->library('image_lib');
					
						$watermark['source_image'] = $uploadData['full_path'];
						$watermark['wm_type'] = 'overlay';
						$watermark['wm_vrt_alignment'] = 'bottom';
						$watermark['wm_hor_alignment'] = 'center';
						$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
						$watermark['wm_opacity'] = '60';
					
						$this->image_lib->initialize($watermark);
					
						$this->image_lib->watermark();
					}
					
					// создадим миниатюры фотки
					// какой умник придумал 5 миниатюр?
					$avatarSettings = array (
						'thumbs'	=> array (
							array('w' => '220', 'h' => '220', 'name' => $uploadData['raw_name'] . '_220', 'ext' => '.jpg', 'crop' => true),
							array('w' => '100', 'h' => '148', 'name' => $uploadData['raw_name'] . '_100', 'ext' => '.jpg', 'crop' => true),
							array('w' => '342', 'h' => '500', 'name' => $uploadData['raw_name'] . '_342', 'ext' => '.jpg', 'crop' => true),
							array('w' => '240', 'h' => '360', 'name' => $uploadData['raw_name'] . '_240', 'ext' => '.jpg', 'crop' => true),
							array('w' => '100', 'h' => '100', 'name' => $uploadData['raw_name'] . '_101', 'ext' => '.jpg', 'crop' => true)
						),
						'newimg'	=> array (
							array('max_w' => '342', 'max_h' => '99999', 'name' => $uploadData['raw_name'] . '_original')
						),
						'newimg_folder' => $uploadData['file_path'],
						'thumb_folder'	=> $uploadData['file_path'],
						'saveNewImg'	=> '1',
						'saveThumb'		=> '1'
					);
					
					$createAvatar = createAvatar($uploadData['full_path'], $avatarSettings);
					
					if ($createAvatar['0'] == true)
					{
						$this->db->update('user_profile', array('photo_link' => $uploadData['raw_name']), array('id' => $this->input->post('u_id')));
						
						unlink($uploadData['full_path']);
						
						redirect('/admin/ank/edit/' . $this->input->post('u_id'));
					}
				}
			}
		}
	}
	
	public function messages()
	{
		if (!$this->input->post('u_id'))
		{
			$this->layout('admin', 'admin/ankets/messages_index_view', array());
		}
		else
		{
			$userId = $this->input->post('u_id');
			
			$messages = $this->ankets_model->getUserInboxMessages($userId);
			$data['messages'] = array();
			
			foreach ($messages as $message)
			{
				$data['messages'][] = array(
					'message' => $message['message'],
					'to_info' => $this->mainModel->getUserProfile($message['to_user_id']),
					'from_info' => $this->mainModel->getUserProfile($message['from_user_id']),
					'date'	=> date('d.m.Y H:i', $message['msg_date']),
					'is_replayed' => $message['is_replayed'],
					'is_read' => $message['is_read']
				);
			}
			
			$this->layout('admin', 'admin/ankets/messages_read_view', $data);
		}
	}
	
	public function b_un($user_id)
	{
		$this->db->update('user_profile', array('user_status' => 0), array('id' => $user_id));
		
		redirect('/admin/ank/blocked');
	}
	
	
	public function blocked()
	{
		$list = $this->db->get_where('user_profile', array('user_status' => 1))->result_array();
		
		$this->layout('admin', 'admin/ankets/blocked_view', array('list' => $list));
	}
	
	public function chats()
	{
		$data['list'] = $this->db->get('user_chat')->result_array();
		
		$this->layout('admin', 'admin/ankets/chats_view', $data);
	}
	
	public function chat_msg($chat_name)
	{
		$data['list'] = $this->db->get_where('user_chat_messages', array('chat_name' => $chat_name))->result_array();
		
		$this->layout('admin', 'admin/ankets/chats_msg_view', $data);
	}
	
	function message()
	{
		$resInfo = '';
		
		if ($this->input->post('new'))
		{
			$validRules = array(
				array (
					'field'	=> 'u_id',
					'label'	=> 'user id',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_subject',
					'label'	=> 'message subject',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'u_message',
					'label'	=> 'message',
					'rules'	=> 'required'
				)
			);
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$newMessage = array (
					'from_user_id'	=> '0',
					'to_user_id'	=> $this->input->post('u_id'),
					'subject'		=> $this->input->post('u_subject'),
					'message'		=> $this->editor->parse_message($this->input->post('u_message')),
					'msg_date'		=> time(),
					'msg_type'		=> '1'
				);
				
				$this->aModel->sendUserMessage($newMessage);
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('u_msg_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('p_msg_false'));
			}
		}
		
		$this->layout('admin', 'admin/ankets/message_view', array('resInfo' => $resInfo), $this->lang->line('p_message_title'));
	}
	
	function block()
	{
		$resInfo = '';
		
		if ($this->input->post('new'))
		{
			$id = (int)$this->input->post('u_id');
			$info = $this->mainModel->getUserProfile($id);
			
			if ($info != false)
			{
				$this->aModel->blockUser($id);
				
				$resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('u_block_ok'), $info['name'], $info['lastname']));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('u_block_false'));
			}
		}
		
		$this->layout('admin', 'admin/ankets/block_view', array('resInfo' => $resInfo), $this->lang->line('u_block_title'));
	}
	
	function unblock()
	{
		$resInfo = '';
		
		if ($this->input->post('new'))
		{
			$id = (int)$this->input->post('u_id');
			$info = $this->mainModel->getUserProfile($id);
			
			if ($info != false)
			{
				$this->aModel->unblockUser($id);
				
				$resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('u_unblock_ok'), $info['name'], $info['lastname']));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('u_block_false'));
			}
		}
		
		$this->layout('admin', 'admin/ankets/unblock_view', array('resInfo' => $resInfo), $this->lang->line('u_unblock_title'));
		
	}
	
	/* С•СњР‹РЊСџвЂ¦ вЂ”С•В»вЂ”СњВ  С�РЊВ в‰€вЂњ */
	
	function all($sex = '', $sort = '')
	{
		$show_agency = false;
		
		if ($this->input->post('p_id'))
		{
			$show_agency = ($this->input->post('p_id') > 0) ? $this->input->post('p_id') : false;
		}
		
		$list = $this->aModel->getTotalProfiles($show_agency, $sort, $sex);
		
		$this->layout('admin', 'admin/ankets/all_ankets_view', array('list' => $list), $this->lang->line('total_ank_title'));
	}
	
	public function unlist()
	{
		if (IS_AJAX)
		{
			$this->db->update('user_profile', array('in_list' => 0), array('id' => $this->input->post('id')));
		}
	}
	
	//* СЃРїРёСЃРѕРє email РјСѓР¶С‡РёРЅ */
	
	function man_emails()
	{
		$all_list = $this->aModel->getAllManEmails();
		
		$this->layout('admin', 'admin/ankets/man_emails_view', array('list' => $all_list));
	}
	
	function women_emails()
	{
		$all_list = $this->aModel->getAllWomenEmails();
		
		$this->layout('admin', 'admin/ankets/women_emails_view', array('list' => $all_list));
	}
	
	function add_credits()
	{
		$resInfo = '';
		
		if ($this->input->post('add'))
		{
			$credits = $this->input->post('u_credits');
			$user_id = $this->input->post('u_id');
			
			if ($credits > 0 && $credits < 10001)
			{
				$this->aModel->addCreditsToMen($user_id, $credits);
				
				$resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('add_cred_ok'), $credits));
			}
			elseif ($credits < 0)
			{
				$info = $this->mainModel->getUserProfile($user_id);
				
				if ($info['credits'] >= $credits)
				{
					$newCredits = $info['credits'] + $credits;
					
					$this->mainModel->updateCredits($user_id, $newCredits);
					
					$resInfo = array('type' => 'success', 'text' => sprintf($this->lang->line('minus_creds_ok'), $credits));
				}
				else
				{
					$resInfo = array('type' => 'error', 'text' => $this->lang->line('add_cred_nocred'));
				}
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('add_cred_fail'));
			}
		}
		
		$this->layout('admin', 'admin/ankets/add_credits_view', array('resInfo' => $resInfo), $this->lang->line('add_cred_title'));
	}
	
	function not_activated()
	{
		$uri = $this->uri->segment(4);
		
		/* вЂќЖ’С�Р‹в‰€РЊВ»в‰€ С�В В С�вЂќРЊвЂњС� */
		if ($uri == 'delete' && $this->input->post('id'))
		{
			$this->aModel->blockUser($this->input->post('id'));
			
			echo json_encode(array('result' => 'success'));
			return false;
		}
		
		/* С�В вЂњВ»В¬С�Г·В»СЏ */
		if ($uri == 'activate' && $this->input->post('id'))
		{
			$this->aModel->unblockUser($this->input->post('id'));
			
			echo json_encode(array('result' => 'success'));
			return false;
		}
		
		/* С•СњВ¬вЂњСњвЂ“РЊС�СЏ СњвЂњС•вЂ“С�В¬В С� С•В»вЂ”в„–С›С� */
		if ($uri == 're_email' && $this->input->post('id'))
		{
			$id = $this->input->post('id');
			$info = $this->mainModel->getUserProfile($id);
			
			$this->load->library('email', array('mailtype' => 'html'));
				
			$this->email->from('register@findbestbride.com');
			$this->email->to($info['email']);
			$this->email->subject('REPLY: Welcome on findbestbride.com! Your register parameters');
				
			$mailBody = '
						<html>
							<body>
								Hello, <b>' . $info['name'] . '</b>!<br/><br/>
								<b>This letter was sent again, because your account has not been activated</b><br/><br/>
								Thank you for registering on our site! <a href="https://findbestbride.com" target="_blank">https://findbestbride.com/</a> it`s a unique opportunity to meet your soul mate through the Internet. Register for FREE, fill in the form and receive hundreds of proposals to get acquainted every day!
								<br/><br/>
								For activating your profile click here: <a href="https://findbestbride.com/activation/' . $info['activate_code'] . '">ACTIVATION LINK</a>.<br/><br/>
								Your login: <b>'. $info['email'] . '</b>,<br/>><br/>
								If you are not registered, just ignore the letter.<br/><br/>
			
								If you need help click here: <a href="https://findbestbride.com/support/">SUPPORT</a><br/><br/>
								Sincerely, Administration<br/>
								<a href="https://findbestbride.com" target="_blank">findbestbride.com</a>
							</body>
						</html>
					';
			$this->email->message($mailBody);
			$this->email->send();
			
			echo json_encode(array('result' => 'success'));
			return false;
		}
			
		
		$profiles = $this->aModel->getNotActivatedAnkets();
		
		$this->layout('admin', 'admin/ankets/not_activated_view', array('list' => $profiles), $this->lang->line('nap_title'));
	}
	
	/***********************************************************************************/
	// вЂ“в‰€Ж’С�В вЂњВ»вЂ“СњВ¬С�РЊВ»в‰€ С•вЂ“СњвЂ�В»Р‹СЏ
	function edit($name = false)
	{
		$this->load->model('admin/edit_model', 'edit_model');
		$resInfo = '';
		if (!$name)
		{
			$this->layout('admin', 'admin/ankets/edit/index_view', array(), $this->lang->line('edit_title'));
		}
		else
		{
			
			// вЂ”СњвЂ™вЂ“С�РЊв‰€РЊВ»в‰€ В»РЊвЂ�СњвЂ“С›С�Г·В»В» С•вЂ“СњвЂ�В»Р‹СЏ
			if ($this->input->post('save'))
			{
				$this->load->library('form_validation');
				
				$rules = array(
					array (
						'field'	=> 'u_name',
						'label'	=> 'user name',
						'rules'	=> 'required'		
					),
					array (
						'field'	=> 'u_lastname',
						'label'	=> 'user lastname',
						'rules'	=> 'required',		
					),
					array (
						'field' => 'u_email',
						'label' => 'user email',
						'rules' => 'required|valid_email'
					)	
				);
				$this->form_validation->set_rules($rules);
				
				if ($this->form_validation->run() != false)
				{
					$id = $this->input->post('profile');
					
					// sex?
					$info = $this->mainModel->getUserProfile($id);
					
					//
					// Ж’РѕР±Р°РІР»РµРЅРѕ РІ РІРµСЂСЃРёРё 1.3
					// С•РµСЂРµРЅРѕСЃ С„РѕС‚РѕРіСЂР°С„РёР№ РґРѕРєСѓРјРµРЅС‚РѕРІ Рє РЅРѕРІРѕРјСѓ РїР°СЂС‚РЅРµСЂСѓ, РµСЃР»Рё Сѓ Р°РЅРєРµС‚С‹ РјРµРЅВ¤РµС‚СЃВ¤ Р°РіРµРЅСЃС‚РІРѕ
					if ($this->input->post('p_id') != 0 && $this->input->post('p_id') != $info['is_agency'] && $info['is_passport'] != '')
					{
						$getNowAgency = $info['is_agency'];
						
						// РµСЃР»Рё Р°РЅРєРµС‚Р° РЅРѕРІР°В¤, Рё Сѓ РЅРµРµ СЃРєР°РЅ 3 СЃС‚СЂР°РЅРёС† РїР°СЃРїРѕСЂС‚Р°
						if ($info['is_passport'] == 1)
						{
							$p_list = $this->eModel->getPassportList($id);
							
							foreach ($p_list as $pass)
							{
								copy('./profiles/partner/p_'.$getNowAgency.'/'.$pass['passport'], './profiles/partner/p_'.$this->input->post('p_id').'/'.$pass['passport']);
								
								unlink('./profiles/partner/p_'.$getNowAgency.'/'.$pass['passport']);
							}
						}
						// РµСЃР»Рё Р°РЅРєРµС‚Р° СЃС‚Р°СЂР°В¤, Р·Р°РіСЂСѓР¶РµРЅР° 1 СЃС‚СЂР°РЅРёС†Р° РїР°СЃРїРѕСЂС‚Р°
						else 
						{
							copy('./profiles/partner/p_'.$getNowAgency.'/'.$info['is_passport'].'.jpg', './profiles/partner/p_'.$this->input->post('p_id').'/'.$info['is_passport'].'.jpg');
							
							unlink('./profiles/partner/p_'.$getNowAgency.'/'.$info['is_passport'].'.jpg');
						}
					}
					
					$mainData = array(
						'name'		=> $this->input->post('u_name'),
						'lastname'	=> $this->input->post('u_lastname'),
						'is_agency' => $this->input->post('p_id'),
						'email' 	=> $this->input->post('u_email'),
						'w_phone'	=> $this->input->post('u_phone'),
						'b_day'		=> $this->input->post('u_day'),
						'b_month'	=> $this->input->post('u_month'),
						'b_year'	=> $this->input->post('u_year'),
						'age'		=> getAgeFromDate($this->input->post('u_year') .'-'. $this->input->post('u_month') .'-'. $this->input->post('u_day'))
					);
					
					if ($this->input->post('u_pwd'))
					{
						$mainData['password'] = md5($this->input->post('u_pwd'));
						$mainData['pw'] = $this->input->post('u_pwd');
					}
					
					if ($this->input->post('agency_id') && $this->input->post('agency_id') > 0)
					{
						$mainData['is_agency'] = $this->input->post('agency_id');
					}
					
					$detailsData = array(
						'city'			=> $this->input->post('u_city'),
						'occupation'	=> $this->input->post('u_occup'),
						'hobbies'		=> $this->input->post('u_hobbie'),
						'aoa'			=> $this->input->post('u_aoa'),
						'about_me'		=> $this->input->post('u_self'),
						'about_partner'	=> $this->input->post('u_partner'),
						'marriage' 		=> $this->input->post('u_marital_status'),
						'children'		=> $this->input->post('u_children'),
						'height'		=> $this->input->post('u_height'),
						'weight'		=> $this->input->post('u_weight'),
						'eyes'			=> $this->input->post('u_eyes_color'),
						'hair'			=> $this->input->post('u_hair'),
						'religion'		=> $this->input->post('u_religion'),
						'education'		=> $this->input->post('u_education'),
						'smoke'			=> $this->input->post('u_smoking'),
						'drink'			=> $this->input->post('u_drinking'),
						'age_from'		=> $this->input->post('u_age_from'),
						'age_to'		=> $this->input->post('u_age_to'),
						//'type_of_man'	=> $this->input->post('u_man')
					);
					
					$this->eModel->changeProfileInfo($mainData, $detailsData, $id, $info['sex']);
					
					$resInfo = array('type' => 'success', 'text' => $this->lang->line('edit_ok'));
				}
				else
				{
					$resInfo = array('type' => 'error', 'text' => $this->lang->line('edit_false'));
				}
			}
			
			// РІС‹С‚В¤РЅРµРј РёРЅС„Сѓ Р°РєРєР°СѓРЅС‚Р°
			$p_info = $this->mainModel->getUserProfile($name);
			
			// РµСЃР»Рё Р°РєРєР°СѓРЅС‚ СЃСѓС‰РµСЃС‚РІСѓРµС‚ - РїСЂРѕРґРѕР»Р¶Р°РµРј
			if ($p_info != false)
			{
				// РІС‹С‚В¤РЅРµРј С„РѕС‚РєРё СЌС‚РѕРіРѕ Р°РєРєР°СѓРЅС‚Р°
				$photo = $this->eModel->getUserPhoto($name);
				// РІС‹С‚В¤РЅРµРј РґРµС‚Р°Р»Рё Р°РєРєР°СѓРЅС‚Р°
				$details = $this->eModel->getUserDetails($name, $p_info['sex']);
				// РµСЃС‚СЊ Р»Рё Сѓ Р°РєРєР°СѓРЅС‚Р° РїСЂРёРєСЂРµРїР»РµРЅРЅС‹Рµ СЃРєР°РЅС‹ РґРѕРєСѓРјРµРЅС‚РѕРІ?
				if (!empty($p_info['is_passport']))
				{
					if ($p_info['is_passport'] == 1)
					{
						$passport = $this->ankets_model->getPassport($p_info['id']);
					}
					else 
					{
						$passport = $p_info['is_passport'];
					}
				}
				else
				{
					$passport = false;
				}
				
				$form = array(
					'bday' => $this->_createDay($p_info['b_day']),
					'bmonth' => $this->_createMonth($p_info['b_month']),
					'byear' => $this->_createYear($p_info['b_year']),
					'hair' => $this->_createHairColor($details['hair']),
					'children' => $this->_createChildren($details['children']),
					'eyes' => $this->_createEyesColor($details['eyes']),
					'marital' => $this->_createMarriage($details['marriage']),
					'edu' => $this->_createEducationLevel($details['education']),
					'religion' => $this->_createReligion($details['religion']),
					'smoking' => $this->_createSmokingDrinking(1, $details['smoke']),
					'drinking' => $this->_createSmokingDrinking(2, $details['drink']),
					'country' => $this->_createCountry($p_info['country']),
					'height' => $this->_createHeight($details['height']),
					'weight' => $this->_createWeight($details['weight']),
					'age_from' => $this->_createSearchAge(1, $details['age_from']),
					'age_to' => $this->_createSearchAge(2, $details['age_to'])	
				);
				
				if ($p_info['sex'] == 2)
				{
					$form['english'] = $this->_createEnglish($details['english']);
				}
				
				$partner_list = $this->db->get_where('user_partner', array('p_status' => 2))->result_array();
				
				$this->layout('admin', 'admin/ankets/edit/edit_view', array('info' => $p_info, 'partners' => $partner_list, 'passport' => $passport, 'photo' => $photo, 'details' => $details, 'resInfo' => $resInfo, 'form' => $form), $this->lang->line('edit_title'));
			}
		}
	}
	
	/**********************************************************************************
	 * СњСЃС‚Р°С‚РѕРє РєСЂРµРґРёС‚РѕРІ Сѓ РјСѓР¶С‡РёРЅ
	 */
	
	function men_credits()
	{		
		$list = array();
		
		$credits = $this->ankets_model->men_credits();
		
		foreach ($credits as $credit)
		{
			$list[] = array(
				'name' => $credit['name'] . ' ' . $credit['lastname'],
				'credits' => $credit['credits'],
				'email' => $credit['email'],
				'id' => $credit['id']	
			);
		}
		
		$this->layout('admin', 'admin/ankets/men_credits_view', array('list' => $list), $this->lang->line('men_credits_title'));
	}
	
	public function download_passport($passportId)
	{
		$get = $this->db->get_where('user_passport', array('passportId' => $passportId))->row_array();
		$user = $this->mainModel->getUserProfile($get['user_id']);
		$file = './profiles/partner/p_' . $user['is_agency'] . '/' . $get['passport'];
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
	}
	
	public function download_photo($passportId)
	{
		$get = $this->db->get_where('user_photos', array('photo_id' => $passportId))->row_array();
		//$user = $this->mainModel->getUserProfile($get['user_id']);
		$file = './profiles/photo/user_' . $get['id'] . '/' . $get['photo_name'] . '.jpg';
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
	}
	
	public function download_avatar($userId)
	{
		$user = $this->mainModel->getUserProfile($userId);
		$file = './profiles/photo/user_' . $user['id'] . '/' . $user['photo_link'] . '.jpg';
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
	}
	
	function ajax($action)
	{
		if ($action == 'avatar_delete')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$id = $this->input->post('id');
				$info = $this->mainModel->getUserProfile($id);
				$this->eModel->deleteAvatar($id);
				
				unlink('./profiles/photo/user_' . $id . '/' . $info['photo_link'] . '_220.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $info['photo_link'] . '_100.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $info['photo_link'] . '_342.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $info['photo_link'] . '_240.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $info['photo_link'] . '_original.jpg');
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'delete_passport')
		{
			if (IS_AJAX)
			{
				$check = $this->db->get_where('user_passport', array('passportId' => $this->input->post('id')))->row_array();
				$user = $this->mainModel->getUserProfile($check['user_id']);
				
				@unlink('./profiles/partner/p_' . $user['is_agency'] . '/' . $check['passport']);
				$this->db->query('DELETE FROM user_passport WHERE passportId = ' . $this->input->post('id'));
			}
		}
		
		elseif ($action == 'photo_delete')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$id = $this->input->post('id');
				$photo = $this->input->post('photo');
				
				$this->eModel->deletePhoto($id, $photo);
				
				unlink('./profiles/photo/user_' . $id . '/' . $photo . '_105.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $photo . '_170.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $photo . '_439.jpg');
				unlink('./profiles/photo/user_' . $id . '/' . $photo . '_full.jpg');
				
				echo json_encode(array('result' => 'success'));
			}
		}
	}
	
	function _createYear($selected = 1995)
	{
		$list = getSelectYear();
		$class = 'class="form-control" style="width: 10%;"';
	
		return form_dropdown('u_year', $list, $selected, $class);
	}
	
	function _createDay($selected = 1)
	{
		$list = getSelectDays();
		$class = 'class="form-control" style="width: 7%;"';
	
		return form_dropdown('u_day', $list, $selected, $class);
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
		$class = 'class="form-control" style="width: 20%;"';
	
		return form_dropdown('u_month', $list, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_hair', $list, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_children', $list, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_marital_status', $types, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_education', $types, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_eyes_color', $types, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_religion', $list, $selected, $class);
	}
	
	function _createSmokingDrinking($type, $selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => $this->lang->line('yes'),
				'2' => $this->lang->line('no')
		);
		$class = 'class="form-control"';
	
		if ($type == 1) // smoking
		{
			return form_dropdown('u_smoking', $list, $selected, $class);
		}
		elseif ($type == 2) // drinking
		{
			return form_dropdown('u_drinking', $list, $selected, $class);
		}
	}
	
	function _createCountry($selected)
	{
		$list = userCountry();
		$class = 'class="form-control"';
	
		return form_dropdown('u_country', $list, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_english', $list, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_height', $list, $selected, $class);
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
		$class = 'class="form-control"';
	
		return form_dropdown('u_weight', $list, $selected, $class);
	}
	
	function _createSearchAge($type, $selected = 18)
	{
		$list = createMinMaxAge();
		$class = 'class="form-control" style="width:10%;"';
		// РјРёРЅРёРјР°Р»СЊРЅС‹Р№ РІРѕР·СЂР°СЃС‚ РІ РїРѕРёСЃРєРµ
		if ($type == 1)
		{
			return form_dropdown('u_age_from', $list, $selected, $class);
		}
		elseif ($type == 2)
		{
			return form_dropdown('u_age_to', $list, $selected, $class);
		}
	}
}