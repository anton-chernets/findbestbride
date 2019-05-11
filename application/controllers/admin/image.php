<?php

Class Image extends MY_Controller
{
	var $result;
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			return false;
		}
		
		$this->lang->load('english/admin');
		$this->load->helper('create_avatars');
	}
	
	public function edit()
	{
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		
		$image_info = json_decode(base64_decode($this->uri->segment(4)), true);
		$back = base64_decode($this->uri->segment(6));
		
		if ($this->input->post())
		{
			if (!$this->input->post('crop') && $this->input->post('rotate'))
			{
				$this->load->library('image_lib');
				
				/** ÏÎÂÎÐÎÒ ÍÀËÅÂÎ **/
				if ($this->input->post('tp') == 'left')
				{
					if ($image_info['type'] == 'avatar')
					{
						$link = $this->mainModel->getUserProfile($image_info['id']);
						$link = $link['photo_link'];
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_original.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						if(!$this->image_lib->rotate()) { $this->image_lib->display_errors(); }
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_100.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_101.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_220.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_240.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_342.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
					}
					elseif ($image_info['type'] == 'image')
					{
						$link = $this->db->get_where('user_photos', array('id' => $image_info['id'], 'photo_name' => $image_info['photo_name']))->row_array();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link['photo_name'].'_full.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link['photo_name'].'_105.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						
						$this->image_lib->clear();
						
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link['photo_name'].'_170.jpg';
						$config['rotation_angle'] = '90';
						
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						
						$this->image_lib->clear();
					}
					
					$this->result = $this->lang->line('image_rotate_ok');
				}
				/** ÏÎÂÎÐÎÒ ÍÀÏÐÀÂÎ **/
				else
				{
					if ($image_info['type'] == 'avatar')
					{
						$link = $this->mainModel->getUserProfile($image_info['id']);
						$link = $link['photo_link'];
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_original.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						if(!$this->image_lib->rotate()) { $this->image_lib->display_errors(); }
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_100.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_101.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_220.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_240.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_342.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
						$this->image_lib->clear();
					}
					elseif ($image_info['type'] == 'image')
					{
						$link = $this->db->get_where('user_photos', array('id' => $image_info['id'], 'photo_name' => $image_info['photo']))->row_array();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link['photo_name'].'_full.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
					
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link['photo_name'].'_105.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
					
						$this->image_lib->clear();
					
						$config['source_image'] = './profiles/photo/user_'.$image_info['id'].'/'.$link['photo_name'].'_170.jpg';
						$config['rotation_angle'] = '270';
					
						$this->image_lib->initialize($config);
						$this->image_lib->rotate();
					
						$this->image_lib->clear();
					}
						
					$this->result = $this->lang->line('image_rotate_ok');
				}
			}
			// ÎÁÐÅÇÊÀ
			elseif (!$this->input->post('rotate') && $this->input->post('crop'))
			{
				// AVATAR
				if ($image_info['type'] == 'avatar')
				{
					$link = $this->mainModel->getUserProfile($image_info['id']);
					$link = $link['photo_link'];
					$targ_w = 350;
					$targ_h = 450;
					
					$src = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_original.jpg';
					$folder = './profiles/photo/user_'.$image_info['id'].'/';
					$raw_name = $link;
					
					$img_r = imagecreatefromjpeg($src);
					$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
					
					imagecopyresampled($dst_r, $img_r, 0, 0, $this->input->post('x'), $this->input->post('y'),
					$targ_w, $targ_h, $this->input->post('w'), $this->input->post('h'));
					
					imagejpeg($dst_r, $src, 95);
					
					$photoSettings = array (
						'thumbs' => array (
							array('w' => '220', 'h' => '220', 'name' => $raw_name . '_220', 'ext' => '.jpg', 'crop' => true),
							array('w' => '100', 'h' => '148', 'name' => $raw_name . '_100', 'ext' => '.jpg', 'crop' => true),
							array('w' => '342', 'h' => '500', 'name' => $raw_name . '_342', 'ext' => '.jpg', 'crop' => true),
							array('w' => '240', 'h' => '360', 'name' => $raw_name . '_240', 'ext' => '.jpg', 'crop' => true),
							array('w' => '100', 'h' => '100', 'name' => $raw_name . '_101', 'ext' => '.jpg', 'crop' => true)			
						),
						'crop' => true,
						'newimg' => array (
							array ('max_w' => '342', 'max_h' => '999999', 'name' => $raw_name . '_original')
						),
						'newimg_folder' => $folder,
						'thumb_folder'	=> $folder,
						'saveNewimg'	=> '1',
						'saveThumb'		=> '1'
					);
					createAvatar($src, $photoSettings);
					
					redirect(base_url() . $back);
				}
				else
				{
					$link = $this->db->get_where('user_photos', array('id' => $image_info['id'], 'photo_name' => $image_info['photo']))->row_array();
					$link = $link['photo_name'];
					$targ_w = 600;
					$targ_h = 550;
						
					$src = './profiles/photo/user_'.$image_info['id'].'/'.$link.'_full.jpg';
					$folder = './profiles/photo/user_'.$image_info['id'].'/';
					$raw_name = $link;
						
					$img_r = imagecreatefromjpeg($src);
					$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
						
					imagecopyresampled($dst_r, $img_r, 0, 0, $this->input->post('x'), $this->input->post('y'),
					$targ_w, $targ_h, $this->input->post('w'), $this->input->post('h'));
						
					imagejpeg($dst_r, $src, 95);
						
					$photoSettings = array (
						'thumbs' => array (
							array('w' => '105', 'h' => '120', 'name' => $raw_name . '_105', 'ext' => '.jpg', 'crop' => true),
							array('w' => '170', 'h' => '156', 'name' => $raw_name . '_170', 'ext' => '.jpg', 'crop' => true)
						),
						'crop' => true,
						'newimg' => array (
								array ('max_w' => '600', 'max_h' => '999999', 'name' => $raw_name . '_full')
						),
						'newimg_folder' => $folder,
						'thumb_folder'	=> $folder,
						'saveNewimg'	=> '1',
						'saveThumb'		=> '1'
					);
					createAvatar($src, $photoSettings);
						
					redirect(base_url() . $back);
				}
			}
		}
		
		$image = $this->_imgInfo($image_info);
		
		$this->layout('admin', 'admin/image/edit_view', array('image' => $image, 'result' => $this->result), $this->lang->line('image_title'));
	}
	
	protected function _imgInfo($img = array(), $size = '_original')
	{
		switch ($img['type'])
		{
			case 'avatar':
				$info = $this->mainModel->getUserProfile($img['id']);
		
				$image = base_url() . 'profiles/photo/user_'.$img['id'].'/'.$info['photo_link'] . $size . '.jpg';
			break;
			
			case 'image':
				$info = $this->db->get_where('user_photos', array('id' => $img['id'], 'photo_name' => $img['photo']))->row_array();
				
				$image = base_url() . 'profiles/photo/user_'.$img['id'].'/'.$info['photo_name'].'_full.jpg';
			break;
		}
		
		return $image;
	}
}