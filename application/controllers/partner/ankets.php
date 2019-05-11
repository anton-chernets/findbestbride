<?php

Class Ankets extends MY_Controller
{
	var $error;
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner/');
			return false;
		}
		
		if ($this->partInfo['p_status'] != 2)
		{
			redirect(base_url() . 'partner/first/');
			return false;
		}
		
		$this->load->model('partner/partner_model', 'pModel');
		$this->load->model('profile_model', 'profModel');
		$this->lang->load('english/partner');
		$this->lang->load('english/profile');
		$this->lang->load('english/common');
		$this->load->library('form_validation');
	}
	
	function index()
	{
		$profiles = $this->pModel->allAnkets($this->partId);
		
		$this->layout('partner', 'partner/ankets/all_view', array('profiles' => $profiles), $this->lang->line('partner_all_title'));
	}
	
	// активные анкеты
	
	function active()
	{
		$profiles = $this->pModel->activeAnkets($this->partId);
		
		$this->layout('partner', 'partner/ankets/active_view', array('profiles' => $profiles), $this->lang->line('partner_active_title'));
	}
	
	// в ожидании активации
	function waiting()
	{
		$profiles = $this->pModel->waitAnkets($this->partId);
		
		$this->layout('partner', 'partner/ankets/waiting_view', array('profiles' => $profiles), $this->lang->line('partner_wait_title'));
	}
	
	// не активные
	
	function inactive()
	{
		$profiles = $this->pModel->inactiveAnkets($this->partId);
		
		$this->layout('partner', 'partner/ankets/inactive_view', array('profiles' => $profiles), $this->lang->line('partner_inactive_title'));
	}
	
	// анкеты онлайн
	
	function online()
	{
		$profiles = $this->pModel->onlineAnkets($this->partId);
		
		$this->layout('partner', 'partner/ankets/online_view', array('profiles' => $profiles), $this->lang->line('partner_online_title'));
	}
	
	// чтение сообщений анкеты
	// @since 1.3
	public function messages()
	{
		$this->load->model('partner/messages_model');
		if ($this->input->post())
		{
			if ($this->input->post('a_id') != '')
			{
				$anket = (int)$this->input->post('a_id');
				
				//in
				$in = $this->messages_model->getInMessages($anket);
				//out
				$out = $this->messages_model->getOutMessages($anket);
				
				$this->layout('partner', 'partner/ankets/messages/read_view', array('in' => $in, 'out' => $out), $this->lang->line('partner_ank_msg_title'));
				return false;
			}
			else
			{
				$this->error = $this->lang->line('partner_ank_msg_error');
			}
		}
		
		$this->layout('partner', 'partner/ankets/messages/index_view', array('error' => $this->error), $this->lang->line('partner_ank_msg_title'));
	}
	
	// добавление анкет
	
	function add()
	{
		$resInfo = '';
		
		if ($this->input->post('add_profile'))
		{
			if ($_FILES['passport_1']['name'])
			{
				$validRules = array(
					array (
						'field'	=> 'name',
						'label'	=> 'name',
						'rules'	=> 'required|xss_clean'
					),
					array (
						'field' => 'lastname',
						'label'	=> 'lastname',
						'rules'	=> 'required|xss_clean'
					),
					array (
						'field'	=> 'email',
						'label'	=> 'email',
						'rules'	=> 'required|valid_email'
					),
					array (
						'field'	=> 'pwd',
						'label'	=> 'password',
						'rules'	=> 'required'
					),
					array (
						'field'	=> 'mobile',
						'label'	=> 'phone',
						'rules'	=> 'required'
					)
				);
				
				$this->form_validation->set_rules($validRules);
				
				if ($this->form_validation->run() != false)
				{
					$upload_path = './profiles/partner/p_' . $this->partId . '/';
					$types = array('image/jpg', 'image/jpeg');
					
					$isDir = (file_exists($upload_path)) ? true : false;
					$isIndex = (file_exists($upload_path . 'index.html')) ? true : false;
					
					if ($isDir == false)
					{
						@mkdir($upload_path, 0777, true);
					}
					
					if ($isIndex == false)
					{
						$file = @fopen($upload_path . 'index.html', 'w');
						@fwrite($file, 'Access forbidden');
						@fclose($file);
					}
					
					if (in_array($_FILES['passport_1']['type'], $types))
					{
						ignore_user_abort(1);
						set_time_limit(0);
						
						$dirname_1 = $upload_path . md5($_FILES['passport_1']['name']) . '.jpg';
						//$dirname_2 = $upload_path . md5($_FILES['passport_2']['name']) . '.jpg';
						//$dirname_3 = $upload_path . md5($_FILES['passport_3']['name']) . '.jpg';
						
						if (move_uploaded_file($_FILES['passport_1']['tmp_name'], $dirname_1))
						{
						
							$insert = array(
								'name'		=> $this->input->post('name'),
								'lastname'	=> $this->input->post('lastname'),
								'sex'		=> '2',
								'country'	=> $this->input->post('user_country'),
								'email'		=> $this->input->post('email'),
								'password'	=> md5($this->input->post('pwd')),
								'user_status'=> '3',
								'register_date'=> time(),
								'is_agency'	=> $this->partId,
								'w_phone'	=> $this->input->post('mobile'),
								'is_passport'=> 1,
								'pw'		=> $this->input->post('pwd')
							);
							
							$this->pModel->insertNewUser($insert, array(md5($_FILES['passport_1']['name'])));
						
							$resInfo = array('result' => 'success', 'text' => $this->lang->line('partner_add_ok'));
					
						}
					}
					else
					{
						$resInfo = array('result' => 'error', 'text' => $this->lang->line('partner_add_ue'));
					}
				}
				else
				{
					$resInfo = array('result' => 'error', 'text' => $this->lang->line('partner_add_ve'));
				}
			}
			else 
			{
				$resInfo = array('result' => 'error', 'text' => $this->lang->line('partner_add_fe'));
			}
		}
		
		$country = $this->_country();
		
		$this->layout('partner', 'partner/ankets/add_anket_view', array('country' => $country, 'resInfo' => $resInfo), $this->lang->line('partner_add_title'));
	}
	
	function _country()
	{
		$list = userCountry();
		$class = 'class="form-control"';
		
		return form_dropdown('user_country', $list, '1', $class);
	}
	
	
	function photos($id)
	{
		//////////////////////////////////////////////////////////////////////
		// загрузка новой фотографии 
		if ($this->input->post('new'))
		{
			if($_FILES['userfile'] && $this->profModel->getMyPhotoCount($this->input->post('u_id')) < 5)
			{
				$user_id = $this->input->post('u_id');
				
				$upload['upload_path']	= './profiles/photo/user_' . $user_id . '/';
				$upload['max_size']		= 1024 * $this->engine['engine_max_image'];
				$upload['allowed_types']= 'jpg|jpeg';
				$upload['encrypt_name']	= true;
				
				$this->load->library('upload', $upload);
				$this->load->helper('create_avatars');
				
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
				
				if ($this->upload->do_upload())
				{
					ignore_user_abort(1);
					set_time_limit(0);
				
					$uploadData = $this->upload->data();
					
					if ($uploadData['image_width'] >= 1920 && $uploadData['image_height'] >= 1280)
					{
					
						$photoSettings = array (
							'thumbs' => array (
								array('w' => '105', 'h' => '120', 'name' => $uploadData['raw_name'] . '_105', 'ext' => '.jpg', 'crop' => true),
								array('w' => '170', 'h' => '156', 'name' => $uploadData['raw_name'] . '_170', 'ext' => '.jpg', 'crop' => true)
							),
							'crop' => true,
							'newimg' => array (
								array ('max_w' => '600', 'max_h' => '999999', 'name' => $uploadData['raw_name'] . '_full')
							),
							'newimg_folder' => $uploadData['file_path'],
							'thumb_folder'	=> $uploadData['file_path'],
							'saveNewimg'	=> '1',
							'saveThumb'		=> '1'
						);
					
						$createPhotos = createAvatar($uploadData['full_path'], $photoSettings);
					
						if ($createPhotos[0] == true)
						{
							$this->profModel->saveNewPhoto($user_id, $uploadData['raw_name']);
							
							/* Накладываем водяной знак */
						if (!empty($this->engine['engine_watermark']))
						{
							$this->load->library('image_lib');
							
							$watermark['source_image'] = $uploadData['raw_name'] . '_full.jpg';
							$watermark['wm_type'] = 'overlay';
							$watermark['wm_vrt_alignment'] = 'bottom';
							$watermark['wm_hor_alignment'] = 'center';
							$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
							$watermark['wm_opacity'] = '60';
							
							$this->image_lib->initialize($watermark);
							
							$this->image_lib->watermark();
							$this->image_lib->clear();
							
							$watermark['source_image'] = $uploadData['raw_name'] . '_105.jpg';
							$watermark['wm_type'] = 'overlay';
							$watermark['wm_vrt_alignment'] = 'bottom';
							$watermark['wm_hor_alignment'] = 'center';
							$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
							$watermark['wm_opacity'] = '60';
							
							$this->image_lib->initialize($watermark);
							
							$this->image_lib->watermark();
							$this->image_lib->clear();
							
							$watermark['source_image'] = $uploadData['raw_name'] . '_170.jpg';
							$watermark['wm_type'] = 'overlay';
							$watermark['wm_vrt_alignment'] = 'bottom';
							$watermark['wm_hor_alignment'] = 'center';
							$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
							$watermark['wm_opacity'] = '60';
							
							$this->image_lib->initialize($watermark);
							
							$this->image_lib->watermark();
							$this->image_lib->clear();
						}
						
							//unlink($uploadData['full_path']);
						
							$resInfo = array('type' => 'success', 'text' => $this->lang->line('partner_photo_ok'));
						}
						else 
						{
							unlink($uploadData['full_path']);
							$resInfo = array('type' => 'error', 'text' => $this->lang->line('partner_upload_error'));
						}
					}
					else
					{
						unlink($uploadData['full_path']);
						$resInfo = array('type' => 'error', 'text' => 'Минимальное разрешение загружаемых фотографий: 1920х1280');
					}
				}
				else
				{
					$resInfo = array('type' => 'error', 'text' => $this->lang->line('partner_upload_error'));
				}
			}
		}
		$resInfo = '';
		
		if ($id)
		{
			$info = $this->mainModel->getUserProfile($id);
			
			if ($info != false && $info['is_agency'] == $this->partId)
			{
				$photos = $this->profModel->getUserPhotos($id);
				$this->layout('partner', 'partner/ankets/photos_view', array('photo' => $photos, 'info' => $info, 'resInfo' => $resInfo), $this->lang->line('partner_photo_title'));
			}
			else 
			{
				show_404();
			}
		}
	}
	
	function video($id)
	{
		$this->load->model('partner/video_model');
		$resInfo = '';
		
		/////////////////////////////////////////////////
		// загрузка видеопрезентации
		if ($this->input->post('new'))
		{
			$user_id = $this->input->post('u_id');
			
			$upload['upload_path']	= './profiles/video/user_' . $user_id . '/';
			$upload['allowed_types']= 'mp4|flv';
			$upload['encrypt_name'] = true;
			$upload['max_size']		= 1024 * 500;
			set_time_limit(0);
			ignore_user_abort(1);
			
			$this->load->library('upload', $upload);
			
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
			
			// загружаем новое
			if ($this->upload->do_upload())
			{
				$upData = $this->upload->data();
				
				$newVideo = array (
					'video_name' => $upData['file_name'],
					'id'		 => $user_id,
					'add_date'	 => time(),
					'mime_type'	 => $upData['file_type'],
					'approved'	 => '0'
				);
				
				$this->video_model->createNewVideo($newVideo);
				
				$this->mainModel->insertLog($this->partId, '2', sprintf($this->lang->line('log_part_new_video'), $user_id));
				
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('partner_video_ok'));
			}
			else
			{
				//print_r($_FILES);
				$resInfo = array('type' => 'error', 'text' => $this->upload->display_errors());
			}
		}
		
		if ($id)
		{
			$info = $this->mainModel->getUserProfile($id);
			{
				if ($info != false && $info['is_agency'] == $this->partId)
				{
					// список видео (с версии 1.3 можно загружать больше 1 видео)
					//$video = $this->profModel->getVideoInfo($id);
					$video = $this->video_model->getUserVideos($id);
					
					$exist = (count($video) > 0) ? true : false;
					
					$this->layout('partner', 'partner/ankets/video_view', array('isExist' => $exist, 'info' => $video, 'user' => $info, 'resInfo' => $resInfo), $this->lang->line('partner_video_title'));
				}
			}
		}
	}
	
	function avatar($id)
	{
		$resInfo = '';
		
		/////////////////////////////////////////////////////////////////////////
		// загрузка нового аватара
		if ($this->input->post('new'))
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
					mkdir($upload['upload_path'], 0777, true);
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
					
					if ($uploadData['image_width'] >= 640 && $uploadData['image_height'] >= 960)
					{
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
					
						// Если все миниатюры создались - сохраняем в БД, оригинал удаляем
						if ($createAvatar['0'] == true)
						{
							//$this->profModel->updateAvatarName($id, $uploadData['raw_name']);
							$this->db->update('user_profile', array('avatar_act' => $uploadData['raw_name']), array('id' => $id));
							
							if (!empty($this->engine['engine_watermark']))
							{
								$this->load->library('image_lib');
							
								$watermark['source_image'] = './profiles/photo/user_' . $id . '/' . $uploadData['raw_name'] . '_original.jpg';
								$watermark['wm_type'] = 'overlay';
								$watermark['wm_vrt_alignment'] = 'bottom';
								$watermark['wm_hor_alignment'] = 'center';
								$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
								$watermark['wm_opacity'] = '60';
							
								$this->image_lib->initialize($watermark);
							
								$this->image_lib->watermark();
								$this->image_lib->clear();
								
								$watermark['source_image'] = './profiles/photo/user_' . $id . '/' . $uploadData['raw_name'] . '_220.jpg';
								$watermark['wm_type'] = 'overlay';
								$watermark['wm_vrt_alignment'] = 'bottom';
								$watermark['wm_hor_alignment'] = 'center';
								$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
								$watermark['wm_opacity'] = '60';
							
								$this->image_lib->initialize($watermark);
							
								$this->image_lib->watermark();
								$this->image_lib->clear();
								
								$watermark['source_image'] = './profiles/photo/user_' . $id . '/' . $uploadData['raw_name'] . '_100.jpg';
								$watermark['wm_type'] = 'overlay';
								$watermark['wm_vrt_alignment'] = 'bottom';
								$watermark['wm_hor_alignment'] = 'center';
								$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
								$watermark['wm_opacity'] = '60';
							
								$this->image_lib->initialize($watermark);
							
								$this->image_lib->watermark();
								$this->image_lib->clear();
								
								$watermark['source_image'] = './profiles/photo/user_' . $id . '/' . $uploadData['raw_name'] . '_342.jpg';
								$watermark['wm_type'] = 'overlay';
								$watermark['wm_vrt_alignment'] = 'bottom';
								$watermark['wm_hor_alignment'] = 'center';
								$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
								$watermark['wm_opacity'] = '60';
							
								$this->image_lib->initialize($watermark);
							
								$this->image_lib->watermark();
								$this->image_lib->clear();
								
								$watermark['source_image'] = './profiles/photo/user_' . $id . '/' . $uploadData['raw_name'] . '_240.jpg';
								$watermark['wm_type'] = 'overlay';
								$watermark['wm_vrt_alignment'] = 'bottom';
								$watermark['wm_hor_alignment'] = 'center';
								$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
								$watermark['wm_opacity'] = '60';
							
								$this->image_lib->initialize($watermark);
							
								$this->image_lib->watermark();
								$this->image_lib->clear();
								
								$watermark['source_image'] = './profiles/photo/user_' . $id . '/' . $uploadData['raw_name'] . '_101.jpg';
								$watermark['wm_type'] = 'overlay';
								$watermark['wm_vrt_alignment'] = 'bottom';
								$watermark['wm_hor_alignment'] = 'center';
								$watermark['wm_overlay_path'] = './content/img/' . $this->engine['engine_watermark'];
								$watermark['wm_opacity'] = '60';
							
								$this->image_lib->initialize($watermark);
							
								$this->image_lib->watermark();
								$this->image_lib->clear();
							}
						
							//unlink($uploadData['full_path']);
						
							$this->mainModel->insertLog($this->partId, '2', sprintf($this->lang->line('log_part_new_avatar'), $user_id));
							$resInfo = array('type' => 'success', 'text' => $this->lang->line('partner_avatar_ok'));
						}
						// если хотя бы одна миниатюра не создалась - сносим все и выкидываем ошибку
						else 
						{
							unlink($uploadData['full_path']);
						
							$resInfo = array('type' => 'error', 'text' => $this->lang->line('partner_upload_error'));
						}
					}
					else
					{
						unlink($uploadData['full_path']);
						$resInfo = array('type' => 'error', 'text' => 'Минимальное разрешение для загружаемых аватавор: 640х960');
					}
				}
			}
		}
		
		if ($id)
		{
			$info = $this->mainModel->getUserProfile($id);
			
			if ($info != false && $info['is_agency'] == $this->partId)
			{
				
				$this->layout('partner', 'partner/ankets/change_avatar_view', array('info' => $info, 'resInfo' => $resInfo), $this->lang->line('partner_avatar_title'));
			}
		}
	}
	
	function profile($id)
	{
		$resInfo = '';
		
		if ($this->input->post('change_profile'))
		{
			$validRules = array(
				array (
					'field'	=> 'u_name',
					'label'	=> 'user name',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'u_lastname',
					'label'	=> 'user lastname',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'u_country',
					'label'	=> 'user country',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_education',
					'label'	=> 'user education level',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_marital_status',
					'label'	=> 'user marital status',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_height',
					'label'	=> 'user height',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_weight',
					'label'	=> 'user weight',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_eyes_color',
					'label'	=> 'user eyes color',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_hair',
					'label'	=> 'user hair color',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_smoking',
					'label'	=> 'smoking habbits',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_drinking',
					'label'	=> 'drinking habbits',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_phone',
					'label'	=> 'user mobile phone',
					'rules'	=> 'required|xss_clean'
				),
				array (
					'field'	=> 'u_about',
					'label'	=> 'about user',
					'rules'	=> 'xss_clean'
				),
				array (
					'field'	=> 'u_day',
					'label'	=> 'user birth day',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_month',
					'label'	=> 'user birth month',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_year',
					'label'	=> 'user birth year',
					'rules'	=> 'required|integer'
				),
				array (
					'field'	=> 'u_city',
					'label'	=> 'user city',
					'rules'	=> 'xss_clean'
				),
				array (
					'field'	=> 'u_occupation',
					'label'	=> 'occupation',
					'rules'	=> 'xss_clean'
				),
				array (
					'field' => 'u_religion',
					'label'	=> 'religion',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_children',
					'label'	=> 'children count',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_hobbies',
					'label'	=> 'hobbies',
					'rules'	=> 'xss_clean'
				),
				array (
					'field'	=> 'u_aoa',
					'label'	=> 'aoa',
					'rules'	=> 'xss_clean'
				),
				array (
					'field'	=> 'u_age_from',
					'label'	=> 'age from',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_age_to',
					'label'	=> 'age to',
					'rules'	=> 'integer'
				),
				array (
					'field'	=> 'u_partner',
					'label'	=> 'about partner',
					'rules'	=> 'xss_clean'
				)			
			);
			
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				$user_id = $this->input->post('u_id');
				$now = $this->mainModel->getUserProfile($user_id);
				$userAge = getAgeFromDate($this->input->post('u_year') . '-' . $this->input->post('u_month') . '-' . $this->input->post('u_day'));
				$change_fields = 'Changed info: ';
				
				if ($now['b_year'] != $this->input->post('u_year') || $now['b_month'] != $this->input->post('u_month') || $now['b_day'] != $this->input->post('u_day'))
				{
					$change_fields .= ' birthday date;';
				}
				
				if ($now['name'] != $this->input->post('u_name'))
				{
					$change_fields .= ' first name;';
				}
				
				if ($now['lastname'] != $this->input->post('u_lastname'))
				{
					$change_fields .= ' last name;';
				}
				
				if ($now['country'] != $this->input->post('u_country'))
				{
					$change_fields .= ' country;';
				}
				
				if ($now['w_phone'] != $this->input->post('u_phone'))
				{
					$change_fields .= ' telephone;';
				}
				
				if ($now['pw'] != $this->input->post('newpw'))
				{
					$change_fields .= ' password;';
				}
				
				$updateProfile = array (
					'name'		=> $this->input->post('u_name'),
					'lastname'	=> $this->input->post('u_lastname'),
					'country'	=> $this->input->post('u_country'),
					'b_day'		=> $this->input->post('u_day'),
					'b_month'	=> $this->input->post('u_month'),
					'b_year'	=> $this->input->post('u_year'),
					'age'		=> $userAge,
					'w_phone'	=> $this->input->post('u_phone'),
					'user_status' => '3'
				);
				
				if ($this->input->post('newpw'))
				{
					$updateProfile['password'] = md5($this->input->post('newpw'));
					$updateProfile['pw'] = $this->input->post('newpw');
				}
				
				$nowd = $this->db->get_where('women_details', array('id' => $user_id))->row_array();
				
				if ($nowd['city'] != $this->input->post('u_city'))
				{
					$change_fields .= ' city;';
				}
				
				if ($nowd['marriage'] != $this->input->post('u_marital_status'))
				{
					$change_fields .= ' marital status;';
				}
				
				if ($nowd['children'] != $this->input->post('u_children'))
				{
					$change_fields .= ' children information;';
				}
				
				if ($nowd['height'] != $this->input->post('u_height'))
				{
					$change_fields .= ' height;';
				}
				
				if ($nowd['weight'] != $this->input->post('u_weight'))
				{
					$change_fields .= ' weight;';
				}
				
				if ($nowd['eyes'] != $this->input->post('u_eyes_color'))
				{
					$change_fields .= ' eyes color;';
				}
				
				if ($nowd['hair'] != $this->input->post('u_hair'))
				{
					$change_fields .= ' hair color;';
				}
				
				if ($nowd['occupation'] != $this->input->post('u_occupation'))
				{
					$change_fields .= ' occupation;';
				}
				
				if ($nowd['religion'] != $this->input->post('u_religion'))
				{
					$change_fields .= ' religion;';
				}
				
				if ($nowd['education'] != $this->input->post('u_education'))
				{
					$change_fields .= ' education;';
				}
				
				if ($nowd['smoke'] != $this->input->post('u_smoking'))
				{
					$change_fields .= ' smoking;';
				}
				
				if ($nowd['drink'] != $this->input->post('u_drinking'))
				{
					$change_fields .= ' drinking;';
				}
				
				if ($nowd['hobbies'] != $this->input->post('u_hobbies'))
				{
					$change_fields .= ' hobbies;';
				}
				
				if ($nowd['about_me'] != $this->input->post('u_about'))
				{
					$change_fields .= ' about me;';
				}
				
				if ($nowd['about_partner'] != $this->input->post('u_partner'))
				{
					$change_fields .= ' about partner;';
				}
				///////////
				$updateDetails = array (
					'city'		=> $this->input->post('u_city'),
					'marriage'	=> $this->input->post('u_marital_status'),
					'children'	=> $this->input->post('u_children'),
					'height'	=> $this->input->post('u_height'),
					'weight'	=> $this->input->post('u_weight'),
					'eyes'		=> $this->input->post('u_eyes_color'),
					'hair'		=> $this->input->post('u_hair'),
					'occupation'=> $this->input->post('u_occupation'),
					'religion'	=> $this->input->post('u_religion'),
					'education'	=> $this->input->post('u_education'),
					'smoke'		=> $this->input->post('u_smoking'),
					'drink'		=> $this->input->post('u_drinking'),
					'hobbies'	=> $this->input->post('u_hobbies'),
					'age_from'	=> $this->input->post('u_age_from'),
					'age_to'	=> $this->input->post('u_age_to'),
					'aoa'		=> $this->input->post('u_aoa'),
					'about_me'	=> $this->input->post('u_about'),
					'about_partner'=> $this->input->post('u_partner'),
					'english'	=> $this->input->post('u_english')
				);
				
				$this->profModel->updateProfile($updateProfile, $updateDetails, $user_id, '2');
				$this->mainModel->insertLog($this->partId, '2', sprintf($this->lang->line('log_part_change_ank') . ' ' . $change_fields, $user_id));
				
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('partner_prof_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('partner_prof_false'));
			}
		}
		
		if ($id)
		{
			$info = $this->mainModel->getUserProfile($id);
			
			if ($info != false && $info['is_agency'] == $this->partId)
			{
				$details = $this->profModel->getUserDetails($info['id'], $info['sex']);
				
				$other['country'] 	= $this->_createCountry($info['country']);
				$other['edu']		= $this->_createEducationLevel($details['education']);
				$other['marry']		= $this->_createMarriage($details['marriage']);
				$other['height']	= $this->_createHeight($details['height']);
				$other['weight']	= $this->_createWeight($details['weight']);
				$other['eyes']		= $this->_createEyesColor($details['eyes']);
				$other['hair']		= $this->_createHairColor($details['hair']);
				$other['smoking']	= $this->_createSmokingDrinking(1, $details['smoke']);
				$other['drinking']	= $this->_createSmokingDrinking(2, $details['drink']);
				$other['day']		= $this->_createDay($info['b_day']);
				$other['month']		= $this->_createMonth($info['b_month']);
				$other['year']		= $this->_createYear($info['b_year']);
				$other['religion']	= $this->_createReligion($details['religion']);
				$other['child']		= $this->_createChildren($details['children']);
				$other['english']	= $this->_createEnglish($details['english']);
				$other['age_from']	= $this->_createSearchAge(1, $details['age_from']);
				$other['age_to']	= $this->_createSearchAge(2, $details['age_to']);
				
				
				$this->layout('partner', 'partner/ankets/change_profile_view', array('other' => $other, 'info' => $info, 'details' => $details, 'resInfo' => $resInfo), $this->lang->line('partner_prof_title'));
			}
			else
			{
				show_404();
				return false;
			}
		}
	}
	
	function _createSearchAge($type, $selected = 18)
	{
		$list = createMinMaxAge();
		$class = 'class="form-control"';
		// минимальный возраст в поиске
		if ($type == 1)
		{
			return form_dropdown('u_age_from', $list, $selected, $class);
		}
		elseif ($type == 2)
		{
			return form_dropdown('u_age_to', $list, $selected, $class);
		}
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
		$class = 'class="form-control"';
		
		return form_dropdown('u_month', $list, $selected, $class);
	}
	
	function _createYear($selected = '1995')
	{
		$list = getSelectYear();
		$class = 'class="form-control"';
		
		return form_dropdown('u_year', $list, $selected, $class);
	}
	
	function _createDay($selected = 1)
	{
		$list = getSelectDays();
		$class = 'class="form-control"';
		
		return form_dropdown('u_day', $list, $selected, $class);
	}
	
	function _createCountry($selected)
	{
		$list = userCountry();
		$class = 'class="form-control"';
		
		return form_dropdown('u_country', $list, $selected, $class);
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
	
	
	function ajax($action)
	{
		if ($action == 'cancel_approve')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$w_id = (int)$this->input->post('id');
				
				if ($this->pModel->cancelApprove($w_id, $this->partId) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'add_to_active')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$w_id = $this->input->post('id');
				
				if ($this->pModel->addToApprove($w_id, $this->partId) != false)
				{
					echo json_encode(array('result' => 'success', 'message' => $this->lang->line('partner_add_approve_ok')));
				}
			}
		}
		
		elseif ($action == 'disable')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$w_id = $this->input->post('id');
				
				if ($this->pModel->disableAnket($w_id, $this->partId) != false)
				{
					$this->mainModel->insertLog($this->partId, '2', sprintf($this->lang->line('log_part_dis_ank'), $w_id));
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'delete_avatar')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$photoNameToDelete = $this->mainModel->getUserProfile($this->input->post('id'));
				
				$file_name = './profiles/photo/user_' . $photoNameToDelete['id'] . '/' . $photoNameToDelete['photo_link'];
				
				@unlink($file_name . '_100.jpg');
				@unlink($file_name . '_101.jpg');
				@unlink($file_name . '_220.jpg');
				@unlink($file_name . '_240.jpg');
				@unlink($file_name . '_342.jpg');
				@unlink($file_name . '_original.jpg');
				
				$this->profModel->deleteAvatar($photoNameToDelete['id']);
				
				echo json_encode(array('result' => 'success', 'message' => $this->lang->line('partner_avatar_deleted')));
			}
		}
		
		elseif ($action == 'delete_photo')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$imgName = $this->input->post('name');
				$u_id	 = $this->input->post('id');
				$file_name = './profiles/photo/user_' . $u_id . '/' . $imgName;
				
				if ($this->profModel->isUserPhoto($u_id, $imgName) == true)
				{
					@unlink($file_name . '_105.jpg');
					@unlink($file_name . '_170.jpg');
					@unlink($file_name . '_full.jpg');
					
					$this->profModel->deletePhoto($u_id, $imgName);
					
					echo json_encode(array('result' => 'success', 'message' => $this->lang->line('partner_photo_deleted')));
				}
			}
		}
		
		elseif ($action == 'delete_video')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$this->load->model('partner/video_model');
				$video = $this->input->post('id') . '.mp4';
				$user = $this->input->post('user');
			
				$isExists = $this->video_model->isVideoExist($video, $user);
			
				if ($isExists == true)
				{
					$this->video_model->deleteVideo($user, $video);
				
					unlink('./profiles/video/user_'. $user .'/'. $video);
				
					echo json_encode(array('result' => 'success'));
				}
			}
		}
	}
	
	public function delete($userId)
	{
		if ($userId && intval($userId))
		{
			$check = $this->mainModel->getUserProfile($userId);
			
			if ($check != false && $this->partId == $check['is_agency'])
			{
				// удаляем фотографии
				$photos = $this->db->get_where('user_photos', array('id' => $userId))->result_array();
				
				foreach ($photos as $photo)
				{
					unlink('./profiles/photo/user_' . $userId . '/' . $photo['photo_name'] . '_105.jpg');
					unlink('./profiles/photo/user_' . $userId . '/' . $photo['photo_name'] . '_170.jpg');
					unlink('./profiles/photo_user_' . $userId . '/' . $photo['photo_name'] . '_full.jpg');
					
					$this->db->delete('user_photos', array('id' => $userId, 'photo_name' => $photo['photo_name']));
				}
				
				// удаляем видео
				$videos = $this->db->get_where('user_videos', array('id' => $userId))->result_array();
				
				foreach ($videos as $video)
				{
					unlink('./profiles/video/user_' . $userId . '/' . $video['video_name']);
					
					$this->db->delete('user_videos', array('id' => $userId, 'video_name' => $video['video_name']));
				}
				
				// удаляем информацию
				$this->db->delete('user_profile', array('id' => $userId));
				$this->db->delete('user_passport', array('user_id' => $userId));
				$this->db->delete('private_messages', array('from_user_id' => $userId));
				$this->db->delete('private_messages', array('to_user_id' => $userId));
				$this->db->delete('user_chat_messages', array('from_id' => $userId));
				$this->db->delete('user_favorites', array('fav_id' => $userId));
				
				redirect(base_url() . 'partner/ankets/');
			}
		}
	}
}