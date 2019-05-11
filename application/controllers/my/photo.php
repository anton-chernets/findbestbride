<?php


/*** Фотографии аккаунта, смена аватара *********/

Class Photo extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth == false)
		{
			redirect(base_url());
			die;
		}
		
		if ($this->userInfo['is_agency'] != '0')
		{
			redirect(base_url() . 'my/profile/');
			die;
		}
		
		$this->lang->load($this->language . '/profile');
		$this->load->model('profile_model', 'pModel');
	}
	
	function index()
	{
		$resultInfo = '';
		
		/********** Загрузка фотографий ************/
		if ($this->input->post('uploadPhoto'))
		{
			$upload['upload_path']	= './profiles/photo/user_' . $this->selfId . '/';
			$upload['allowed_types']= 'jpg|jpeg';
			$upload['max_size']		= 1024 * $this->engine['engine_max_image'];
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
						$this->pModel->saveNewPhoto($this->selfId, $uploadData['raw_name']);
						
						//unlink($uploadData['full_path']);
						
						$resultInfo = array('type' => 'success', 'message' => $this->lang->line('profile_photo_uploaded'));
					}
					else 
					{
						unlink($uploadData['full_path']);
						$resultInfo = array('type' => 'error', 'message' => $this->lang->line('profile_main_avatar_error'));
					}
				}
				else
				{
					unlink($uploadData['full_path']);
					$resultInfo = array('type' => 'error', 'message' => 'Error. Minimal resolution of photo: 1920x1280');
				}
			}
			else
			{
				$resultInfo = array('type' => 'error', 'message' => $this->upload->display_errors());
			}
		}
		
		/*******************************************/
		
		/****************** Удаление фотографий *****************/
		if ($this->input->post('deleteThisPhoto'))
		{
			$imgId = $this->input->post('deleteThisPhoto');
			
			if ($this->pModel->isUserPhoto($this->selfId, $imgId) == true)
			{
				$pInfo = $this->pModel->getPhotoInfo($this->selfId, $imgId);
				
				if ($pInfo['photo_server'] == 1)
				{
					$this->pModel->deletePhoto($this->selfId, $imgId);
				
					unlink('./profiles/photo/user_' . $this->selfId . '/' . $imgId . '_full.jpg');
					unlink('./profiles/photo/user_' . $this->selfId . '/' . $imgId . '_105.jpg');
					unlink('./profiles/photo/user_' . $this->selfId . '/' . $imgId . '_170.jpg');
					@unlink('./profiles/photo/user_' . $this->selfId . '/' . $imgId . '.jpg');
				}
				elseif ($pInfo['photo_server'] == 2)
				{
					$this->load->library('api');
					
					$token = md5('photo' . $imgId . $this->selfId);
					
					$req = $this->api->request('delete_photo/'.$imgId.'/'.$this->selfId.'/'.$token);
				}
				
				
				$resultInfo = array('type' => 'success', 'message' => $this->lang->line('profile_main_avatar_deleted'));
			}
		}
		/************************************************************/
		
		$photoCount = $this->pModel->getMyPhotoCount($this->selfId);
		$userPhotos = $this->pModel->getUserPhotos($this->selfId);
		
		$this->layout('profile', 'profile/user_photos_view', array('resInfo' => $resultInfo, 'pCount' => $photoCount, 'photos' => $userPhotos), $this->lang->line('profile_photo_title'));
	}
}