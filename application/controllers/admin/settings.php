<?php

Class Settings extends MY_Controller
{
	var $resInfo;
	
	private $mime = array('image/jpg', 'image/png', 'image/jpeg');
	private $error;
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			return false;
		}
		
		$this->load->model('admin/admin_model', 'aModel');
		$this->lang->load('english/admin');
		$this->load->library('form_validation');
	}
	
	function index()
	{
		if ($this->input->post('update'))
		{
			$rules = array(
				array (
					'field' => 's_title',
					'label'	=> 'Site title',
					'rules'	=> 'required'				
				),
				array (
					'field'	=> 's_mob_title',
					'label'	=> 'Mobile title',
					'rules'	=> 'required'	
				),
				array (
					'field'	=> 's_email',
					'label'	=> 'Contact email',
					'rules'	=> 'required|valid_email'					
				),
				array (
					'field'	=> 's_image',
					'label'	=> 'Max image size',
					'rules'	=> 'required|integer'					
				),
				array (
					'field'	=> 's_keywords',
					'label'	=> 'Meta keywords',
					'rules'	=> 'required'					
				),
				array (
					'field'	=> 's_desc',
					'label'	=> 'Meta description',
					'rules'	=> 'required'	
				)
			);
			
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run() != false)
			{				
				if ($this->input->post('s_image') > 0)
				{
					$change = false;
					/* Загрузка водяного знака */
					if (isset($_FILES['watermark']['name']))
					{
						if (in_array($_FILES['watermark']['type'], $this->mime))
						{
							$dir = './content/img/';
							$upfile = $dir . basename($_FILES['watermark']['name']);
							
							if (move_uploaded_file($_FILES['watermark']['tmp_name'], $upfile))
							{
								$change = true;
								$new_file = basename($_FILES['watermark']['name']);
								
								// Удалим старый
								unlink($dir . $this->engine['engine_watermark']);
							}
						}	
					}
					
					$update = array(
						'engine_title'		=> $this->input->post('s_title'),
						'engine_mobile_title'=> $this->input->post('s_mob_title'),
						'engine_email'		=> $this->input->post('s_email'),
						'engine_keywords'	=> $this->input->post('s_keywords'),
						'engine_description'=> $this->input->post('s_desc'),
						'engine_max_image'	=> $this->input->post('s_image'),
						'engine_is_logs'	=> $this->input->post('s_logs'),
						'engine_is_backup'	=> $this->input->post('s_backup'),
						'engine_is_partner'	=> $this->input->post('s_partner'),
						'engine_watermark'	=> ($change == true) ? $new_file : $this->engine['engine_watermark']
					);
					
					$this->aModel->updateMainSettings($update);
					$this->engine = $update;	
					
					$this->resInfo = array('type' => 'success', 'text' => $this->lang->line('settings_ok'));
				}
				else 
				{
					$this->resInfo = array('type' => 'error', 'text' => $this->lang->line('settings_img_fail'));
				}
			}
			else
			{
				$this->resInfo = array('type' => 'error', 'text' => $this->lang->line('settings_fail'));
			}
		}
		
		$this->layout('admin', 'admin/settings/settings_view', array('resInfo' => $this->resInfo), $this->lang->line('settings_title'));
	}
	
	public function prices()
	{
		$resInfo = '';
		if ($this->input->post())
		{
			foreach($this->input->post() as $post => $value)
			{
				$this->db->update('prices', array('value' => $value), array('key' => $post));
			}
			
			$resInfo = array('type' => 'success', 'text' => 'Настройки обновлены');
		}
		
		$prices = $this->db->get('prices')->result_array();
		
		$this->layout('admin', 'admin/settings/prices_view', array('prices' => $prices, 'resInfo' => $resInfo));
	}
	
	public function gifts()
	{
		$this->layout('admin', 'admin/settings/gifts/index_view', array());
	}
	
	public function gift($gift_id)
	{
		if ($this->input->post())
		{
			$prices = '';
			
			foreach($this->input->post('price') as $price)
			{
				$prices .= $price . ',';
			}
			
			$prices = substr($prices, 0, -1);
			
			$this->db->update('gift_price', array('prices' => $prices), array('giftId' => $gift_id));
			$data['resInfo'] = array('type' => 'success', 'text' => 'Настройки успешно сохранены.');
		}
		
		$data['info'] = $this->db->get_where('gift_price', array('giftId' => $gift_id))->row_array();
		switch($gift_id)
		{
			case 1:
			case 2:
			case 3:
			case 5:
			case 6:
				$this->layout('admin', 'admin/settings/gifts/roses_view', $data);
				break;
			case 4:
			case 7:
			case 8:
			case 9:
			case 10:
			case 11:
			case 12:
			case 13:
			case 14:
			case 16:
			case 17:
			case 18:
			case 19:
			case 20:
			case 21:
			case 23:
				$this->layout('admin', 'admin/settings/gifts/one_price_view', $data);
				break;
			case 15:
				$this->layout('admin', 'admin/settings/gifts/perfume_view', $data);
				break;
			case 22:
				$this->layout('admin', 'admin/settings/gifts/jewelery_view', $data);
				break;
			default:
				redirect('/admin/settings/gifts');
				break;				
		}
	}
}