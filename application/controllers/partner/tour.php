<?php

Class Tour extends MY_Controller
{
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
		$this->lang->load('english/partner');
		$this->load->library('form_validation');
	}
	
	/* Все туры */
	function index()
	{
		// заберем все туры данного агенства
		$tours = $this->pModel->getAgencyTours($this->partId);
		
		$this->layout('partner', 'partner/tour/all_view', array('tour' => $tours), $this->lang->line('all_tours_title'));
	}
	
	/* активные туры */
	
	function active()
	{
		$a_tours = $this->pModel->getAgencyActiveTours($this->partId);
		
		$this->layout('partner', 'partner/tour/active_view', array('tour' => $a_tours), $this->lang->line('active_tours_title'));
	}
	
	/* неактивные туры */
	
	function inactive()
	{
		$i_tours = $this->pModel->getAgencyActiveTours($this->partId, '2'); 
		
		$this->layout('partner', 'partner/tour/inactive_view', array('tour' => $i_tours), $this->lang->line('inactive_tours_title'));
	}
	
	/* подробное описание тура */
	
	function more($tour_id)
	{
		if ($tour_id)
		{
			// проверяем свой ли тур пытается открыть партнер
			if ($this->pModel->checkAgencyTour($tour_id, $this->partId))
			{
				// если свой - забираем из бд инфу и выкидываем вьювер
				$info = $this->pModel->agencyTourInfo($tour_id);
				// фотографии ужина 
				$ePhoto = $this->pModel->tourPhoto($info['photo_id'], 1);
				// фотографии квартиры
				$hPhoto = $this->pModel->tourPhoto($info['photo_id'], 2);
				// фотографии услуг
				$uPhoto = $this->pModel->tourPhoto($info['photo_id'], 3);
				
				$this->layout('partner', 'partner/tour/more_view', array('uphoto' => $uPhoto, 'hphoto' => $hPhoto, 'ephoto' => $ePhoto, 'info' => $info), $this->lang->line('more_tour_title'));
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}
	
	/* изменение тура */
	function change($id)
	{
		$resInfo = '';
		
		if ($this->input->post('c_tour'))
		{
			$tour_id = (int)$this->input->post('p_id');	
			
			$validRules = array (
				array (
					'field'	=> 'tr_o',
					'label'	=> 'tr_o',
					'rules'	=> 'required|numeric'
				)
				,
				array (
					'field'	=> 'tr_t',
					'label'	=> 'tr_t',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'tr_th',
					'label'	=> 'tr_th',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'dr_o',
					'label'	=> 'dr_o',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'dr_t',
					'label'	=> 'dr_t',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'm_price',
					'label'	=> 'm_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'a_price',
					'label'	=> 'a_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'e_price',
					'label'	=> 'e_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'house',
					'label'	=> 'house',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'house_info',
					'label'	=> 'house_info',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'bar',
					'label'	=> 'bar',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'bar_price',
					'label'	=> 'bar_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'uslugi',
					'label'	=> 'uslugi',
					'rules'	=> 'required'
				),
				array (
					'field' => 'uslugi_price',
					'label'	=> 'uslugi_price',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'airport',
					'label' => 'airport',
					'rules'	=> 'required'
				),
				array (
					'field' => 'city',
					'label'	=> 'city',
					'rules'	=> 'required'
				),
				array (
					'field' => 'tr_km',
					'label' => 'tr_km',
					'rules' => 'required'
				),
				array (
					'field' => 'tr_price',
					'label'	=> 'tr_price',
					'rules' => 'required|numeric'
				),
				array (
					'field' => 'eks',
					'label'	=> 'eks',
					'rules'	=> 'required'
				)
			);
			
			$this->form_validation->set_rules($validRules);
			
			if ($this->form_validation->run() != false)
			{
				//////////////////////////////////////////////////////
				$tour_data = array (
						'perevod_1'		=> $this->input->post('tr_o'),
						'perevod_8'		=> $this->input->post('tr_t'),
						'perevod_16'	=> $this->input->post('tr_th'),
						'driver_1'		=> $this->input->post('dr_o'),
						'driver_8'		=> $this->input->post('dr_t'),
						'driver_16'		=> $this->input->post('dr_th'),
						'morning'		=> $this->input->post('m_price'),
						'afternoon'		=> $this->input->post('a_price'),
						'evening'		=> $this->input->post('e_price'),
						'minibar_price'	=> $this->input->post('bar_price'),
						'minibar_items'	=> $this->input->post('bar'),
						'house_price'	=> $this->input->post('house'),
						'house_info'	=> $this->input->post('house_info'),
						'transfer_price'=> $this->input->post('tr_price'),
						'airport'		=> $this->input->post('airport'),
						'city'			=> $this->input->post('city'),
						'transfer_km'	=> $this->input->post('tr_km'),
						'uslugi'		=> $this->input->post('uslugi'),
						'uslugi_price'	=> $this->input->post('uslugi_price'),
						'eks'			=> $this->input->post('eks'),
				);
				
				$this->pModel->changeTour($tour_data, $tour_id, $this->partId);
				
				$resInfo = array('type' => 'success', 'text' => $this->lang->line('tour_change_ok'));
			}
			else
			{
				$resInfo = array('type' => 'error', 'text' => $this->lang->line('tour_false'));
			}
		}
		
		if ($id)
		{
			$info = $this->pModel->agencyTourInfo($id);
			
			if ($info != false && $info['p_id'] == $this->partId)
			{
				$this->layout('partner', 'partner/tour/change_view', array('info' => $info, 'resInfo' => $resInfo), $this->lang->line('tour_change_title'));
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}
	
	/* Добавление новых туров */
	function add()
	{
		$resInfo = '';
		
		// новый тур
		if ($this->input->post('add_tour'))
		{
			set_time_limit(0);
			ignore_user_abort(1);
			
			$validRules = array (
				array (
					'field'	=> 'tr_o',
					'label'	=> 'tr_o',
					'rules'	=> 'required|numeric'
				)
				,
				array (
					'field'	=> 'tr_t',
					'label'	=> 'tr_t',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'tr_th',
					'label'	=> 'tr_th',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'dr_o',
					'label'	=> 'dr_o',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'dr_t',
					'label'	=> 'dr_t',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'm_price',
					'label'	=> 'm_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'a_price',
					'label'	=> 'a_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'e_price',
					'label'	=> 'e_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'house',
					'label'	=> 'house',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'house_info',
					'label'	=> 'house_info',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'bar',
					'label'	=> 'bar',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'bar_price',
					'label'	=> 'bar_price',
					'rules'	=> 'required|numeric'
				),
				array (
					'field'	=> 'uslugi',
					'label'	=> 'uslugi',
					'rules'	=> 'required'
				),
				array (
					'field' => 'uslugi_price',
					'label'	=> 'uslugi_price',
					'rules'	=> 'required'
				),
				array (
					'field'	=> 'airport',
					'label' => 'airport',
					'rules'	=> 'required'
				),
				array (
					'field' => 'city',
					'label'	=> 'city',
					'rules'	=> 'required'
				),
				array (
					'field' => 'tr_km',
					'label' => 'tr_km',
					'rules' => 'required'
				),
				array (
					'field' => 'tr_price',
					'label'	=> 'tr_price',
					'rules' => 'required|numeric'
				),
				array (
					'field' => 'eks',
					'label'	=> 'eks',
					'rules'	=> 'required'
				)
			);
			
			// к форме должны быть прицеплены обязательно фотки
			if ($_FILES['e_photo']['name'] && $_FILES['h_photo']['name'] && $_FILES['u_photo']['name'])
			{
				$this->form_validation->set_rules($validRules);
				// если форма прошла валидацию начнем грузить фото
				if ($this->form_validation->run() != false)
				{
					$destination = './profiles/partner/p_' . $this->partId . '/';
					$tour_id	= md5(time() . $this->partId);
					// фото ужина
					$ePhoto = $_FILES['e_photo']['name'];
					$ePhoto_tmp = $_FILES['e_photo']['tmp_name'];
					// фото квартиры
					$hPhoto = $_FILES['h_photo']['name'];
					$hPhoto_tmp = $_FILES['h_photo']['tmp_name'];
					// фото услуг
					$uPhoto = $_FILES['u_photo']['name'];
					$uPhoto_tmp = $_FILES['u_photo']['tmp_name'];
					
					// есть ли нужная директория
					$isDir = (file_exists($destination)) ? true : false;
					$isIndex = (file_exists($destination . 'index.html')) ? true : false;
					
					if ($isDir == false)
					{
						@mkdir($destination, 0777, true);
					}
					
					if ($isIndex == false)
					{
						$file = @fopen($destination . 'index.html', 'w');
						@fwrite($file, 'Access forbidden');
						@fclose($file);
					}
					
					// грузим фото ужина
					foreach ($ePhoto as $key => $value)
					{
						if ($ePhoto_tmp[$key] != '')
						{
							$reName = md5($ePhoto_tmp[$key]) . '.jpg';
							$dest = $destination . $reName;

							move_uploaded_file($ePhoto_tmp[$key], $dest);

							$writeData = array(
								'p_id'			=> $this->partId,
								'photo_name'	=> $reName,
								'photo_type'	=> '1',
								'tour_id'		=> $tour_id
							);
							
							$this->pModel->addTourImage($writeData);
						}
					}
					
					// грузим фото квартиры
					foreach ($hPhoto as $h => $value)
					{
						if ($hPhoto_tmp[$h] != '')
						{
							$reName = md5($hPhoto_tmp[$h]) . '.jpg';
							$dest = $destination . $reName;
							
							move_uploaded_file($hPhoto_tmp[$h], $dest);
							
							$writeData = array (
								'p_id'		=> $this->partId,
								'photo_name'=> $reName,
								'photo_type'=> '2',
								'tour_id'	=> $tour_id
							);
							
							$this->pModel->addTourImage($writeData);
						}
					}
			
					// грузим фото услуг
					foreach ($uPhoto as $u => $value)
					{
						if ($uPhoto_tmp[$u] != '')
						{
							$reName = md5($uPhoto_tmp[$u]) . '.jpg';
							$dest = $destination . $reName;
							
							move_uploaded_file($uPhoto_tmp[$u], $dest);
							
							$writeData = array (
								'p_id'		=> $this->partId,
								'photo_name'=> $reName,
								'photo_type'=> '3',
								'tour_id'	=> $tour_id
							);
							
							$this->pModel->addTourImage($writeData);
						}
					}
					
					//////////////////////////////////////////////////////
					$tour_data = array (
						'perevod_1'		=> $this->input->post('tr_o'),
						'perevod_8'		=> $this->input->post('tr_t'),
						'perevod_16'	=> $this->input->post('tr_th'),
						'driver_1'		=> $this->input->post('dr_o'),
						'driver_8'		=> $this->input->post('dr_t'),
						'driver_16'		=> $this->input->post('dr_th'),
						'morning'		=> $this->input->post('m_price'),
						'afternoon'		=> $this->input->post('a_price'),
						'evening'		=> $this->input->post('e_price'),
						'minibar_price'	=> $this->input->post('bar_price'),
						'minibar_items'	=> $this->input->post('bar'),
						'house_price'	=> $this->input->post('house'),
						'house_info'	=> $this->input->post('house_info'),
						'transfer_price'=> $this->input->post('tr_price'),
						'airport'		=> $this->input->post('airport'),
						'city'			=> $this->input->post('city'),
						'transfer_km'	=> $this->input->post('tr_km'),
						'uslugi'		=> $this->input->post('uslugi'),
						'uslugi_price'	=> $this->input->post('uslugi_price'),
						'eks'			=> $this->input->post('eks'),
						'photo_id'		=> $tour_id,
						'add_date'		=> time(),
						'p_id'			=> $this->partId
					);
					
					$this->pModel->addNewTour($tour_data);
					
					$resInfo = array ('type' => 'success', 'text' => $this->lang->line('tour_ok'));
				}
				else
				{
					$resInfo = array ('type' => 'danger', 'text' => $this->lang->line('tour_false'));
				}
			}
			else
			{
				$resInfo = array ('type' => 'danger', 'text' => $this->lang->line('tour_no_photo'));
			}
		}
		
		$this->layout('partner', 'partner/tour/add_view', array('resInfo' => $resInfo), $this->lang->line('tour_add_title'));
	}
	
	
	function ajax($action)
	{
		if ($action == 'make_active')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				if ($this->pModel->setActiveTour($this->input->post('id'), $this->partId) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => 'Server error. Try again'));
				}
			}
		}
		
		elseif ($action == 'make_deactive')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				if ($this->pModel->setDeactiveTour($this->input->post('id'), $this->partId) != false)
				{
					$this->mainModel->insertLog($this->partId, '2', sprintf($this->lang->line('log_part_tour'), $this->input->post('id')));
					echo json_encode(array('result' => 'success'));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => 'Server error'));
				}
			}
		}
	}
}