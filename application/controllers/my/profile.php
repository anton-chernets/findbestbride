<?php


Class Profile extends MY_Controller
{
	
	var $maxAvatarSize = 1024;
	
	function __construct()
	{
		parent::__construct();
		
		/** ���� �� ������������� - ������� ������ �� ������� **/
		if ($this->isAuth == false)
		{
			redirect(base_url());
			die;
		}
		
		$this->lang->load($this->language . '/profile');
		$this->load->model('profile_model', 'pModel');
	}
	
	function index()
	{
		$returnInfo = '';
		
		/******* �������� ������� **************/
		if ($this->input->post('uploadMyAvatar'))
		{			
			$upload['upload_path']	= './profiles/photo/user_'.$this->selfId.'/';
			$upload['allowed_types']= 'jpg|jpeg';
			$upload['max_size']		= $this->maxAvatarSize * $this->engine['engine_max_image'];
			$upload['encrypt_name']	= true;
			
			$this->load->library('upload', $upload);
			$this->load->helper('create_avatars');
			
			// ���� ���������� ��� ��� - ��������
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
				
				if ($uploadData['image_width'] >= 640 && $uploadData['image_height'] >= 960)
				{
				
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
					
					// �������� ��������� �����
					// ����� ����� �������� 5 ��������?
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
					
					// ���� ��� ��������� ��������� - ��������� � ��, �������� �������
					if ($createAvatar['0'] == true)
					{
						$this->pModel->updateAvatarName($this->selfId, $uploadData['raw_name']);
						
						unlink($uploadData['full_path']);
						
						$returnInfo = array('type' => 'success', 'message' => $this->lang->line('profile_main_avatar_success'));
					}
					// ���� ���� �� ���� ��������� �� ��������� - ������ ��� � ���������� ������
					else 
					{
						unlink($uploadData['full_path']);
						
						$returnInfo = array('type' => 'error', 'message' => $this->lang->line('profile_main_avatar_error'));
					}
				}
				else
				{
					$returnInfo = array('type' => 'error', 'message' => 'Error. Minimal resolution of image: 640x960.');
				}
			}
			else
			{
				$returnInfo = array('type' => 'error', 'message' => $this->upload->display_errors());
			}
		}
		
		/********** �������� ������� ***************/
		if ($this->input->post('deleteMyAvatar'))
		{
			# ������ ������ �� ������ � ��
			$this->pModel->deleteAvatar($this->selfId);
			# ������ ������������ ���� � ��� ���������
			//unlink('./profile/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '.jpg');
			unlink('./profiles/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '_220.jpg');
			unlink('./profiles/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '_100.jpg');
			unlink('./profiles/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '_342.jpg');
			unlink('./profiles/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '_240.jpg');
			#unlink('./profiles/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '_105.jpg');
			unlink('./profiles/photo/user_' . $this->selfId . '/' . $this->userInfo['photo_link'] . '_original.jpg');
			
			$returnInfo = array('type' => 'success', 'message' => $this->lang->line('profile_main_avatar_deleted'));
			$this->userInfo['photo_link'] = '';
		}
		
		/**********************************************/
		
		$this->layout('profile', 'profile/profile_main_view', array('resInfo' => $returnInfo), $this->lang->line('profile_main_title'));
	}
	
	
	
	
	
	
	
	/********************* � � � � � �      � � � � � � � *********************/
	
	function preview()
	{
		$this->load->library('assistant');
		
		$photo = ($this->pModel->getMyPhotoCount($this->selfId) > 0) ? $this->pModel->getUserPhotos($this->selfId) : '0';
		
		// ���� ����� - ���� ��� � ������, ���� ������� -  ������
		if ($this->userInfo['sex'] == 2)
		{
			$details = $this->pModel->getUserDetails($this->selfId, '2');
			// ���� �� � ������� �����-�����������?
			$presentation = $this->pModel->getVideoInfo($this->selfId);
			
			$this->layout('profile', 'profile/preview/women_profile_preview', array('photo' => $photo, 'details' => $details, 'is_video' => $presentation['count'], 'video' => $presentation['data']), $this->lang->line('profile_prev_title'));
		}
		
		elseif ($this->userInfo['sex'] == 1)
		{
			$details = $this->pModel->getUserDetails($this->selfId, '1');
			if ($details['age_from'] != '' && $details['age_to'] != '')
			{
				$showLike = $this->pModel->getLikeLadies($details['age_from'], $details['age_to']);
			}
			else
			{
				$showLike = '0';
			}
			
			$this->layout('profile', 'profile/preview/man_profile_preview', array('showLike' => $showLike, 'photo' => $photo, 'details' => $details), $this->lang->line('profile_prev_title'));	
		}	
	}
	
	
	
	
	
	/************************ � � � � �     � � � � � � � � � � � *******************/
	// �������� ������ ��������
	function video()
	{
		if ($this->userInfo['sex'] == 1)
		{
			redirect(base_url() . 'my/profile/');
			die;
		}
		
		$resInfo = '';
		
		if ($this->input->post('uploadVideo'))
		{	
			$upload['upload_path'] 	= './profiles/video/user_'.$this->selfId.'/';
			$upload['allowed_types']= 'mp4';
			$upload['max_size']		= 1024 * 200;
			$upload['encrypt_name']	= true;
			
			$this->load->library('upload', $upload);
			
			// ���� ���������� � ����� ��� - ��������
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
			
			// ���� ����� ��� ����, � ��� ����� ������ ��������
			// ������� ������ ����� ��������� ������
			$checkOld = $this->pModel->getVideoInfo($this->selfId);
			
			if ($checkOld['count'] > 0)
			{
				$info = $checkOld['data'];
				$this->pModel->deleteVideo($this->selfId, $info['video_name']);
				unlink('./profiles/video/user_'. $this->selfId .'/'. $info['video_name']);
			}
			// ������ ��������� �����
			if ($this->upload->do_upload())
			{
				ignore_user_abort(1);
				set_time_limit(0);
				
				$upData = $this->upload->data();
				
				$newVideo = array (
					'video_name' => $upData['file_name'],
					'id'		 => $this->selfId,
					'add_date'	 => time(),
					'mime_type'	 => $upData['file_type'],
					'approved'	 => '0'
				);
				
				$this->pModel->createNewVideo($newVideo);
				
				$resInfo = array('type' => 'success', 'message' => $this->lang->line('profile_video_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'message' => $this->upload->display_errors());
			}
		}
		
		$getVideo = $this->pModel->getVideoInfo($this->selfId);
		
		$this->layout('profile', 'profile/user_video_view', array('resInfo' => $resInfo, 'isExist' => $getVideo['count'], 'videoInfo' => $getVideo['data']), $this->lang->line('profile_video'));
	}
	
	
	function delete_video()
	{
		if (IS_AJAX && $this->input->post('id'))
		{
			$video = $this->input->post('id');
			
			$isExists = $this->pModel->getVideoInfo($this->selfId, $video);
			
			if ($isExists == true)
			{
				$this->pModel->deleteVideo($this->selfId, $video);
				
				unlink('./profiles/video/user_'. $this->selfId .'/'. $video);
				
				echo json_encode(array('result' => 'success', 'message' => $this->lang->line('profile_video_deleted')));
			}
			else
			{
				echo json_encode(array('result' => 'error', 'message' => $this->lang->line('profile_video_error')));
			}
		}
		else
		{
			show_404();
		}
	}
	
	/*********************************** ����������� **************************************/
	function invite()
	{
		$resInfo = '';
		
		if ($this->input->post('sent'))
		{
			$this->load->library('form_validation');
			
			$rules = array(
				array(
					'field'	=> 'name',
					'label'	=> 'invited user name',
					'rules'	=> 'required'		
				),
				array(
					'field'	=> 'email',
					'label'	=> 'invited user email',
					'rules'	=> 'required|valid_email'		
				)
			);
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run() != false)
			{
				$email = $this->input->post('email');
				$checkInvite = $this->pModel->checkThisInvite($email, $this->selfId);
				
				if ($checkInvite != false)
				{
					$inviteDbData = array(
						'from_id'	=> $this->selfId,
						'to_email'	=> $email,
						'date'		=> date('Y-m-d H:i:s')	
					);
					
					// ���������� ��������� �� ����
					$this->load->library('email', array('mailtype' => 'html'));
					
					$this->email->from('no-reply@testc4l.site');
					$this->email->to($email);
					$this->email->subject('Your friend '. $this->userInfo['name'] .' was sent invite to you!');
					
					$mailBody = '
						<html>
							<body>
								Dear <b>' . $this->input->post('name') . '</b>!<br/><br/>
								Your friend '.$this->userInfo['name'].' '.$this->userInfo['lastname'].' invites
								you to visit the site <a href="' . base_url() . '" target="_blank">testc4l.site</a>.<br/><br/>
								<a href="' . base_url() . '" target="_blank">testc4l.site</a> it\'s a unique opportunity to meet
								your soul mate through the Internet. Register for FREE, fill in the form and receive hundreds of
								proposals to get acquaited every day!<br/><br/>
								To go to the website <a href="' . base_url() . '" target="_blank">CLICK HERE</a>.<br/><br/>
					
								If you need help click here: <a href="' . base_url() . 'support/">SUPPORT</a><br/><br/>
								Sincerely, Administration<br/>
								<a href="' . base_url() . '" target="_blank">testc4l.site</a>
								<br/><br/>
								<p align="center">***THIS MESSAGE WAS SENT AUTOMATICALLY, DONT ANSWER TO IT***</p>
							</body>
						</html>
					';
					
					$this->email->message($mailBody);
					$this->email->send();
					$this->pModel->insertInvite($inviteDbData);
					//log add
					$this->mainModel->insertLog($this->selfId, '1', 'User was sent invite to email: '. $email);
					
					$resInfo = array('type' => 'success', 'message' => 'Your invite was successfully sent. Thank you!');
				}
				else 
				{
					$resInfo = array('type' => 'error', 'message' => 'You already sent invite to this email.');
				}
			}
			else
			{
				$resInfo = array('type' => 'error', 'message' => 'Please, fill the form correctly.');
			}
		}
		
		
		$this->layout('profile', 'profile/invite_view', array('resInfo' => $resInfo), 'Invite your friend');
	}
}